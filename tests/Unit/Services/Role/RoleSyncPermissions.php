<?php

namespace Services\Role;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleSyncPermissions extends TestCase
{
    public function testGuardOnPermissionsAndRoles()
    {
        $permission = $this->createPermission();
        $role = $this->createRole();

        $this->assertEquals('web', $permission->guard_name);
        $this->assertEquals('web', $role->guard_name);
    }

    public function testSyncPermission()
    {
        $permission = $this->createPermission();
        $role = $this->createRole();

        $role->syncPermissions([$permission->id]);

        $this->assertTrue($role->hasPermissionTo($permission->name));
    }

    public function testSyncPermission2()
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
