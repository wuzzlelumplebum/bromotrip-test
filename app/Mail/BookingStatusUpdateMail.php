<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class BookingStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $previousStatus;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, string $previousStatus)
    {
        $this->booking = $booking;
        $this->previousStatus = $previousStatus;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Status Update - ' . $this->booking->booking_code,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.booking-status-update',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
