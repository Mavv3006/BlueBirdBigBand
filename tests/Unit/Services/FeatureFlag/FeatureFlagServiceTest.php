<?php

namespace Services\FeatureFlag;

use App\Enums\FeatureFlagName;
use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use App\Services\FeatureFlag\FeatureFlagService;
use Tests\TestCase;

class FeatureFlagServiceTest extends TestCase
{
    public function testGetStateWhenEntryInDatabase()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::On]);

        $result = FeatureFlagService::getState(FeatureFlagName::DesignV2);

        $this->assertEquals(FeatureFlagState::On, $result);
    }

    public function testGetStateWhenEntryMissingDatabase()
    {
        $result = FeatureFlagService::getState(FeatureFlagName::DesignV2);

        $this->assertEquals(FeatureFlagState::Off, $result);
    }

    public function testDeactivateWhenEntryInDatabase()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::On]);

        $result = FeatureFlagService::deactivate(FeatureFlagName::DesignV2);

        $status = FeatureFlag::where('name', FeatureFlagName::DesignV2)->first()->status;
        $this->assertTrue($result);
        $this->assertEquals(FeatureFlagState::Off, $status);
    }

    public function testDeactivateWhenEntryMissingDatabase()
    {
        $result = FeatureFlagService::deactivate(FeatureFlagName::DesignV2);

        $this->assertFalse($result);
    }

    public function testDeactivateWhenStateIsAlreadyOff()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::Off]);

        $result = FeatureFlagService::deactivate(FeatureFlagName::DesignV2);

        $status = FeatureFlag::where('name', FeatureFlagName::DesignV2)->first()->status;
        $this->assertTrue($result);
        $this->assertEquals(FeatureFlagState::Off, $status);
    }

    public function testActivateWhenEntryInDatabase()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::Off]);

        $result = FeatureFlagService::activate(FeatureFlagName::DesignV2);

        $status = FeatureFlag::where('name', FeatureFlagName::DesignV2)->first()->status;
        $this->assertTrue($result);
        $this->assertEquals(FeatureFlagState::On, $status);
    }

    public function testActivateWhenEntryMissingDatabase()
    {
        $result = FeatureFlagService::activate(FeatureFlagName::DesignV2);

        $this->assertFalse($result);
    }

    public function testActivateWhenStateIsAlreadyOn()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::On]);

        $result = FeatureFlagService::activate(FeatureFlagName::DesignV2);

        $status = FeatureFlag::where('name', FeatureFlagName::DesignV2)->first()->status;
        $this->assertTrue($result);
        $this->assertEquals(FeatureFlagState::On, $status);
    }
}
