<?php

namespace App\StateMachines\NewsletterRequest;

use App\Exceptions\InvalidStateTransitionException;
use App\Models\NewsletterRequest;

abstract class BaseNewsletterState
{
    public function __construct(public NewsletterRequest $newsletterRequest) {}

    /**
     * @throws InvalidStateTransitionException
     */
    abstract public function confirm(): void;

    /**
     * @throws InvalidStateTransitionException
     */
    abstract public function complete(): void;
}
