<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        Gate::authorize('manage roles');

        $roles = Role::select('id', 'name')
            ->orderBy('id')
            ->get();

        Log::info('showing index view for all roles.');
        return Inertia::render('Admin/RolesManagement/RolesIndex', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        Gate::authorize('manage roles');

        Log::info('showing create view for a new role.');
        return Inertia::render('Admin/RolesManagement/RolesCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage roles');

        $data = $request->validate(['name' => 'string|required|max:255']);
        $role = Role::create($data);

        Log::info('creating new role (id: ' . $role->id . ', name: ' . $role->name . ').');
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

        $role = Role::where('id', $id)
            ->select('id', 'name')
            ->first();
        $role_permissions = $role
            ->permissions()
            ->select('id', 'name')
            ->orderBy('id')
            ->get();
        $users = $role
            ->users()
            ->select('id', 'name', 'activated')
            ->orderBy('id')
            ->get();
        $data = [
            'role' => $role,
            'role_permissions' => $role_permissions,
            'users' => $users
        ];

        Log::info('showing role (id: ' . $role->id . ', name: ' . $role->name . ').');
        Log::debug("RolesController::show", $data);
        return Inertia::render('Admin/RolesManagement/RolesShow', $data);
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

        $all_permissions = Permission::select('id', 'name')
            ->get();
        $role = Role::where('id', $id)
            ->select('id', 'name')
            ->first();
        $role_permissions = $role
            ->permissions()
            ->select('id')
            ->get();
        $not_used_permissions = Permission::select('id')
            ->get()
            ->diff($role
                ->permissions()
                ->select('id')
                ->get());
        $data = [
            'role' => $role,
            'role_permissions' => $role_permissions,
            'not_used_permissions' => $not_used_permissions,
            'all_permissions' => $all_permissions
        ];

        Log::info('showing edit view for role (id: ' . $role->id . ', name: ' . $role->name . ').');
        Log::debug("RolesController::edit", $data);
        return Inertia::render('Admin/RolesManagement/RolesEdit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Redirector|RedirectResponse|Application
     */
    public function update(Request $request, int $id): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage roles');

        $data = $request->validate(['permissions' => 'array|required']);
        $role = Role::where('id', $id)
            ->first();
        $role
            ->syncPermissions($data["permissions"]);

        Log::info('updating role (id: ' . $id . ', name: ' . $role->name . ').');
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

        $role = Role::where('id', $id)->first();
        Log::info('deleting role (id: ' . $role->id . ', name: ' . $role->name . ').');
        $role
            ->syncPermissions([])
            ->delete();

        return redirect(route('roles.index'));
    }
}
