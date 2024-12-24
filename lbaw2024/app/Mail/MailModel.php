<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class MailModel extends Mailable
{
    use Queueable, SerializesModels;
    
    // Necessary to pass data from the controller.
    public $mailData;


    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
       // $this->resetLink = $resetLink;  // Add this line to set the resetLink
    }

    /**
     * Get the message envelope.
     */ 
    public function envelope(): Envelope
    {
        return new Envelope(
            //from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            from: new Address('no-reply@infeup.com', 'InFeup'),  // Hardcoded to test
            subject: 'Solicitação de recuperação de palavra-passe',
            //subject: 'Mail Model',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.example',
        );
    }

    /*
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    public function attachments(): array
    {
        return [];
    }
    */
}
