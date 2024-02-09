<?php

namespace App\Services\NewsletterRequest;

use App\Http\Requests\NewsletterRequestingRequest;
use App\Models\NewsletterRequest;

class NewsletterRequestService
{
    public static function createNew(NewsletterRequestingRequest $request): void
    {
        $newsletterRequest = NewsletterRequest::create([
            $request->validated(),

        ]);

        $confirmationUrl = url(route('newsletter.confirm', ['newsletterRequest' => $newsletterRequest->id]));
        // TODO: send confirmation email to user
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
}
