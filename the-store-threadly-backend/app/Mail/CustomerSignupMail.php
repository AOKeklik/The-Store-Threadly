<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerSignupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
	public $token;
	public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $token)
    {
        $this->subject = 'Complete Your Registration';
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
	        subject: $this->subject,
	        to: $this->email,
	        from: setting('mail_from_address'),
	    );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
	        view: 'email.customer-signup',
	        with: [
	            'email' => $this->email,
	            'confirmationUrl' => route('auth.signup.verify', [
	                'email' => $this->email, 
	                'token' => $this->token
	            ])
	        ]
	    );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
