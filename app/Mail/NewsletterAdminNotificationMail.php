<?php

namespace App\Mail;

use App\Enums\NewsletterType;
use App\Models\NewsletterRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public NewsletterRequest $newsletterRequest)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: 'webadmin@bluebirdbigband.de',
            subject: match ($this->newsletterRequest->type) {
                NewsletterType::Adding => '[BBBB] Neue Newsletter-Anfrage - Hinzufügen',
                NewsletterType::Removing => '[BBBB] Neue Newsletter-Anfrage - Entfernen',
            }
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: match ($this->newsletterRequest->type) {
                NewsletterType::Adding => 'mail.newsletter-admin-notification-mail-adding',
                NewsletterType::Removing => 'mail.newsletter-admin-notification-mail-removing',
            },
            with: [
                'newsletterRequest' => $this->newsletterRequest,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
