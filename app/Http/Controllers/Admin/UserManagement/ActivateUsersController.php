<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ActivateUsersController extends Controller
{
    public function show(): Response
    {
        Gate::authorize('manage users');

        $users = User::where('activated', false)
            ->select('id', 'name')
            ->get();

        return Inertia::render('Admin/ActivateUsers', ['users' => $users]);
    }

    public function update(User $user): RedirectResponse
    {
        Gate::authorize('manage users');

        $user->update(['activated' => true]);
        Log::debug('Updated user ' . $user->id);
        return back();
    }
}
