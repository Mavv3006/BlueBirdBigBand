<?php

namespace Tests\Unit\Models;

use App\Enums\FeatureFlagName;
use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use App\StateMachines\FeatureFlag\OffFeatureFlagState;
use App\StateMachines\FeatureFlag\OnFeatureFlagState;
use Tests\TestCase;

class FeatureFlagTest extends TestCase
{
    public function test_state_off()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => FeatureFlagName::DesignV2,
            'status' => FeatureFlagState::Off,
        ]);
        $this->assertInstanceOf(OffFeatureFlagState::class, $feature->state());
    }

    public function test_state_on()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => FeatureFlagName::DesignV2,
            'status' => FeatureFlagState::On,
        ]);
        $this->assertInstanceOf(OnFeatureFlagState::class, $feature->state());

    }
}
