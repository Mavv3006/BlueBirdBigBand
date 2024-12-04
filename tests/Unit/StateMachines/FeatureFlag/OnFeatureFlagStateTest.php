<?php

namespace Tests\Unit\StateMachines\FeatureFlag;

use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use Exception;
use Tests\TestCase;

class OnFeatureFlagStateTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_turn_off()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => 'design_v2',
            'status' => FeatureFlagState::On,
        ]);

        $feature->state()->turnOff();

        $this->assertEquals(FeatureFlagState::Off, $feature->status);
    }

    public function test_turn_on()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => 'design_v2',
            'status' => FeatureFlagState::On,
        ]);

        $this->expectException(Exception::class);
        $feature->state()->turnOn();
    }
}
