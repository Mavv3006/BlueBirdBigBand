<?php

namespace App\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use Carbon\Carbon;

class RequestedNewsletterState extends BaseNewsletterState
{
    public function confirm(): void
    {
        $this->newsletterRequest->update([
            'status' => NewsletterState::Confirmed,
            'confirmed_at' => Carbon::now(),
        ]);

        // TODO: send notification to admins
    }
}
