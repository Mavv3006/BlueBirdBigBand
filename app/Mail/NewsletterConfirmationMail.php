<?php

namespace App\Mail;

use App\Models\NewsletterRequest;
use App\Services\NewsletterRequest\NewsletterRequestService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $confirmationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(public NewsletterRequest $newsletterRequest)
    {
        $this->confirmationUrl = NewsletterRequestService::confirmationLink($this->newsletterRequest);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->newsletterRequest->email,
            subject: 'Bitte bestätigen Sie Ihre Anmeldung für unseren Newsletter',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.newsletter-confirmation',
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
