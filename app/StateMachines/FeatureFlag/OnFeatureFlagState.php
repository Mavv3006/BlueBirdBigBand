<?php

namespace App\StateMachines\FeatureFlag;

use App\Enums\StateMachines\FeatureFlagState;

class OnFeatureFlagState extends BaseFeatureFlagState
{
    public function turnOff(): void
    {
        $this->changeStateTo(FeatureFlagState::Off);
    }
}
