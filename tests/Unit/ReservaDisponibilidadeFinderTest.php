<?php

use App\Services\Finders\ReservaDisponibilidadeFinder;

test('teste do filtro', function () {
    $name = new ReservaDisponibilidadeFinder();

    $result = $name->verificaDisponibilidade(1, '2026-01-09', '2026-01-10');
    expect($result)->toBeString();
});

