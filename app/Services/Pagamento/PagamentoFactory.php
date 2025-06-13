<?php

namespace App\Services\Pagamento;

use InvalidArgumentException;

class PagamentoFactory
{
    /**
     * Cria uma instância de um serviço de pagamento com base no tipo fornecido.
     *
     * @param string $tipo de pagamento desejado (ex: 'multibanco', 'paypal').
     * @return PagamentoInterface uma instância de serviço que implementa PagamentoInterface.
     * @throws InvalidArgumentException Se o tipo informado não for suportado.
     */
    public static function criar(string $tipo): PagamentoInterface
    {
        return match ($tipo) {
            'multibanco' => new MultibancoService(),
            'paypal' => new PPalService(),
            default => throw new InvalidArgumentException("Tipo de pagamento não suportado: {$tipo}")
        };
    }

    /**
     * Retorna a lista de tipos de pagamento atualmente suportados pelo sistema.
     *
     * @return array strings com os tipos de pagamento disponíveis.
     */
    public static function tiposDisponiveis(): array
    {
        return ['multibanco', 'paypal'];
    }
}
