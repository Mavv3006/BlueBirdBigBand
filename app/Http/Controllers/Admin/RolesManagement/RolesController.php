<?php

namespace App\Http\Controllers\Admin\RolesManagement;

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

class RolesController extends Controller
{

    public function __construct(
        public RoleService       $roleService,
        public PermissionService $permissionService
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     *
     * @return Response
     */
    public function create(): Response
    {
        Gate::authorize('manage roles');

        return Inertia::render('Admin/RolesManagement/RolesCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(StoreRoleRequest $request): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage roles');

        $role = $this->roleService->create($request);
        return redirect(route('roles.show', $role->id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
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
                'users' => $this->roleService->getUsersOfRole($role)
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
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
                'all_permissions' => $this->permissionService->getAll()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param int $id
     * @return Redirector|RedirectResponse|Application
     */
    public function update(UpdateRoleRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage roles');

        $this->roleService->update($request, $id);
        return redirect(route('roles.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage roles');

        $this->roleService->delete($id);
        return redirect(route('roles.index'));
    }
}
