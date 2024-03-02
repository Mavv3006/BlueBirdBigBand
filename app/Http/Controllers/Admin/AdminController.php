<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

class AdminController extends BaseAdminController
{
    public function index()
    {
        return Inertia::render('Admin/AdminIndex');
    }
}
