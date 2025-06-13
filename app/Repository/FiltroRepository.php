<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class FiltroRepository
{
    /**
     * Retorna todos os bens locáveis
     */
    private function all()
    {
        $disponiveis = DB::table('bens_locaveis')->get();
        return $disponiveis;
        // return Model::all();
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
    public function all_avalible($dataInicio, $dataFim, $precoMin = null, $precoMax = null)
    {
        if (!$dataInicio || !$dataFim) {
            return $this->all();
        }
    
        $disponiveis = DB::table('bens_locaveis')
            ->whereNotExists(function ($query) use ($dataInicio, $dataFim) {
                // Subconsulta para verificar se o imóvel já está reservado no período
                $query->select(DB::raw(1))
                    ->from('reservas')
                    ->whereColumn('reservas.bem_locavel_id', 'bens_locaveis.id')
                    ->where('status', 'reservado') // Verifica se a reserva está com status 'reservado'
                    ->where(function ($q) use ($dataInicio, $dataFim) {
                        // Verifica sobreposição de datas
                        $q->where('data_inicio', '<=', $dataFim)
                            ->where('data_fim', '>=', $dataInicio);
                    });
            });
    
            if ($precoMin !== null && $precoMax !== null) {
                $disponiveis->whereBetween('preco_diario', [$precoMin, $precoMax]);
            } elseif ($precoMin !== null) {
                $disponiveis->where('preco_diario', '>=', $precoMin);
            } elseif ($precoMax !== null) {
                $disponiveis->where('preco_diario', '<=', $precoMax);
            }
    
        return $disponiveis->orderBy('preco_diario', 'asc')->get();
    }


    /**
     * Retorna todos os bens locáveis disponíveis em um local.
     *
     * @param string $cidade Nome da cidade
     * @return array Lista de bens locáveis disponíveis.
    */
    public function um_local($cidade)
    {
        $disponiveis = DB::table('bens_locaveis')
            ->leftJoin('localizacoes', function ($join) use ($cidade) {
                $join->on('bens_locaveis.id', '=', 'localizacoes.bem_locavel_id')
                    ->where('localizacoes.cidade', $cidade);
            })
            ->orderBy('bens_locaveis.numero_passageiros', 'asc')
            ->get();

        return $disponiveis;
    }

    /**
     * Retorna todos os bens locáveis disponíveis em uma lista de locais.
     *
     * @param string $cidadesArray Array
     * @return array Lista de bens locáveis disponíveis.
    */
    public function filtro_localizacao($cidadesArray)
    {
        $disponiveis = DB::table('bens_locaveis')
            ->leftJoin('localizacoes', 'bens_locaveis.id', '=', 'localizacoes.bem_locavel_id')
            ->whereIn('localizacoes.cidade', $cidadesArray)
            ->orderBy('bens_locaveis.numero_passageiros', 'asc')
            ->get();

        return $disponiveis;
    }

    /**
     * Filtra os bens locáveis da coleção recebida, mantendo apenas os disponíveis entre as datas informadas.
     *
     * @param \Illuminate\Support\Collection $colecao_bens_locaveis Coleção de bens locáveis filtrados por cidade.
     * @param string $dataInicio Data de início da reserva (YYYY-MM-DD).
     * @param string $dataFim Data de fim da reserva (YYYY-MM-DD).
     * @return \Illuminate\Support\Collection Bens locáveis disponíveis no período.
    */
    public function all_avalible_in_city($colecao_bens_locaveis, $dataInicio, $dataFim, $precoMin, $precoMax)
    {
        $disponiveis = $colecao_bens_locaveis->filter(function ($bem) use ($dataInicio, $dataFim) {
            $existeReservaConflitante = DB::table('reservas')
                ->where('bem_locavel_id', $bem->id)
                ->where('status', 'reservado')
                ->where(function ($query) use ($dataInicio, $dataFim) {
                    $query->where('data_inicio', '<=', $dataFim)
                        ->where('data_fim', '>=', $dataInicio);
                })
                ->exists();

            return !$existeReservaConflitante;
        });
        if ($precoMin !== null || $precoMax !== null) {
            $disponiveis = $disponiveis->filter(function ($bem) use ($precoMin, $precoMax) {
                return ($precoMin === null || $bem->preco_diario >= $precoMin) &&
                       ($precoMax === null || $bem->preco_diario <= $precoMax);
            });
        }
        return $disponiveis->values();
    }


    public function all_avalible_filter($dataInicio, $dataFim, $numero_passageiros)
    {
        if (!$dataInicio || !$dataFim || !$numero_passageiros) {
            $disponiveis = DB::table('bens_locaveis')->get();
        } else {
            $disponiveis = DB::table('bens_locaveis')
                ->where('numero_passageiros', '>=', $numero_passageiros)
                ->whereNotExists(function ($query) use ($dataInicio, $dataFim) {
                    $query->select(DB::raw(1))
                        ->from('reservas')
                        ->whereColumn('reservas.bem_locavel_id', 'bens_locaveis.id')
                        ->where('status', 'reservado')
                        ->where(function ($q) use ($dataInicio, $dataFim) {
                            $q->where('data_inicio', '<=', $dataFim)
                                ->where('data_fim', '>=', $dataInicio);
                        });
                })
                ->orderBy('numero_passageiros', 'asc')
                ->get();
        }
        return $disponiveis;
    }
}
