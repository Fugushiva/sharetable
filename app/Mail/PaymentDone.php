<?php

namespace App\Mail;

use App\Models\Annonce;
use App\Models\Host;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentDone extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $annonce;
    public $host;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Annonce $annonce, Host $host)
    {
        $this->user = $user;
        $this->annonce = $annonce;
        $this->host = $host;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'jerome@sharetable.com',
            subject: 'Payment Done',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            view: 'emails.PaymentDone',
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
