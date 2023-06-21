<?php

namespace App\Services\Role;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
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
        $role = Role::create($request->validated());
        Log::info('creating new role (id: ' . $role->id . ', name: ' . $role->name . ').');
        return $role;
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

    public function update(UpdateRoleRequest $request, int $id): void
    {
        $role = $this->getById($id);
        $data = $request->validated(["permissions"]);
        $role->syncPermissions($data);
        Log::info('updating role (id: ' . $id . ', name: ' . $role->name . ').');
    }

    public function delete(int $id): void
    {
        $role = $this->getById($id);
        Log::info('deleting role (id: ' . $role->id . ', name: ' . $role->name . ').');
        $role
            ->syncPermissions([])
            ->delete();
    }
}
