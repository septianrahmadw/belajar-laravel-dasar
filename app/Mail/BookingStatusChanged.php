<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $oldStatus,
        public ?string $rejectionReason = null,
    ) {}

    public function envelope(): Envelope
    {
        $statusText = match ($this->booking->status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => 'Diperbarui',
        };

        return new Envelope(
            subject: "Booking {$statusText} - {$this->booking->room->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-status-changed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
