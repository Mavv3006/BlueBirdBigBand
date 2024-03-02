<?php

namespace App\Http\Controllers\Admin\RolesManagement;

use App\DataTransferObjects\IdDto;
use App\DataTransferObjects\Roles\RoleUpdateDto;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\Permission\PermissionService;
use App\Services\Role\RoleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class RolesController extends BaseAdminController
{
    public function __construct(
        public RoleService $roleService,
        public PermissionService $permissionService
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('manage roles');

        return Inertia::render(
            'Admin/RolesManagement/RolesIndex',
            ['roles' => $this->roleService->getAll()]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('manage roles');

        return Inertia::render('Admin/RolesManagement/RolesCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage roles');

        $role = $this->roleService->create($request);

        return redirect(route('roles.show', $role->id));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        Gate::authorize('manage roles');

        $role = $this->roleService->getById($id);

        return Inertia::render(
            'Admin/RolesManagement/RolesShow',
            [
                'role' => $role,
                'role_permissions' => $this->roleService->getPermissionsOfRole($role),
                'users' => $this->roleService->getUsersOfRole($role),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        Gate::authorize('manage roles');

        $role = $this->roleService->getById($id);

        return Inertia::render(
            'Admin/RolesManagement/RolesEdit',
            [
                'role' => $role,
                'role_permissions' => $this->roleService->getPermissionsOfRole($role),
                'not_used_permissions' => $this->roleService->getPermissionsNotInRole($role),
                'all_permissions' => $this->permissionService->getAll(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage roles');

        $data = $request->validated();
        $permissions = [];
        foreach ($data['permissions'] as $item) {
            $permissions = array_merge($permissions, [new IdDto($item)]);
        }

        $this->roleService->update(new RoleUpdateDto($id, $permissions));

        return redirect(route('roles.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage roles');

        $this->roleService->delete($id);

        return redirect(route('roles.index'));
    }
}
