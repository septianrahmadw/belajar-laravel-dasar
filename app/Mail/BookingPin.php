<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingPin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $pin,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode Verifikasi Booking Saya - LabBooking',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-pin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
