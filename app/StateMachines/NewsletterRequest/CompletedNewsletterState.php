<?php

namespace App\StateMachines\NewsletterRequest;

use App\Enums\StateMachines\NewsletterState;
use App\Exceptions\InvalidStateTransitionException;
use Exception;

class CompletedNewsletterState extends BaseNewsletterState
{
    public function confirm(): void
    {
        throw new Exception;
    }

    public function complete(): void
    {
        throw InvalidStateTransitionException::fromEnumState(
            currentState: NewsletterState::Completed,
            targetState: NewsletterState::Completed
        );
    }
}
