<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function getNonActivatedUsers(): Collection
    {
        return User::where('activated', false)
            ->select('id', 'name')
            ->get();
    }

    public function activateUser(User $user): void
    {
        $user->update(['activated' => true]);
        Log::debug('Updated user ' . $user->id);
    }
}
