<?php

namespace App\Services\Finders;

use App\Repository\ReservaRepository;


class ReservaDisponibilidadeFinder
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
        $reservasConflitantes = $this->reserva->verificaDisponibilidade($bem_locavel_id, $data_inicio, $data_fim);
        return $reservasConflitantes;
    }
}
