<?php

namespace App\Enums\StateMachines;

enum NewsletterState: string
{
    case Requested = 'requested';
    case Completed = 'completed';
}
