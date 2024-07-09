<?php

namespace App\StateMachines\NewsletterRequest;

use App\Models\NewsletterRequest;
use Exception;

abstract class BaseNewsletterState
{
    public function __construct(public NewsletterRequest $newsletterRequest) {}

    /**
     * @throws Exception
     */
    public function confirm(): void
    {
        throw new Exception();
    }

    /**
     * @throws Exception
     */
    public function complete(): void
    {
        throw new Exception();
    }
}
