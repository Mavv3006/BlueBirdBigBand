<?php

namespace StateMachines\FeatureFlag;

use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use Exception;
use Tests\TestCase;

class OnFeatureFlagStateTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTurnOff()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => 'test',
            'status' => FeatureFlagState::On,
        ]);

        $feature->state()->turnOff();

        $this->assertEquals(FeatureFlagState::Off, $feature->status);
    }

    public function testTurnOn()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => 'test',
            'status' => FeatureFlagState::On,
        ]);

        $this->expectException(Exception::class);
        $feature->state()->turnOn();
    }
}
