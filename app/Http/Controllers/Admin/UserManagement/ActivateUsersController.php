<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ActivateUsersController extends Controller
{
    public function __construct(
        protected UserService $userService,
    )
    {
    }

    public function show(): Response
    {
        Gate::authorize('manage users');

        return Inertia::render(
            'Admin/ActivateUsers',
            ['users' => $this->userService->getNonActivatedUsers()]
        );
    }

    public function update(User $user): RedirectResponse
    {
        Gate::authorize('manage users');

        $this->userService->activateUser($user);
        return back();
    }
}
