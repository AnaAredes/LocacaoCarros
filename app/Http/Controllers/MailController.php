<?php

namespace App\Http\Controllers;

use App\Mail\EmailCliente;
use App\Models\Reserva;
use App\Services\Finders\BensLocaveisFinder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    protected $bemServico;

    /**
     * Construtor da classe MailController.
     *
     * Inicializa a instância do serviço BensLocaveisService para buscar informações de bem locável.
     */
    public function __construct(BensLocaveisFinder $bemServico)
    {
        $this->bemServico = $bemServico;
    }

    /**
     * Envia um e-mail de confirmação de reserva usando o ID armazenado na sessão.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmailSucessoReserva()
    {
        $reserva_id = session('reserva_id'); // ou Session::get('reserva_id');

        if (!$reserva_id) {
            return back()->with('error', 'ID da reserva não encontrado na sessão.');
        }

        $detalhesReserva = $this->obterDetalhesReserva($reserva_id);

        if (isset($detalhesReserva['error'])) {
            return back()->with('error', $detalhesReserva['error']);
        }
        Log::info('SMTP Host: ' . config('mail.mailers.smtp.host'));
        Log::info('SMTP Port: ' . config('mail.mailers.smtp.port'));

        /*Mail::to($detalhesReserva['email'])->queue(new EmailCliente(
            $detalhesReserva['bem_detalhes'],
            $detalhesReserva['reserva'],
            $detalhesReserva['clientName']
        ));*/

        // Envia o e-mail
        Mail::to($detalhesReserva['email'])->send(new EmailCliente(
            $detalhesReserva['bem_detalhes'],
            $detalhesReserva['reserva'],
            $detalhesReserva['clientName']
        ));

        return redirect('dashboard')->with('success', 'E-mail enviado com sucesso!');
    }

    /**
     * Envia um e-mail de confirmação de reserva com base no ID informado.
     *
     * @param int $reserva_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmailReserva($reserva_id)
    {
        $detalhesReserva = $this->obterDetalhesReserva($reserva_id);

        if (isset($detalhesReserva['error'])) {
            return back()->with('error', $detalhesReserva['error']);
        }

        Log::info('SMTP Host: ' . config('mail.mailers.smtp.host'));
        Log::info('SMTP Port: ' . config('mail.mailers.smtp.port'));

        /* Mail::to($detalhesReserva['email'])->queue(
            new EmailCliente(
                $detalhesReserva['bem_detalhes'],
                $detalhesReserva['reserva'],
                $detalhesReserva['clientName']
            )
        );*/

        // Envia o e-mail
        Mail::to($detalhesReserva['email'])->send(new EmailCliente(
            $detalhesReserva['bem_detalhes'],
            $detalhesReserva['reserva'],
            $detalhesReserva['clientName']
        ));


        return back()->with('success', 'E-mail enviado com sucesso!');
    }

    /**
     * Obtém os detalhes necessários para envio do e-mail da reserva.
     *
     * @param int $reserva_id
     * @return array dados da reserva, utilizador e bem locável, ou erro.
     */
    private function obterDetalhesReserva($reserva_id)
    {
        $user = Auth::user();
        if (!$user) {
            return ['error' => 'Utilizador não autenticado.'];
        }

        $reserva = Reserva::find($reserva_id);
        if (!$reserva) {
            return ['error' => 'Reserva não encontrada.'];
        }

        $bem_detalhes = $this->bemServico->getOneBem($reserva->bem_locavel_id);
        if (!$bem_detalhes) {
            return ['error' => 'Bem não encontrado.'];
        }

        return [
            'bem_detalhes' => $bem_detalhes,
            'reserva' => $reserva,
            'email' => $user->email,
            'clientName' => $user->name,
        ];
    }
}
