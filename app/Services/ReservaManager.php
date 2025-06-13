<?php

namespace App\Services;

use App\Models\Reserva;
use App\Repository\ReservaRepository;

class ReservaManager
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
     * Cria uma nova reserva para um utilizador em um bem locável.
     *
     * @param int $user_id O identificador único do user.
     * @param int $bem_id O identificador único do bem locável.
     * @param string $data_inicio A data de início da reserva (YYYY-MM-DD).
     * @param string $data_fim A data de término da reserva (YYYY-MM-DD).
     * @param float $preco O preço total da reserva.
     * @return Reserva Retorna a reserva criada.
     */
    public function create($user_id, $bem_id, $data_inicio, $data_fim, $preco): Reserva
    {
        $reserva = $this->reserva->create($user_id, $bem_id, $data_inicio, $data_fim, $preco);
        return $reserva;
    }
}
