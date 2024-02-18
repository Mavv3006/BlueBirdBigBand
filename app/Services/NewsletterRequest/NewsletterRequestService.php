<?php

namespace App\Services\NewsletterRequest;

use App\Http\Requests\NewsletterRequestingRequest;
use App\Mail\NewsletterConfirmationMail;
use App\Models\NewsletterRequest;
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

        Mail::to($newsletterRequest->email)->send(new NewsletterConfirmationMail($newsletterRequest));
    }

    public static function confirm(NewsletterRequest $newsletterRequest): void
    {
        try {
            $newsletterRequest
                ->state()
                ->confirm();
        } catch (\Exception) {
            // ignore exception
        }
    }

    public static function confirmationLink(NewsletterRequest $newsletterRequest): string
    {
        return route('newsletter.confirm', ['newsletterRequest' => $newsletterRequest]);
    }
}
