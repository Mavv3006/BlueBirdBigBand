<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class InternController extends Controller
{
    public function index(): Redirector|RedirectResponse|Application
    {
        $this->checkAccessPermission();
        return redirect(route('home'), 301);
    }

    public function emails(): Response
    {
        $this->checkAccessPermission();
        return Inertia::render('Intern/Emails');
    }

    private function checkAccessPermission()
    {
        Gate::authorize('route.access-intern');
    }
}
