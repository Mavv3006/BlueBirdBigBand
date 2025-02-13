<?php

namespace App\Services\NewsletterRequest;

use App\DataTransferObjects\NewsletterRequestDto;
use App\Enums\NewsletterType;
use App\Exceptions\InvalidStateTransitionException;
use App\Mail\NewsletterConfirmationMail;
use App\Models\NewsletterRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class NewsletterRequestService
{
    public static function createNew(NewsletterRequestDto $dto): void
    {
        $newsletterRequest = NewsletterRequest::create((array) $dto);
        Log::info('Created a new newsletter request', [$newsletterRequest]);

        self::performPostCreationTasks($newsletterRequest);
    }

    public static function confirm(NewsletterRequest $newsletterRequest): void
    {
        try {
            $newsletterRequest->state()->confirm();
        } catch (InvalidStateTransitionException $e) {
            Log::error($e->getMessage());
        }
    }

    public static function confirmationLink(NewsletterRequest $newsletterRequest): string
    {
        return URL::signedRoute(
            name: 'newsletter.confirm',
            parameters: ['newsletterRequest' => $newsletterRequest],
            expiration: Carbon::now()->addDay(),
        );
    }

    public static function performPostCreationTasks(NewsletterRequest $newsletterRequest): void
    {
        if ($newsletterRequest->type == NewsletterType::Removing) {
            self::confirm($newsletterRequest);

            return;
        }

        Mail::to($newsletterRequest->email)->send(new NewsletterConfirmationMail($newsletterRequest));
        Log::info('Sent a newsletter confirmation mail', [$newsletterRequest]);
    }
}
