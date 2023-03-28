<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RolesSeeder::class);

        Role::where('name', 'admin')->first()->syncPermissions([
            'manage users',
            'access admin routes'
        ]);

        Role::where('name', 'musician')->first()->syncPermissions([
            'access intern routes'
        ]);

        User::factory()->create(['name' => 'admin', 'activated' => true])->assignRole('admin');
        User::factory()->create(['name' => 'musician', 'activated' => true])->assignRole('musician');
    }
}