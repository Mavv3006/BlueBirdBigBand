<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ActivateUsersController extends Controller
{
    public function show(): Response
    {
        $users = User::where('activated', false)
            ->select('id', 'name')
            ->get();

        return Inertia::render('Admin/ActivateUsers', ['users' => $users]);
    }

    public function update(User $user): RedirectResponse
    {
        $user->update(['activated' => true]);
        Log::debug('Updated user ' . $user->id);
        return back();
    }
}
