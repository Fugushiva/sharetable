<?php

namespace App\Mail;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingCode extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $reservation;
    protected $code;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Reservation $reservation, string $code)
    {
        $this->user = $user;
        $this->reservation = $reservation;
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'jerome@sharetable.com',
            subject: 'Booking Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.bookingCode',
            with: [
                'userName' => $this->user->name,
                'reservationDate' => $this->reservation->schedule,
                'code' => $this->code,
            ],
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
