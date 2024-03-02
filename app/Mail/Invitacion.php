<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invitacion extends Mailable
{
    use Queueable, SerializesModels;

    public $email, $nombre;

    public function __construct($email, $nombre)
    {
        $this->email = $email;
        $this->nombre = $nombre;
    }

    public function build()
    {
        return $this->from('acs@acs.com')
            ->view('emails.invitacion')
            ->with([
                'email' => $this->email,
                'nombre' => $this->nombre
            ]);
    }
}
