<?php

namespace App\Services\Finders;

use App\Repository\FiltroRepository;

class DisponibilidadeFinder
{
    protected $bensFiltrados;

    /**
     * Construtor da classe.
     * Inicializa o repositório Filtro.
     */
    public function __construct()
    {
        $this->bensFiltrados = new FiltroRepository();
    }

    /**
     * Retorna todos os bens locáveis disponíveis no intervalo de datas especificado e com base no intervalo de preço.
     * Também armazena os dados da possível reserva na sessão.
     *
     * @param string $dataInicio Data de início da reserva (formato: YYYY-MM-DD).
     * @param string $dataFim Data de fim da reserva (formato: YYYY-MM-DD).
     * @param int|null $precoMin Valor mínimo do intervalo de preço (pode ser null para buscar todos).
     * @param int|null $precoMax Valor máximo do intervalo de preço (pode ser null para buscar todos).
     *
     * @return array Lista de bens locáveis disponíveis.
     */
    public function all_avalible($dataInicio, $dataFim, $precoMin, $precoMax)
    {
        $disponiveis = $this->bensFiltrados->all_avalible($dataInicio, $dataFim, $precoMin, $precoMax);
        return $disponiveis;
    }

    /**
     * Retorna todos os bens locáveis disponíveis em uma cidade
     * @param string $cidades Lista de nomes de cidades.
     * @return array Lista de bens locáveis disponíveis.
     */
    public function all_local($cidades)
    {
        $cidadesArray = explode(',', $cidades);
        $disponiveis = $this->bensFiltrados->filtro_localizacao($cidadesArray);
        return [$disponiveis, $cidadesArray];
    }


    public function um_local($cidade)
    {
        $disponiveis = $this->bensFiltrados->um_local($cidade);
        return $disponiveis;
    }

    /**
     * Retorna todos os bens locáveis disponíveis em uma cidade
     * @param array $colecao_bens_locaveis Lista de bens locáveis disponíveis.
     * @param string $dataInicio Data de início da reserva (YYYY-MM-DD).
     * @param string $dataFim Data de fim da reserva (YYYY-MM-DD).
     * @return \Illuminate\Support\Collection Bens locáveis disponíveis no período.
     */
    public function all_avalible_in_city($cidades, $dataInicio, $dataFim, $precoMin, $precoMax)
    {
        [$disponiveis, $cidadesArray] = $this->all_local($cidades);

        if ($dataInicio || $dataFim) {
            $disponiveis = $this->bensFiltrados->all_avalible_in_city($disponiveis, $dataInicio, $dataFim, $precoMin, $precoMax);
        }
        return [$disponiveis, $cidadesArray];
    }
}
