<?php

namespace App\Services\Pagamento;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Exception;

class PPalService implements PagamentoInterface
{
    protected $provider;

    /**
     * Instancia o provedor PayPal e autentica usando as credenciais da configuração.
     */
    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }

    /**
     * Inicia um pagamento via PayPal.
     *
     * @param array $dados Deve conter 'valor', 'return_url', 'cancel_url' e opcionalmente 'currency'.
     * @return array Estrutura de resposta com sucesso e link de aprovação ou erro.
     */
    public function iniciar(array $dados): array
    {
        try {
            $response = $this->provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => $dados['return_url'],
                    "cancel_url" => $dados['cancel_url'],
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => $dados['currency'] ?? 'EUR',
                            "value" => $dados['valor']
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                $approveUrl = null;
                foreach ($response['links'] as $link) {
                    if ($link['rel'] == 'approve') {
                        $approveUrl = $link['href'];
                        break;
                    }
                }

                return [
                    'success' => true,
                    'data' => [
                        'order_id' => $response['id'],
                        'approve_url' => $approveUrl,
                        'tipo' => 'paypal'
                    ]
                ];
            }

            return [
                'success' => false,
                'message' => 'Erro ao criar ordem PayPal',
                'error' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro na comunicação com PayPal: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Confirma o pagamento realizado no PayPal.
     *
     * @param array $dados Deve conter o 'token' do pedido gerado no PayPal.
     * @return array Estrutura de confirmação com dados do pagador e status, ou erro.
     */
    public function confirmar(array $dados): array
    {
        try {
            $token = $dados['token'] ?? null;
            if (!$token) {
                return [
                    'success' => false,
                    'message' => 'Token do PayPal não encontrado. Operação cancelada.'
                ];
            }

            $response = $this->provider->capturePaymentOrder($token);

            if (($response['status'] ?? '') === 'COMPLETED') {
                $nameAmount = $this->extrairDadosPagador($response);

                return [
                    'success' => true,
                    'data' => [
                        'status' => 'confirmado',
                        'pagador' => $nameAmount['payerName'],
                        'valor' => $nameAmount['amount'],
                        'metodo' => 'PayPal',
                        'response' => $response
                    ]
                ];
            }

            return [
                'success' => false,
                'message' => 'Pagamento não foi completado. Operação cancelada.',
                'error' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao confirmar pagamento PayPal: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Cancela o processo de pagamento via PayPal.
     *
     * @param array $dados do pagamento.
     * @return array Mensagem de cancelamento.
     */
    public function cancelar(array $dados): array
    {
        return [
            'success' => true,
            'message' => 'Pagamento via PayPal foi cancelado pelo utilizador.'
        ];
    }

    /**
     * Extrai o nome do pagador e o valor do pagamento da resposta do PayPal.
     *
     * @param array $response Resposta da API PayPal.
     * @return array ['payerName' => string, 'amount' => string] 
     */
    private function extrairDadosPagador(array $response): array
    {
        $payerName = 'Cliente PayPal';
        $amount = '0.00';

        if (isset($response['payer']['name'])) {
            $firstName = $response['payer']['name']['given_name'] ?? '';
            $lastName = $response['payer']['name']['surname'] ?? '';
            $payerName = trim($firstName . ' ' . $lastName);
        }

        if (isset($response['purchase_units'][0]['payments']['captures'][0]['amount'])) {
            $amountData = $response['purchase_units'][0]['payments']['captures'][0]['amount'];
            $amount = $amountData['value'] ?? '0.00';
        }

        return compact('payerName', 'amount');
    }
}
