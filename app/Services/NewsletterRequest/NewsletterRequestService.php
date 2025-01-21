<?php

namespace App\Services\NewsletterRequest;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Exceptions\InvalidStateTransitionException;
use App\Mail\NewsletterConfirmationMail;
use App\Models\NewsletterRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterRequestService
{
    public static function createNew(string $email, NewsletterType $type): void
    {
        $newsletterRequest = NewsletterRequest::create([
            'email' => $email,
            'type' => $type,
            'status' => NewsletterState::Requested,
        ]);
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
        return route('newsletter.confirm', ['newsletterRequest' => $newsletterRequest]);
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
