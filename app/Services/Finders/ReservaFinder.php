<?php

namespace App\Services\Finders;

use App\Repository\ReservaRepository;

class ReservaFinder
{
    protected $reserva;

    /**
     * Construtor da classe.
     * Inicializa o repositório de bens locáveis.
     */
    public function __construct()
    {
        $this->reserva = new ReservaRepository();
    }

    /**
     * Obtém todas as reservas, detalhes do bem locável, marca, localização e características associadas a um utilizador específico.
     *
     * @param int $user_id O ID do utilizador cujas reservas devem ser recuperadas.
     * @return \Illuminate\Support\Collection Retorna uma coleção de objetos contendo as reservas e seus detalhes.
     */
    public function getReservasByUser($user_id)
    {
        $colecao_reservas = $this->reserva->getReservasByUser($user_id);

        return [
            'bens' => $colecao_reservas,
            'caracteristicas' => $this->extrairCaracteristicas($colecao_reservas)
        ];
    }

    /**
     * Obtém uma reserva específica pelo seu ID com os relacionamentos definidos com utilizador e bem locável.
     *
     * @param int $id O identificador único da reserva.
     * @return \App\Models\Reserva|null Retorna um modelo de reserva com seus relacionamentos carregados ou null se não for encontrada.
     */
    public function read($reserva_id)
    {
        $reserva = $this->reserva->read($reserva_id);
        return $reserva;
    }

    /**
     * Extrai e organiza as características dos bens locáveis a partir de uma coleção de reservas.
     *
     * @param \Illuminate\Support\Collection $colecao_reservas Coleção contendo os dados das reservas e seus bens locáveis.
     * @return array Retorna uma lista única (flattened), onde cada elemento contém as características de um bem locável.
     */
    private function extrairCaracteristicas($colecao_reservas)
    {
        $caracteristicas = [];

        foreach ($colecao_reservas as $reserva) {
            if (!empty($reserva->caracteristicas)) {
                $itens = explode(', ', $reserva->caracteristicas);
                $caracteristicas = array_merge($caracteristicas, $itens);
            }
        }

        // Remove duplicadas
        return array_unique($caracteristicas);
    }
}
