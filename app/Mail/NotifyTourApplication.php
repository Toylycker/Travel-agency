<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyTourApplication extends Mailable
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
            view: 'emails.notify_tour_application',
            with: [
               'name'=>$this->data->name,
                'surname'=>$this->data->surname,
                'country_name'=>$this->data->country->name,
                'email'=>$this->data->email,
                'phone'=>$this->data->phone,
                'tour_name'=>$this->data->tour->name,
                'quantity'=>$this->data->quantity,
                'arrival'=>$this->data->arrival,
                'departure'=>$this->data->departure,
                'note'=>$this->data->note,
                'ip'=>$this->data->ip
            ],
        );
    }


    public function attachments()
    {
        return [];
    }
}
