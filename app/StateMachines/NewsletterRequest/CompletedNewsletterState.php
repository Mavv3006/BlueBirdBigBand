<?php

namespace App\StateMachines\NewsletterRequest;

use Exception;

class CompletedNewsletterState extends BaseNewsletterState
{
    public function confirm(): void
    {
        throw new Exception;
    }
}
