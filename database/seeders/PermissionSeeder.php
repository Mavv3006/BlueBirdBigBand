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
        Permission::create(['name' => 'access intern routes']);
        Permission::create(['name' => 'access admin routes']);
    }
}
