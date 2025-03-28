<?php

namespace Tests\Unit\Services\Role;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleSyncPermissions extends TestCase
{
    public function test_guard_on_permissions_and_roles()
    {
        $permission = $this->createPermission();
        $role = $this->createRole();

        $this->assertEquals('web', $permission->guard_name);
        $this->assertEquals('web', $role->guard_name);
    }

    public function test_sync_permission()
    {
        $permission = $this->createPermission();
        $role = $this->createRole();

        $role->syncPermissions([$permission->id]);

        $this->assertTrue($role->hasPermissionTo($permission->name));
    }

    public function test_sync_permission2()
    {
        $permission = $this->createPermission();
        $role = $this->createRole();

        $role->syncPermissions([(string) $permission->id]);

        $this->assertTrue($role->hasPermissionTo($permission->name));
    }

    public function createRole(): Role
    {
        return Role::create(['name' => 'test']);
    }

    public function createPermission(): Permission
    {
        return Permission::create(['name' => 'test']);
    }
}
