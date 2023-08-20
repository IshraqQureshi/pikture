<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fullName;
    public $email;
    public $message;

    /**
     * Create a new message instance.
     */
    public function __construct(string $fullName, string $email, string $message)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact')
            ->subject('Contact Inquiry')
            ->with([
                'fullName' => $this->fullName,
                'email' => $this->email,
                'contact_message' => $this->message
            ]);
    }
}
