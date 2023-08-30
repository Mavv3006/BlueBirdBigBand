<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RolesSeeder::class);

        Role::where('name', 'admin')
            ->first()
            ->syncPermissions([
                'manage users',
                'manage roles',
                'manage musicians',
                'manage songs',
                'route.access-admin',
                'download songs',
            ]);

        Role::where('name', 'musician')
            ->first()
            ->syncPermissions([
                'route.access-intern',
                'download songs',
            ]);
    }
}
