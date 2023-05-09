<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage roles']);
        Permission::create(['name' => 'route.access-intern']);
        Permission::create(['name' => 'route.access-admin']);
        Permission::create(['name' => 'manage musicians']);
        Permission::create(['name' => 'manage songs']);
        Permission::create(['name' => 'download songs']);
    }
}
