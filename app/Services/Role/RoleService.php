<?php

namespace App\Services\Role;

use App\DataTransferObjects\IdDto;
use App\DataTransferObjects\Roles\RoleUpdateDto;
use App\Http\Requests\StoreRoleRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll(): Role
    {
        return Role::select(['id', 'name', 'guard_name'])
            ->orderBy('id')
            ->get();
    }

    public function create(StoreRoleRequest $request): Role
    {
        $role = Role::create($request->validated());
        Log::info('creating new role (id: '.$role->id.', name: '.$role->name.').');

        return $role;
    }

    public function getById(int $id): Role
    {
        return Role::where('id', $id)
            ->select(['id', 'name', 'guard_name'])
            ->first();
    }

    public function getPermissionsOfRole(Role $role): Collection
    {
        return $role
            ->permissions()
            ->select('id', 'name')
            ->orderBy('id')
            ->get();
    }

    public function getUsersOfRole(Role $role): Collection
    {
        return $role
            ->users()
            ->select('id', 'name', 'status')
            ->orderBy('id')
            ->get();
    }

    public function getPermissionsNotInRole(Role $role): Collection
    {
        return Permission::select('id')
            ->diff($role
                ->permissions()
                ->select('id')
                ->get());
    }

    public function update(RoleUpdateDto $dto): void
    {
        $role = $this->getById($dto->role_id);
        $data = array_map(function (IdDto $idDto) {
            return Permission::find($idDto->id);
        }, $dto->permission_ids);
        $role->syncPermissions($data);
        Log::info('updating role (id: '.$role->id.', name: '.$role->name.').');
    }

    public function delete(int $id): void
    {
        $role = $this->getById($id);
        Log::info('deleting role (id: '.$role->id.', name: '.$role->name.').');
        $role
            ->syncPermissions([])
            ->delete();
    }
}
