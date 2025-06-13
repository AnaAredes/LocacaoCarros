<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BemLocavel;
use App\Models\Reserva;
use App\Services\Pagamento\PagamentoFactory;
use App\Services\Finders\ReservaDisponibilidadeFinder;
use App\Services\ReservaManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;

class PagamentoController extends Controller
{
    protected $disponibilidadeFinder;
    protected $reservaManager;

    /**
     * Construtor da classe PagamentoController.
     *
     * Inicializa a instância do serviço ReservaService para manipular informações da reserva.
    */
    public function __construct()
    {
        $this->disponibilidadeFinder = new ReservaDisponibilidadeFinder();
        $this->reservaManager = new ReservaManager();
    }

    /**
     * Inicia o processo de pagamento.
     *
     * @param \Illuminate\Http\Request $request contém os dados do pagamento.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Redireciona para o pagamento ou retorna uma view com erro.
    */
    public function iniciar(Request $request)
    {
        try {

            $bem_id = is_array(session('bem_id')) ? session('bem_id')['id'] : session('bem_id');

            // Processamento das datas e valores
            $dadosReserva = $this->processarDadosReserva($request, $bem_id);
            if ($dadosReserva['erro']) {
                return redirect()->back()->with('error', $dadosReserva['mensagem']);
            }

            $tipoPagamento = $request->input('tipo_pagamento'); // 'multibanco' ou 'paypal'
          
            // Validações
            if (!Auth::id() || !$bem_id || !in_array($tipoPagamento, PagamentoFactory::tiposDisponiveis())) {
                return redirect()->back()->with('error', 'Dados insuficientes ou tipo de pagamento inválido.');
            }

            // Criar o serviço de pagamento
            $servicoPagamento = PagamentoFactory::criar($tipoPagamento);

            // Preparar dados para o pagamento
            $dadosPagamento = [
                'valor' => $dadosReserva['valor'],
                'return_url' => route('pagamento.sucesso', ['tipo' => $tipoPagamento]),
                'cancel_url' => route('pagamento.cancelar', ['tipo' => $tipoPagamento]),
                'currency' => 'EUR'
            ];

            // Iniciar pagamento
            $resultado = $servicoPagamento->iniciar($dadosPagamento);

            if (!$resultado['success']) {
                return redirect()->back()->with('error', $resultado['message'] ?? 'Erro ao iniciar pagamento.');
            }

            // Guardar os dados na sessão
            $this->salvarDadosNaSessao($dadosReserva);

            // Redirecionar baseado no tipo de pagamento
            return $this->redirecionarParaPagamento($tipoPagamento, $resultado['data']);
        } catch (Exception $e) {
            logger()->error('Erro ao iniciar pagamento', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro interno. Tente novamente.');
        }
    }

    /**
     * Confirma o pagamento após a transação.
     *
     * @param \Illuminate\Http\Request $request contém os dados de confirmação do pagamento.
     * @param string $tipo Tipo de pagamento utilizado.
     * @return \Illuminate\View\View Redireciona para a página de sucesso ou retorna erro.
     */
    public function confirmar(Request $request, string $tipo)
    {
        try {
            $servicoPagamento = PagamentoFactory::criar($tipo);
            
            $dadosConfirmacao = [
                'token' => $request->input('token'),
                'valor' => session('valor_reserva'),
                'pagador' => Auth::user()->name
            ];
            
            $resultado = $servicoPagamento->confirmar($dadosConfirmacao);
            
            if (!$resultado['success']) {
                return redirect()->route('reserva.index')->with('error', $resultado['message']);
            }
            
            $reserva = $this->criarReserva();
            
            session([
                'pagamento_sucesso' => [
                    'amount' => $resultado['data']['valor'],
                    'payerName' => $resultado['data']['pagador'],
                    'metodo' => $resultado['data']['metodo'],
                    'reserva_id' => $reserva->id
                ]
            ]);
            
            return redirect()->route('pagamento.sucesso.view');
            
        } catch (Exception $e) {
            logger()->error('Erro ao confirmar pagamento', ['error' => $e->getMessage(), 'tipo' => $tipo]);
            return redirect()->route('reserva.index')->with('error', 'Erro ao confirmar pagamento.');
        }
    }
    
    public function mostrarSucesso()
    {
        $dadosSucesso = session('pagamento_sucesso');
        
        if (!$dadosSucesso) {
            return redirect()->route('reserva.index')->with('error', 'Sessão expirada.');
        }
        
        session()->forget('pagamento_sucesso');
        
        return view('reserva.sucesso', $dadosSucesso);
    }

    
    /**
     * Cancela o pagamento.
     *
     * @param \Illuminate\Http\Request $request Requisição para cancelar o pagamento.
     * @param string $tipo Tipo de pagamento utilizado.
     * @return \Illuminate\Http\RedirectResponse Redireciona para a página de reserva com erro.
    */
    public function cancelar(Request $request, string $tipo)
    {
        try {
            $servicoPagamento = PagamentoFactory::criar($tipo);
            $resultado = $servicoPagamento->cancelar([]);

            return redirect()->route('reserva.index')->with('error', $resultado['message']);
        } catch (Exception $e) {
            return redirect()->route('reserva.index')->with('error', 'Operação cancelada.');
        }
    }

    /**
     * Converte as datas, calcula as diárias,
     * verifica se o bem está disponível para reserva nas datas selecionadas,
     * obtém o bem locável pelo ID e calcula o valor total da reserva.
     *
     * @return array Retorna um array contendo informações de erro ou sucesso,
     *               detalhes da reserva e o valor total calculado.
    */
    private function processarDadosReserva(Request $request, $bem_id): array
    {
        $data_inicio = Carbon::parse($request->input('data_inicio'));
        $data_fim = Carbon::parse($request->input('data_fim'));
        $diarias = $data_inicio->diffInDays($data_fim) +1;

        // Verifica disponibilidade
        $disponivel = $this->disponibilidadeFinder->verificaDisponibilidade($bem_id, $data_inicio, $data_fim);
        if (!$disponivel) {
            return ['erro' => true, 'mensagem' => 'Viatura indisponível para as datas selecionadas.'];
        }

        // Busca o bem
        $bem = BemLocavel::find($bem_id);
        if (!$bem) {
            return ['erro' => true, 'mensagem' => 'Viatura não encontrada.'];
        }

        $valor = $diarias * $bem->preco_diario;

        return [
            'erro' => false,
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'valor' => $valor,
            'bem' => $bem
        ];
    }

    /**
     * Guarda os dados da reserva na sessão
    */
    private function salvarDadosNaSessao(array $dados): void
    {
        session()->forget(['data_inicio', 'data_fim', 'valor_reserva']);
        session()->put([
            'data_inicio' => $dados['data_inicio'],
            'data_fim' => $dados['data_fim'],
            'valor_reserva' => $dados['valor'],
        ]);
    }

    /* Redireciona para a etapa de pagamento.
    * PayPal: Redireciona para a URL de aprovação do pagamento.
    * Multibanco: Exibe a página contendo a referência do pagamento.
    */
    private function redirecionarParaPagamento(string $tipo, array $dados)
    {
        if ($tipo === 'paypal') {
            return redirect()->away($dados['approve_url']);
        }

        // Para Multibanco, mostrar a referência
        return view('reserva.pagamentos.referencia', $dados);
    }

    /* 
    * Cria uma nova reserva na DB.
    *
    * @return Reserva a instância da reserva recém-criada.
    */
    private function criarReserva(): Reserva
    {
        $bem_id = is_array(session('bem_id')) ? session('bem_id')['id'] : session('bem_id');

        $reserva = $this->reservaManager->create(Auth::id(), $bem_id, session('data_inicio'), session('data_fim'), session('valor_reserva'));

        session(['reserva_id' => $reserva->id]);

        return $reserva;
    }
}