<?php

namespace App\StateMachines\FeatureFlag;

use App\Enums\StateMachines\FeatureFlagState;

class OffFeatureFlagState extends BaseFeatureFlagState
{
    public function turnOn(): void
    {
        $this->changeStateTo(FeatureFlagState::On);
    }
}
