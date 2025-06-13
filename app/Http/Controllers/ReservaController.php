<?php

namespace App\Http\Controllers;

use App\Services\Finders\BensLocaveisFinder;
use App\Services\Finders\ReservaFinder;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    protected $bensLocaveis;
    protected $reservaBusca;

    /**
     * Construtor da ReservaController PdfController.
     *
     * Inicializa a instância dos serviços ReservaService e BensLocaveisService para manipular informações do bem e da reserva.
     */
    public function __construct()
    {
        $this->bensLocaveis = new BensLocaveisFinder();
        $this->reservaBusca = new ReservaFinder();
    }

    /**
     * Exibe a página de reserva com detalhes do bem selecionado.
     *
     * @return \Illuminate\View\View com os dados do bem, características, utilizador e possível reserva.
     */
    public function show()
    {
        $user = Auth::user();
        $possivel_reserva = session('possivel_reserva');
        $bem_id = session('bem_id');

        if (!$bem_id) {
            return redirect()->route('dashboard')->with('error', 'Bem não encontrado.');
        }

        $bem_caracteristicas = $this->bensLocaveis->extrairCaracteristicasComBem($bem_id, true);

        return view('reserva.index', [
            'bem' => $bem_caracteristicas['bem'],
            'caracteristicas' => $bem_caracteristicas['caracteristicas'],
            'user' => $user,
            'possivel_reserva' => $possivel_reserva
        ]);
    }

    /**
     * Recupera todas as reservas feitas pelo utilizador logado e exibe na dashboard.
     *
     * @return \Illuminate\View\View com os dados das reservas do utilizador.
     */
    public function getReservaByUser()
    {
        $user = Auth::user();

        $dados_reservas = $this->reservaBusca->getReservasByUser($user->id);

        return view('dashboard', [
            'bens' => $dados_reservas['bens'],
            'caracteristicas' => $dados_reservas['caracteristicas']
        ]);
    }
}
