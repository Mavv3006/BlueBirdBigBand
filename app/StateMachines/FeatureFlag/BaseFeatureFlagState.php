<?php

namespace App\StateMachines\FeatureFlag;

use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use Exception;

abstract class BaseFeatureFlagState
{
    public function __construct(public FeatureFlag $featureFlag)
    {
    }

    protected function changeStateTo(FeatureFlagState $newState): void
    {
        if ($this->featureFlag->status == $newState) {
            return;
        }

        $this->featureFlag->update([
            'status' => $newState,
        ]);
    }

    /**
     * @throws Exception
     */
    public function turnOn(): void
    {
        throw new Exception();
    }

    /**
     * @throws Exception
     */
    public function turnOff(): void
    {
        throw new Exception();
    }
}
