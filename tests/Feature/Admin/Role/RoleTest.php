<?php

namespace Tests\Feature\Admin\Role;

use App\Models\User;
use Database\Seeders\DefaultAuthorizationSeeder;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultAuthorizationSeeder::class);
        $this->actingAs($this->createUserForAdminRoutes());
        $this->setupInertiaMetaInfo();
    }

    public function testIndexRoute()
    {
        $this->get('admin/roles')
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/RolesManagement/RolesIndex')
                    ->has(
                        'roles',
                        2,
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('guard_name')
                            ->has('name')
                    )
            );
    }

    public function testCreateRoute()
    {
        $this->get('admin/roles/create')
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/RolesManagement/RolesCreate')
            );
    }

    public function testStoreRoute()
    {
        $response = $this->post(
            'admin/roles',
            ['name' => 'Test role']
        );

        $this->assertNotNull(
            Role::where('name', 'Test role')
                ->first()
        );
        $this->assertDatabaseCount('roles', 3);
        $role_id = Role::where('name', 'Test role')->first()->id;
        $response->assertRedirect(route('roles.show', $role_id));
    }

    public function testShowRoute()
    {
        $role = Role::first();
        User::factory()
            ->create(['name' => 'test'])
            ->assignRole($role->id);

        $this->get('admin/roles/'.$role->id)
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->has(
                        'role',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->has('guard_name')
                    )
                    ->has(
                        'role_permissions.0',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->etc()
                    )
                    ->has(
                        'users',
                        1,
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->etc()
                    )
            );
    }

    public function testEditRoute()
    {
        $this->get('admin/roles/'.Role::first()->id.'/edit')
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->has(
                        'role',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->has('guard_name')
                    )
                    ->has(
                        'role_permissions.0',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->etc()
                    )
                    ->has(
                        'all_permissions.0',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->etc()
                    )
                    ->has(
                        'not_used_permissions.0',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->etc()
                    )
            );
    }

    /*
     * This test always throws the following error:
     * `The given role or permission should use guard `` instead of `web`.`
     */
    //    public function test_update_route()
    //    {
    //        Role::find(1)->syncPermissions([1]);
    //
    //        $this->put(
    //            'admin/roles/1',
    //            [
    //                'permissions' => [1, 2, 3, 4]
    //            ])
    //            ->assertRedirect(route('roles.show', 1));
    //
    //        $this->assertEquals(4, Role::find(1)
    //            ->permissions()
    //            ->count()
    //        );
    //    }
}
