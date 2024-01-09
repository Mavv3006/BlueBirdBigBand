<?php

namespace StateMachines\FeatureFlag;

use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use Exception;
use Tests\TestCase;

class OffFeatureFlagStateTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTurnOn()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => 'design_v2',
            'status' => FeatureFlagState::Off,
        ]);

        $feature->state()->turnOn();

        $this->assertEquals(FeatureFlagState::On, $feature->status);
    }

    public function testTurnOff()
    {
        $feature = FeatureFlag::factory()->create([
            'name' => 'design_v2',
            'status' => FeatureFlagState::Off,
        ]);

        $this->expectException(Exception::class);
        $feature->state()->turnOff();
    }
}
