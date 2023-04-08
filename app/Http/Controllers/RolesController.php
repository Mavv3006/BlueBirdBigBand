<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $roles = Role::select('id', 'name')->orderBy('id')->get();
        return Inertia::render('Admin/RolesManagement/RolesIndex', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
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
        $data = $request->validate(['name' => 'string|required|max:255']);
        $role = Role::create($data);
        return redirect(route('roles.show', $role->id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show(int $id): \Inertia\Response
    {
        $role = Role::where('id', $id)
            ->select('id', 'name')
            ->first();
        $role_permissions = $role
            ->permissions()
            ->select('id', 'name')
            ->get();
        $users = $role
            ->users()
            ->select('id', 'name', 'activated')
            ->get();
        $data = [
            'role' => $role,
            'role_permissions' => $role_permissions,
            'users' => $users
        ];
        Log::debug("RolesController::show", $data);
        return Inertia::render('Admin/RolesManagement/RolesShow', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
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
        $data = $request->validate(['permissions' => 'array|required']);
        Role::where('id', $id)->first()->syncPermissions($data["permissions"]);
        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $role = Role::where('id', $id)->first();
        Log::debug('delete role ' . $role->name);
        $role
            ->syncPermissions([])
            ->delete();
        return redirect(route('roles.index'));
    }
}
