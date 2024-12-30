<?php

namespace Tests\Unit\Services\FeatureFlag;

use App\Enums\FeatureFlagName;
use App\Enums\StateMachines\FeatureFlagState;
use App\Models\FeatureFlag;
use App\Services\FeatureFlag\FeatureFlagService;
use Tests\TestCase;

class FeatureFlagServiceTest extends TestCase
{
    public function test_get_state_when_entry_in_database()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::On]);

        $result = FeatureFlagService::getState(FeatureFlagName::DesignV2);

        $this->assertEquals(FeatureFlagState::On, $result);
    }

    public function test_get_state_when_entry_missing_database()
    {
        $result = FeatureFlagService::getState(FeatureFlagName::DesignV2);

        $this->assertEquals(FeatureFlagState::Off, $result);
    }

    public function test_deactivate_when_entry_in_database()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::On]);

        $result = FeatureFlagService::deactivate(FeatureFlagName::DesignV2);

        $status = FeatureFlag::where('name', FeatureFlagName::DesignV2)->first()->status;
        $this->assertTrue($result);
        $this->assertEquals(FeatureFlagState::Off, $status);
    }

    public function test_deactivate_when_entry_missing_database()
    {
        $result = FeatureFlagService::deactivate(FeatureFlagName::DesignV2);

        $this->assertFalse($result);
    }

    public function test_deactivate_when_state_is_already_off()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::Off]);

        $result = FeatureFlagService::deactivate(FeatureFlagName::DesignV2);

        $status = FeatureFlag::where('name', FeatureFlagName::DesignV2)->first()->status;
        $this->assertTrue($result);
        $this->assertEquals(FeatureFlagState::Off, $status);
    }

    public function test_activate_when_entry_in_database()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::Off]);

        $result = FeatureFlagService::activate(FeatureFlagName::DesignV2);

        $status = FeatureFlag::where('name', FeatureFlagName::DesignV2)->first()->status;
        $this->assertTrue($result);
        $this->assertEquals(FeatureFlagState::On, $status);
    }

    public function test_activate_when_entry_missing_database()
    {
        $result = FeatureFlagService::activate(FeatureFlagName::DesignV2);

        $this->assertFalse($result);
    }

    public function test_activate_when_state_is_already_on()
    {
        FeatureFlag::factory()->create(['name' => FeatureFlagName::DesignV2, 'status' => FeatureFlagState::On]);

        $result = FeatureFlagService::activate(FeatureFlagName::DesignV2);

        $status = FeatureFlag::where('name', FeatureFlagName::DesignV2)->first()->status;
        $this->assertTrue($result);
        $this->assertEquals(FeatureFlagState::On, $status);
    }
}
