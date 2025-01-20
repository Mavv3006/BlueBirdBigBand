<?php

namespace App\Services\NewsletterRequest;

use App\Enums\NewsletterType;
use App\Http\Requests\NewsletterRequestingRequest;
use App\Mail\NewsletterAdminNotificationMail;
use App\Mail\NewsletterConfirmationMail;
use App\Models\NewsletterRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterRequestService
{
    public static function createNew(NewsletterRequestingRequest $request): void
    {
        $data = $request->validated();
        $newsletterRequest = NewsletterRequest::create([
            'email' => $data['email'],
            'type' => $data['type'],
        ]);
        Log::info('Created a new newsletter request', [$newsletterRequest]);

        self::sendNotificationEmails($newsletterRequest);
    }

    public static function confirm(NewsletterRequest $newsletterRequest): void
    {
        try {
            $newsletterRequest
                ->state()
                ->confirm();
            Log::info('Confirmed a newsletter request', [$newsletterRequest]);

            Mail::send(new NewsletterAdminNotificationMail($newsletterRequest));
            Log::info('Sent a newsletter admin notification mail', [$newsletterRequest]);
        } catch (\Exception) {
            // ignore exception
        }
    }

    public static function confirmationLink(NewsletterRequest $newsletterRequest): string
    {
        return route('newsletter.confirm', ['newsletterRequest' => $newsletterRequest]);
    }

    public static function sendNotificationEmails(NewsletterRequest $newsletterRequest): void
    {
        switch ($newsletterRequest->type) {
            case NewsletterType::Adding:
                Mail::to($newsletterRequest->email)->send(new NewsletterConfirmationMail($newsletterRequest));
                Log::info('Sent a newsletter confirmation mail', [$newsletterRequest]);
                break;
            case NewsletterType::Removing:
                Mail::send(new NewsletterAdminNotificationMail($newsletterRequest));
                Log::info('Sent a newsletter admin notification mail', [$newsletterRequest]);
        }
    }
}
