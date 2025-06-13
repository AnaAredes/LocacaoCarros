<?php

namespace App\Services\Pagamento;

interface PagamentoInterface
{
    /**
     * Inicia o processo de pagamento
     *
     * @param array $dados
     * @return mixed (ex: view data, redirect response, etc.)
     */
    public function iniciar(array $dados): mixed;

    /**
     * Confirma o pagamento
     *
     * @param array $dados
     * @return mixed (ex: confirmação, erro, etc.)
     */
    public function confirmar(array $dados): mixed;

    /**
     * Cancela o pagamento
     *
     * @param array $dados
     * @return array
     */
    public function cancelar(array $dados): array;
}
