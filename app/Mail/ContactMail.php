<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Nombre del contacto.
     *
     * @var String
     */
    public $contactName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactName)
    {
        $this->contactName = $contactName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('joanteich@gmail.com')
        ->view('Web.Emails.contactMail')->with([
            'contactName' => $this->contactName,
        ]);;
    }
}
