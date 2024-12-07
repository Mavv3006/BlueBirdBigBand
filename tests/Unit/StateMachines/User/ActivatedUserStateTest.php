<?php

namespace Tests\Unit\StateMachines\User;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Exception;
use Tests\TestCase;

class ActivatedUserStateTest extends TestCase
{
    public function testActivate()
    {
        $user = User::factory()->create(['status' => UserStates::Activated]);

        $this->expectException(Exception::class);
        $user->state()->activate();
    }
}
