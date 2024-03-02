<?php

namespace App\Http\Controllers\Admin;

use App\DataTransferObjects\View\InertiaMetaInfoDto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;

class AdminController extends BaseAdminController
{    public function index()
    {
        return Inertia::render('Admin/AdminIndex');
    }
}
