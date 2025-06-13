<?php

use App\Http\Controllers\BensLocaveisController;
use App\Http\Controllers\FiltroController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Middleware\LimitDateMiddleware;
use App\Http\Middleware\RoleAccessMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [ReservaController::class, 'getReservaByUser'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('/enviar-email')->middleware('auth')->group(function () {
    Route::get('/', [MailController::class, 'sendEmailSucessoReserva'])
        ->name('send.emailsucesso');

    Route::get('/{reserva_id}', [MailController::class, 'sendEmailReserva'])
        ->name('send.emailconfirmacao');
});

Route::get('/detalhes/{id}', [BensLocaveisController::class, 'getOne'])
    ->name('detalhes');

Route::middleware('auth')->group(function () {
    Route::get('/reserva', [ReservaController::class, 'show'])->name('reserva.index');
});

Route::get('/reserva/sucesso', function () {
    return view('reservas.sucesso');
})->name('reservas.sucesso');

Route::prefix('/disponiveis')->middleware([LimitDateMiddleware::class])->group(function () {
    Route::get('/', [FiltroController::class, 'all_avalible_filter'])
        ->name('disponiveis');
    Route::get('/{cidades}', [FiltroController::class, 'all_avalible_in_city'])
        ->name('localizacao');
});

Route::prefix('/descarregar')->middleware(['auth'])->group(function () {
    Route::get('/print', [PdfController::class, 'downloadArquivo'])
        ->name('reserva.print');

    Route::get('/{reserva_id}', [PdfController::class, 'downloadDadosReserva'])
        ->name('descarregar');
});


Route::prefix('/pagamento')->middleware(['auth'])->group(function () {
    Route::post('/iniciar', [PagamentoController::class, 'iniciar'])->name('pagamento.iniciar');
    Route::get('/sucesso/{tipo}', [PagamentoController::class, 'confirmar'])->name('pagamento.sucesso');
    Route::get('/sucesso', [PagamentoController::class, 'mostrarSucesso'])->name('pagamento.sucesso.view');
    Route::get('/cancelar/{tipo}', [PagamentoController::class, 'cancelar'])->name('pagamento.cancelar');
});

Route::get('/gestao', function () {
    return view('dashboard');
})->middleware(['auth', RoleAccessMiddleware::class])->name('gestao');

require __DIR__ . '/auth.php';


/*Route::get('/reserva/{id}', [BensLocaveisController::class, 'create'])
    ->middleware('auth')
    ->name('reserva');
    */