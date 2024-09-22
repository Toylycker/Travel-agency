<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyContact extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function envelope()
    {
        return new Envelope(
            subject: 'Jahankeshde.com-dan hat geldi',
        );
    }


    public function content()
    {
        return new Content(
            view: 'emails.notify_contact',
            with: ['Email' => $this->data->email,
                'Message'=>$this->data->message
        ],
        );
    }


    public function attachments()
    {
        return [];
    }
}
