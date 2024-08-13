<?php

namespace App\StateMachines\User;

use App\Models\User;
use Exception;

abstract class BaseUserState
{
    public function __construct(public User $user) {}

    /**
     * @throws Exception
     */
    public function activate(): void
    {
        throw new Exception();
    }
}
