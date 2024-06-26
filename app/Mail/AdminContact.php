<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminContact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Nombre del contacto.
     *
     * @var App\Models\Contact
     */
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
        ->subject('Nueva consulta de '.$this->contact->name)
        ->view('Web.Emails.contactMailAdmin')->with([
            'contact' => $this->contact,
        ]);;
    }
}
