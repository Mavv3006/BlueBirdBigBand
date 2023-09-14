<?php

namespace App\Enums\StateMachines;

enum UserStates: string
{
    case Registered = 'registered';
    case Activated = 'activated';
}
