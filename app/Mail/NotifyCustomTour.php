<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyCustomTour extends Mailable
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
            view: 'emails.notify_custom_tour',
            with: [
                'country_name'=> $this->data->country->name,
                'email'=> $this->data->email,
                'places'=> $this->data->places,
                'note'=> $this->data->note,
            ],
        );
    }


    public function attachments()
    {
        return [];
    }
}
