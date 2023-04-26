<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\AvailableUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class AssignRolesToUserController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function showSearchForm(Request $request): Response
    {
        $data = $request->validate([
            'username' => ['string', new AvailableUser()]
        ]);

        if (!$request->has('username')) {
            return Inertia::render('Admin/UserManagement/SearchUser');
        }

        $user = User::firstWhere('name', $data['username']);
        $userRoles = $user->getRoleNames();

        $roleMap = Role::all()->map(function ($item) use ($userRoles) {
            $isRoleAssigned = $userRoles->contains($item->name);
            return ['id' => $item->id, 'name' => $item->name, 'assigned' => $isRoleAssigned];
        });

        Log::debug(json_encode($roleMap));
        return Inertia::render(
            'Admin/UserManagement/AssignRoles',
            [
                'roleMap' => $roleMap,
                'user' => ['name' => $user->name, 'id' => $user->id]
            ]
        );
    }

    public function syncRoles(User $user, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'roles' => 'array|required',
        ]);

        Log::debug(json_encode($data));
        $user->syncRoles($data['roles']);
        Log::info('Updating the role assignment for a user', [
            'user' => ['id' => $user->id, 'name' => $user->name],
            'roles' => $data['roles']
        ]);

        return response()->redirectTo('admin/assign-roles');
    }
}
