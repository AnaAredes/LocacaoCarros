<?php

namespace App\Http\Controllers;

use App\Services\Finders\DisponibilidadeFinder;
use Illuminate\Http\Request;

class FiltroController extends Controller
{
    protected $bensFiltrados;

    /**
     * Construtor da classe FiltroController.
     *
     * Inicializa a instância do serviço FiltroService para manipulação dos filtros.
     */
    public function __construct()
    {
        $this->bensFiltrados = new DisponibilidadeFinder();
    }

    /**
     * Obtém a lista de bens disponíveis em uma cidade específica.
     *
     * @param string $cidade Nome da cidade para a busca.
     * @return array de bens disponíveis na cidade especificada.
     */
    public function um_local($cidade)
    {
        $disponiveis = $this->bensFiltrados->um_local($cidade);
        return $disponiveis;
    }

    /**
     * Filtra os bens disponíveis com base numa lista de cidades.
     *
     * @param array $cidades Lista de cidades para o filtro.
     * @return \Illuminate\View\View com os bens disponíveis e as cidades filtradas.
     */
    public function filtro_localizacao($cidades)
    {
        session()->forget('cidades');

        [$disponiveis, $cidadesArray] = $this->bensFiltrados->all_local($cidades);

        session([
            'cidades' => $cidadesArray,
            'disponiveis' => $disponiveis
        ]);

        return view('localizacoes', [
            'bens' => $disponiveis,
            'cidades' => $cidadesArray
        ]);
    }

    /**
     * Filtra todos os bens disponíveis com base em data e intervalo de preço.
     *
     * @param \Illuminate\Http\Request contém os filtros de data.
     * @return \Illuminate\View\View com os bens disponíveis.
     */
    public function all_avalible_filter(Request $request)
    {
        session()->forget('possivel_reserva');

        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        $intervalo = $this->getIntervaloPreco($request->input('preco') ?? '');
        $precoMin = $intervalo['precoMin'];
        $precoMax = $intervalo['precoMax'];

        $disponiveis = $this->bensFiltrados->all_avalible($dataInicio, $dataFim, $precoMin, $precoMax);

        session(['possivel_reserva' => [
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
        ]]);
        return view('disponiveis', ['bens' => $disponiveis]);
    }


    /**
     * Transforma o valor do input para o intervalo de preços (preço máximo e mínimo)
     */
    private function getIntervaloPreco($precoSelecionado)
    {
        if ($precoSelecionado) {
            switch ($precoSelecionado) {
                case '40-55':
                    $precoMin = 40;
                    $precoMax = 55;
                    break;
                case '55-70':
                    $precoMin = 55;
                    $precoMax = 70;
                    break;
                case '70-85':
                    $precoMin = 70;
                    $precoMax = 85;
                    break;
                case '85+':
                    $precoMin = 85;
                    $precoMax = null; // Sem limite máximo
                    break;
                default:
                    $precoMin = null;
                    $precoMax = null;
            }
        } else {
            $precoMin = null;
            $precoMax = null; // Se não houver seleção, buscar todos os preços
        }
        return compact('precoMin', 'precoMax');
    }

    /**
     * Filtra todos os bens disponíveis dentro de uma cidade específica com base em datas.
     *
     * @param array $cidades Lista de cidades para o filtro.
     * @param \Illuminate\Http\Request contém os filtros de data.
     * @return \Illuminate\View\View com os bens disponíveis e as cidades filtradas.
     */
    public function all_avalible_in_city($cidades, Request $request)
    {
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        
        $intervalo = $this->getIntervaloPreco($request->input('preco') ?? '');
        $precoMin = $intervalo['precoMin'];
        $precoMax = $intervalo['precoMax'];

        [$disponiveis, $cidadesArray] = $this->bensFiltrados->all_avalible_in_city($cidades, $dataInicio, $dataFim, $precoMin, $precoMax);

        session(['possivel_reserva' => [
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
        ]]);

        return view('localizacoes', [
            'bens' => $disponiveis,
            'cidades' => $cidadesArray
        ]);
    }
}
