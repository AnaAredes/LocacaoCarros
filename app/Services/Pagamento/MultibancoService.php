<?php

namespace App\Services\Pagamento;

class MultibancoService implements PagamentoInterface
{
    /**
     * Inicia um pagamento via Multibanco.
     *
     * @param array $dados do pagamento (espera-se que contenha 'valor' a pagar).
     * @return array Estrutura contendo status de sucesso e dados da entidade, referência e valor.
     */
    public function iniciar(array $dados): array
    {
        return [
            'success' => true,
            'data' => [
                'entidade' => '98000',
                'nome_entidade' => 'Rota Certa - Portugal',
                'referencia' => $this->gerarReferencia(),
                'valor' => $dados['valor'],
                'tipo' => 'multibanco'
            ]
        ];
    }

    /**
     * Simula a confirmação de pagamento via Multibanco.
     *
     * @param array $dados do pagamento. Pode conter:
     *                     - 'pagador' (string): nome do pagador (opcional).
     *                     - 'valor': valor pago.
     * @return array Estrutura de confirmação do pagamento.
     */
    public function confirmar(array $dados): array
    {
        // Simulação de confirmação para Multibanco (fictícia)
        return [
            'success' => true,
            'data' => [
                'status' => 'confirmado',
                'pagador' => $dados['pagador'] ?? 'Cliente Multibanco',
                'valor' => $dados['valor'],
                'metodo' => 'Multibanco'
            ]
        ];
    }

    /**
     * Cancela um pagamento via Multibanco.
     *
     * @param array $dados Dados do pagamento (não utilizados nesse contexto da simulação).
     * @return array Mensagem de cancelamento.
     */
    public function cancelar(array $dados): array
    {
        return [
            'success' => true,
            'message' => 'Pagamento via Multibanco cancelado.'
        ];
    }

    /**
     * Gera uma referência de pagamento aleatória para o sistema Multibanco.
     *
     * @return string referencia formatada.
     */
    private function gerarReferencia(): string
    {
        return implode(' ', str_split(str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT), 3));
    }
}
