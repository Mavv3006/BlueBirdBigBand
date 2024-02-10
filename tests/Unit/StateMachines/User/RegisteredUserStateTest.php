<?php

namespace Tests\Unit\StateMachines\User;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Exception;
use Tests\TestCase;

class RegisteredUserStateTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_activate_user()
    {
        $user = User::factory()->create();

        $user->state()->activate();

        $this->assertEquals(UserStates::Activated, $user->status);
    }
}
