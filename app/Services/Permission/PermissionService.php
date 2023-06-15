<?php

namespace App\Services\Permission;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function getAll()
    {
        return Permission::select('id', 'name')
            ->get();
    }
}
