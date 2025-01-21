<?php

namespace App\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use App\Exceptions\InvalidStateTransitionException;
use App\Mail\NewsletterAdminNotificationMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RequestedNewsletterState extends BaseNewsletterState
{
    public function confirm(): void
    {
        $this->newsletterRequest->update([
            'status' => NewsletterState::Confirmed,
            'confirmed_at' => Carbon::now(),
        ]);
        Log::info('Confirmed a newsletter request', [$this->newsletterRequest]);


        Mail::send(new NewsletterAdminNotificationMail($this->newsletterRequest));
        Log::info('Sent a newsletter admin notification mail', [$this->newsletterRequest]);
    }

    public function complete(): void
    {
        throw InvalidStateTransitionException::fromEnumState(
            currentState: NewsletterState::Requested,
            targetState: NewsletterState::Completed
        );
    }
}
