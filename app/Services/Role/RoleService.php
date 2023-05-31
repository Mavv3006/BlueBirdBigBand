<?php

namespace App\Services\Role;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll(): Collection
    {
        return Role::select(['id', 'name'])
            ->orderBy('id')
            ->get();
    }

    public function create(StoreRoleRequest $request): Role
    {
        return Role::create($request->validated());
    }

    public function getById(int $id): Role
    {
        return Role::where('id', $id)
            ->select(['id', 'name'])
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
            ->select('id', 'name', 'activated')
            ->orderBy('id')
            ->get();
    }

    public function getPermissionsNotInRole(Role $role): Collection
    {
        return Permission::select('id')
            ->get()
            ->diff($role
                ->permissions()
                ->select('id')
                ->get());
    }

    public function update(UpdateRoleRequest $request, int $id): Role
    {
        $role = $this->getById($id);
        $data = $request->validated(["permissions"]);
        $role->syncPermissions($data);
        return $role;
    }
}
