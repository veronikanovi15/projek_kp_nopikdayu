<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordEncryptedMail extends Mailable
{
    // use Queueable, SerializesModels;

    // public $encryptedPassword;

    // public function __construct($encryptedPassword)
    // {
    //     $this->encryptedPassword = $encryptedPassword;
    // }

    // public function build()
    // {
    //     return $this->view('emails.password_encrypted')
    //                 ->with([
    //                     'encryptedPassword' => $this->encryptedPassword,
    //                 ]);
    // }
}
