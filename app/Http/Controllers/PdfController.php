<?php

namespace App\Http\Controllers;

use App\Services\Finders\ReservaFinder;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    protected $reservaBusca;

    /**
     * Construtor da classe PdfController.
     *
     * Inicializa a instância do serviço ReservaService para manipular informações da reserva.
     */
    public function __construct()
    {
        $this->reservaBusca = new ReservaFinder();
    }

    /**
     * Gera e permite o download do arquivo PDF com os detalhes da reserva específica cujo id está na session.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View o arquivo PDF ou redireciona para a visão de sucesso com erro.
     */
    public function downloadArquivo()
    {
        $reservaData = session('reserva_id');

        if (!session()->has('reserva_id')) {
            return view('reserva.sucesso')->with('success', $reservaData);
        }

        $reservaId = is_object($reservaData) ? $reservaData->id : $reservaData;

        $reserva = $this->reservaBusca->read($reservaId);

        if (!$reserva) {
            return view('reserva.sucesso')->with('error', 'Reserva não encontrada.');
        }
        $pdf = Pdf::loadView('reserva.print', compact('reserva'));

        //return $pdf->stream('reserva-' . env('APP_NAME') . '-' . date('Ymd') . '.pdf'); 
        //add target="_blank" no frontend
        return $pdf->download('reserva-' . env('APP_NAME') . '-' . date('Ymd') . '.pdf');
    }


    /**
     * Gera e permite o download do arquivo PDF com os detalhes de uma reserva específica.
     *
     * @param int $reserva_id O identificador único da reserva.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse Retorna o arquivo PDF ou redireciona com erro.
     */
    public function downloadDadosReserva($reserva_id)
    {
        $reserva = $this->reservaBusca->read($reserva_id);

        if (!$reserva) {
            return back()->with('error', 'Reserva não encontrada.');
        }
        $pdf = Pdf::loadView('reserva.print', compact('reserva'));

        return $pdf->download('reserva-' . env('APP_NAME') . '-' . date('Ymd') . '.pdf');
        //add target="_blank" no frontend
    }
}
