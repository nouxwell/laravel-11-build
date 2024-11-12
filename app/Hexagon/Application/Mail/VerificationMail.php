<?php

namespace App\Hexagon\Application\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public ?array $data = [];
    public ?array $files = [];

    /**
     * Create a new message instance.
     */
    public function __construct(?array $data = [], ?array $files = [])
    {
        $this->data = $data;
        $this->files = $files;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verification',with: $this->data
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return $this->files;
    }

    /**
     * Static method to inject data into the Mailable
     */
    public static function withData(?array $data = [], ?array $files = []): static
    {
        return new static($data, $files);
    }
}
