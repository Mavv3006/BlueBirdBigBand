<?php

namespace App\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use App\StateMachines\NewsletterRequest\BaseNewsletterState;
use Carbon\Carbon;

class ConfirmedNewsletterState extends BaseNewsletterState
{
    public function confirm(): void
    {
        $this->newsletterRequest->update([
            'status' => NewsletterState::Confirmed,
            'confirmed_at' => Carbon::now()
        ]);
    }
}
