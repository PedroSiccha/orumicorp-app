<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailDevelop extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $asunto;

    public function __construct(
        $mensaje,
        $asunto
    ) {
        $this->mensaje = $mensaje;
        $this->asunto = $asunto;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->asunto
        );
    }

    public function content()
    {
        return new Content(
            view: 'mail.template.develop'
        );
    }

    public function attachments()
    {
        return [];
    }
}
