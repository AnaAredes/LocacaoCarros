<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Mail\Mailables\Address; 
use Illuminate\Mail\Mailables\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use stdClass;

class EmailCliente extends Mailable
{
    use Queueable, SerializesModels;

    public stdClass $detalhes;
    public Reserva $reserva;
    public string $clientName;

    /**
     * Create a new message instance.
     */
    public function __construct(stdClass $detalhes, Reserva $reserva, string $clientName)
    {
        $this->detalhes = $detalhes;
        $this->reserva = $reserva;
        $this->clientName = $clientName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            /*replyTo: [new Address('taylor@example.com', 'Taylor Otwell'),],*/
            subject: 'Confirmação da Reserva',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.mailcliente',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
