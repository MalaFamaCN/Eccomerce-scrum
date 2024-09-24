<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

//...
class RegisterMailable extends Mailable {
    //...
    public $user;
    public function __construct($user) {
    $this->user = $user;
    }
    
    public function envelope(): Envelope {
    // Asunto del Correo
    return new Envelope(subject: 'Notificación de Registro',);
    }
    public function content(): Content {
    // Ruta de la vista que va a tener el contenido del correo
    return new Content(view: 'emails.register',);
    }
    //...
   }
   