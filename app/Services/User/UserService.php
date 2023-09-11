<?php

namespace App\Services\User;

use App\DataTransferObjects\UserRoleDto;
use App\Http\Requests\UserRoleRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserService
{
    public function getNonActivatedUsers(): Collection
    {
        return User::where('activated', false)
            ->select('id', 'name')
            ->get();
    }

    public function findByUsername(string $username): User
    {
        return User::firstWhere('name', $username);
    }

    /**
     * @return UserRoleDto[]
     */
    public function getRolesOfUser(User $user): array
    {
        $userRoles = $user->getRoleNames();

        $roleMap = Role::all()->map(function ($item) use ($userRoles) {
            return new UserRoleDto($item->id, $item->name, $userRoles->contains($item->name));
        });

        Log::debug(json_encode($roleMap));

        return $roleMap;
    }

    public function syncRoles(User $user, UserRoleRequest $request): void
    {
        $data = $request->validated();

        Log::debug(json_encode($data));
        $user->syncRoles($data['roles']);
        Log::info('Updating the role assignment for a user', [
            'user' => ['id' => $user->id, 'name' => $user->name],
            'roles' => $data['roles'],
        ]);
    }
}
