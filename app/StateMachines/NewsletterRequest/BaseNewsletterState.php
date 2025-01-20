<?php

namespace App\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use App\Models\NewsletterRequest;
use Carbon\Carbon;
use Exception;

abstract class BaseNewsletterState
{
    public function __construct(public NewsletterRequest $newsletterRequest) {}

    /**
     * @throws Exception
     */
    public function confirm(): void
    {
        throw new Exception;
    }

    /**
     * @throws Exception
     */
    public function complete(): void
    {
        $this->newsletterRequest->update([
            'status' => NewsletterState::Completed,
            'completed_at' => Carbon::now(),
        ]);
    }
}
