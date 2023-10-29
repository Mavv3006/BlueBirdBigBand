<?php

namespace App\Enums\StateMachines;

enum FeatureFlagState: string
{
    case On = 'on';
    case Off = 'off';
}
