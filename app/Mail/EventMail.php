<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $galleryName;
    public $email;
    public $userPassword;
    public $existing_user;

    /**
     * Create a new message instance.
     *@param  string  $galleryName
     * @param  string  $email
     * @return void
     */
    public function __construct(string $email, string $galleryName, string $userPassword, bool $existing_user)
    {
        $this->galleryName = $galleryName;
        $this->email = $email;
        $this->userPassword = $userPassword;
        $this->existing_user = $existing_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.event')
            ->subject('Your Organizer Access for the Event '. $this->galleryName)
            ->with([
                'email' => $this->email,
                'galleryName' => $this->galleryName,
                'userPassword' => $this->userPassword,
                'existing_user' => $this->existing_user,
            ]);
    }
}
