<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\UserRoleRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class AssignRolesToUserController extends BaseAdminController
{
    public function __construct(protected UserService $userService)
    {
        parent::__construct();
    }

    public function showSearchForm(SearchUserRequest $request): Response
    {
        Gate::authorize('manage users');

        $data = $request->validated();

        if (!$request->has('username')) {
            return Inertia::render('Admin/UserManagement/SearchUser');
        }

        $user = $this->userService->findByUsername($data['username']);

        return Inertia::render(
            'Admin/UserManagement/AssignRoles',
            [
                'roleMap' => $this->userService->getRolesOfUser($user),
                'user' => ['name' => $user->name, 'id' => $user->id],
            ]
        );
    }

    public function syncRoles(User $user, UserRoleRequest $request): RedirectResponse
    {
        Gate::authorize('manage users');

        $this->userService->syncRoles($user, $request);

        return response()->redirectTo('admin/assign-roles');
    }
}
