<?php

namespace App\Services\FeatureFlag;

use App\Enums\FeatureFlagName;
use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use Exception;

class FeatureFlagService
{
    public static function getState(FeatureFlagName $flagName): FeatureFlagState
    {
        return FeatureFlag::firstOrCreate(['name' => $flagName])->status;
    }

    /**
     * @return bool True, if the activation of the feature flag was successful. False otherwise.
     */
    public static function activate(FeatureFlagName $flagName): bool
    {
        try {
            $status = FeatureFlag::where('name', $flagName)->firstOrFail();
            if ($status->status == FeatureFlagState::On) {
                return true;
            }
            $status->state()->turnOn();

            return true;
        } catch (Exception) {
            return false;
        }
    }

    /**
     * @return bool True, if the deactivation of the feature flag was successful. False otherwise.
     */
    public static function deactivate(FeatureFlagName $flagName): bool
    {
        try {
            $status = FeatureFlag::where('name', $flagName)->firstOrFail();
            if ($status->status == FeatureFlagState::Off) {
                return true;
            }
            $status->state()->turnOff();

            return true;
        } catch (Exception) {
            return false;
        }
    }
}
