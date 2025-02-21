<?php

namespace App\Mail;

use App\Models\BookingTransaction;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $transaction;
    public $destination;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, BookingTransaction $transaction, Destination $destination)
    {
        $this->user = $user;
        $this->transaction = $transaction;
        $this->destination = $destination;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Booking Confirmation -  {$this->destination->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
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
