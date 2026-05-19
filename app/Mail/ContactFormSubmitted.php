<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{first_name: string, last_name: string, email: string, phone: string, message: string}  $data
     */
    public function __construct(
        public array $data,
    ) {}

    public function envelope(): Envelope
    {
        $name = trim($this->data['first_name'].' '.$this->data['last_name']);

        return new Envelope(
            replyTo: [
                new Address($this->data['email'], $name !== '' ? $name : $this->data['email']),
            ],
            subject: 'Contact form: '.$name,
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.contact-form-submitted',
        );
    }
}
