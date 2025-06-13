<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class BensLocaveisRepository
{
    /**
     * Retorna um bem locável específico com base no seu ID.
     *
     * @param int $id ID do bem locável a ser buscado.
     * @return object|null Objeto representando o bem locável, ou null se não encontrado.
     */
    public function find($id)
    {
        $disponiveis = DB::table('bens_locaveis')
            ->where('id', $id)
            ->first();
        return $disponiveis;
    }

    /**
     * Retorna informações detalhadas de um bem locável, incluindo marca, localização e características agregadas.
     *
     * @param int $id ID do bem locável.
     * @return object|null Objeto com os detalhes completos do bem locável, ou null se não encontrado.
     *
     * Campos retornados: modelo, combustivel, preco_diario, numero_passageiros, cor, transmissao, marca_nome
     * - marca_obs, cidade, filial, posicao, caracteristicas (lista concatenada em string separada por vírgulas)
     */
    public function getOneBem($id)
    {
        $resultado = DB::table('bens_locaveis')
            ->select(
                'bens_locaveis.modelo',
                'bens_locaveis.imageUrl',
                'bens_locaveis.combustivel',
                'bens_locaveis.preco_diario',
                'bens_locaveis.numero_passageiros',
                'bens_locaveis.cor',
                'bens_locaveis.transmissao',
                'marca.nome as marca_nome',
                'marca.observacao as marca_obs',
                'localizacoes.cidade',
                'localizacoes.filial',
                'localizacoes.posicao',
                DB::raw("GROUP_CONCAT(caracteristicas.nome ORDER BY caracteristicas.nome SEPARATOR ', ') as caracteristicas")
            )
            ->join('marca', 'bens_locaveis.marca_id', '=', 'marca.id')
            ->join('tipo_bens', 'marca.tipo_bem_id', '=', 'tipo_bens.id')
            ->join('localizacoes', 'bens_locaveis.id', '=', 'localizacoes.bem_locavel_id')
            ->join('bem_caracteristicas', 'bens_locaveis.id', '=', 'bem_caracteristicas.bem_locavel_id')
            ->join('caracteristicas', 'bem_caracteristicas.caracteristica_id', '=', 'caracteristicas.id')
            ->where('bens_locaveis.id', $id)
            ->groupBy(
                'bens_locaveis.id',
                'bens_locaveis.modelo',
                'bens_locaveis.imageUrl',
                'bens_locaveis.numero_passageiros',
                'tipo_bens.nome',
                'localizacoes.cidade',
                'localizacoes.filial',
                'localizacoes.posicao'
            )
            ->first();
        return $resultado;
    }
}
