<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function store(Request $request, int $id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show(int $id): \Inertia\Response
    {

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
     * @return Response
     */
    public function destroy(int $id)
    {
        //
    }
}
