<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $galleryName;
    public $email;
    public $invitaion_key;

    /**
     * Create a new message instance.
     *
     * @param  string  $galleryName
     * @param  string  $email
     */
    public function __construct(string $galleryName, string $email, string $invitaion_key)
    {
        $this->galleryName = $galleryName;
        $this->email = $email;
        $this->invitaion_key = $invitaion_key;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invitation')
            ->subject('Invitation to Event: ' . $this->galleryName)
            ->with([
                'invitaion_key' => $this->invitaion_key
            ]);
    }
}
