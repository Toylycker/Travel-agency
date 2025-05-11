<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomTourRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('New Custom Tour Request')
                    ->view('emails.custom-tour')
                    ->with([
                        'country' => $this->data['country'],
                        'email' => $this->data['email'],
                        'note' => $this->data['note'],
                    ]);
    }
} 