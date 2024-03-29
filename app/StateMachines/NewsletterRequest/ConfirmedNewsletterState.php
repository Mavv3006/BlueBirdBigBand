<?php

namespace App\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use Carbon\Carbon;

class ConfirmedNewsletterState extends BaseNewsletterState
{
    public function complete(): void
    {
        $this->newsletterRequest->update([
            'status' => NewsletterState::Completed,
            'completed_at' => Carbon::now(),
        ]);
    }
}
