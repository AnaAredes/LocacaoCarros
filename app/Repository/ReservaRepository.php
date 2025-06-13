<?php

namespace App\Repository;

use App\Models\Reserva;
use Illuminate\Support\Facades\DB;

class ReservaRepository
{
    /**
     * Busca uma reserva pelo ID.
     *
     * @param int $id O identificador único da reserva.
     * @return object|null Retorna a reserva encontrada ou null se não existir.
     */
    public function find($id)
    {
        $reserva = DB::table('reservas')
            ->where('id', $id)
            ->first();

        return $reserva;
    }

    /**
     * Busca uma reserva específica de um utilizador para um bem locável.
     *
     * @param int $user_id O identificador único do utilizador.
     * @param int $bem_id O identificador único do bem locável.
     * @return object|null Retorna a reserva encontrada ou null se não existir.
     */
    public function findByUserAndBem($user_id, $bem_id)
    {
        $reserva = DB::table('reservas')
            ->where('user_id', $user_id)
            ->where('bem_locavel_id', $bem_id)
            ->where('status', 'reservado')
            ->first();

        return $reserva;
    }

    /**
     * Cria uma nova reserva para um utilizador em um bem locável.
     *
     * @param int $user_id O identificador único do utilizador.
     * @param int $bem_id O identificador único do bem locável.
     * @param string $data_inicio A data de início da reserva (YYYY-MM-DD).
     * @param string $data_fim A data de término da reserva (YYYY-MM-DD).
     * @param float $preco O preço total da reserva.
     * * @return \App\Models\Reserva Retorna a instância da reserva criada.
    */
    public function create($user_id, $bem_id, $data_inicio, $data_fim, $preco)
    {
        return DB::transaction(function () use ($user_id, $bem_id, $data_inicio, $data_fim, $preco) {
            return Reserva::create([
                'user_id' => $user_id,
                'bem_locavel_id' => $bem_id,
                'data_inicio' => $data_inicio,
                'data_fim' => $data_fim,
                'preco_total' => $preco,
                'status' => 'reservado',
            ]);
        });
    }

    /**
     * Recupera uma reserva específica pelo seu ID, incluindo detalhes do utilizador e do bem locável.
     *
     * @param int $id O identificador único da reserva.
     * @return object|null Retorna um objeto com os detalhes da reserva ou null se não for encontrada.
    */
    public function readOneReservetion($id)
    {
        $reserva = DB::table('reservas')
            ->join('users', 'reservas.user_id', '=', 'users.id')
            ->join('bens_locaveis', 'reservas.bem_locavel_id', '=', 'bens_locaveis.id')
            ->join('marca', 'bens_locaveis.marca_id', '=', 'marca.id')
            ->join('tipo_bens', 'marca.tipo_bem_id', '=', 'tipo_bens.id')
            ->join('localizacoes', 'bens_locaveis.id', '=', 'localizacoes.bem_locavel_id')
            ->where('reservas.id', $id)
            ->select(
                'reservas.*',
                'users.name as utilizador',
                'bens_locaveis.modelo',
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
            )
            ->groupBy(
                'reservas.id',
                'users.name',
                'bens_locaveis.modelo',
                'bens_locaveis.combustivel',
                'bens_locaveis.preco_diario',
                'bens_locaveis.numero_passageiros',
                'bens_locaveis.cor',
                'bens_locaveis.transmissao',
                'marca.nome',
                'marca.observacao',
                'localizacoes.cidade',
                'localizacoes.filial',
                'localizacoes.posicao'
            )
            ->first();

        return $reserva;
    }

    /**
     * Obtém uma reserva específica pelo seu ID com os relacionamentos definidos (Eloquent).
     *
     * @param int $id O identificador único da reserva.
     * @return \App\Models\Reserva|null Retorna um modelo de reserva com seus relacionamentos carregados ou null se não for encontrada.
    */
    public function read($id)
    {
        return Reserva::with(['user', 'bemLocavel'])->find($id);
    }

    /**
     * Verifica se um Bem está disponível para reserva em um intervalo de datas.
     *
     * @param int $bem_locavel_id ID do bem a ser verificado.
     * @param string|\DateTimeInterface $data_inicio da reserva desejada (formato 'Y-m-d' ou objeto DateTime).
     * @param string|\DateTimeInterface $data_fim da reserva desejada (formato 'Y-m-d' ou objeto DateTime).
     * 
     * @return bool Retorna `true` se disponível, `false` caso contrário.
     */
    public function verificaDisponibilidade($bem_locavel_id, $data_inicio, $data_fim)
    {
        $reservasConflitantes = Reserva::where('bem_locavel_id', $bem_locavel_id)
            ->where('status', 'reservado')
            ->where(function ($query) use ($data_inicio, $data_fim) {
                $query->where('data_inicio', '<=', $data_fim)
                    ->where('data_fim', '>=', $data_inicio);
            })
            ->exists();

        return !$reservasConflitantes;
    }

    /**
     * Obtém todas as reservas, detalhes do bem locável, marca, localização e características associadas a um utilizador específico.
     *
     * @param int $user_id O ID do utilizador cujas reservas devem ser recuperadas.
     * @return \Illuminate\Support\Collection Retorna uma coleção de objetos contendo as reservas e seus detalhes.
     */
    public function getReservasByUser($user_id)
    {
        $resultado = DB::table('reservas')
            ->join('bens_locaveis', 'bens_locaveis.id', '=', 'reservas.bem_locavel_id')
            ->join('marca', 'bens_locaveis.marca_id', '=', 'marca.id')
            ->join('tipo_bens', 'marca.tipo_bem_id', '=', 'tipo_bens.id')
            ->join('localizacoes', 'bens_locaveis.id', '=', 'localizacoes.bem_locavel_id')
            ->leftJoin('bem_caracteristicas', 'bens_locaveis.id', '=', 'bem_caracteristicas.bem_locavel_id')
            ->leftJoin('caracteristicas', 'bem_caracteristicas.caracteristica_id', '=', 'caracteristicas.id')
            ->where('reservas.user_id', $user_id)
            ->select(
                'bens_locaveis.modelo',
                'bens_locaveis.combustivel',
                'bens_locaveis.preco_diario',
                'bens_locaveis.numero_passageiros',
                'bens_locaveis.cor',
                'bens_locaveis.imageUrl',
                'bens_locaveis.transmissao',
                'marca.nome as marca_nome',
                'marca.observacao as marca_obs',
                'tipo_bens.nome as tipo_bem',
                'reservas.id as reserva_id',
                'reservas.data_inicio as data_inicio',
                'reservas.data_fim as data_fim',
                'localizacoes.cidade',
                'localizacoes.filial',
                'localizacoes.posicao',
                DB::raw("GROUP_CONCAT(DISTINCT caracteristicas.nome ORDER BY caracteristicas.nome SEPARATOR ', ') as caracteristicas")
            )
            ->groupBy(
                'bens_locaveis.id',
                'bens_locaveis.modelo',
                'bens_locaveis.combustivel',
                'bens_locaveis.preco_diario',
                'bens_locaveis.numero_passageiros',
                'bens_locaveis.cor',
                'bens_locaveis.transmissao',
                'bens_locaveis.imageUrl',
                'marca.nome',
                'marca.observacao',
                'tipo_bens.nome',
                'localizacoes.cidade',
                'localizacoes.filial',
                'localizacoes.posicao',
                'reservas.id',
                'reservas.data_inicio',
                'reservas.data_fim'
            )
            ->orderBy('reservas.data_inicio')
            ->get();

        return $resultado;
    }


    public function all()
    {
        return Reserva::all();
    }

    public function update($id, array $data)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update($data);
        return $reserva;
    }

    public function delete($id)
    {
        return Reserva::destroy($id);
    }
}
