<?php

namespace Models;

use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use App\StateMachines\FeatureFlag\OffFeatureFlagState;
use App\StateMachines\FeatureFlag\OnFeatureFlagState;
use Tests\TestCase;

class FeatureFlagTest extends TestCase
{
    public function testStateOff()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => 'tests',
            'status' => FeatureFlagState::Off,
        ]);
        $this->assertInstanceOf(OffFeatureFlagState::class, $feature->state());
    }

    public function testStateOn()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => 'tests',
            'status' => FeatureFlagState::On,
        ]);
        $this->assertInstanceOf(OnFeatureFlagState::class, $feature->state());

    }
}
