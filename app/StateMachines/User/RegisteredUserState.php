<?php

namespace App\StateMachines\User;

use App\Enums\StateMachines\UserStates;
use Illuminate\Support\Facades\Log;

class RegisteredUserState extends BaseUserState
{
    public function activate(): void
    {
        $this->user->update(['status' => UserStates::Activated]);
        Log::info('Activating user', ['user' => $this->user]);
    }
}
