<?php

namespace App\Http\Controllers;

use App\Models\Song;
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

    public function songs(): Response
    {
        $this->checkAccessPermission();

        $songs = Song::select(['id', 'title', 'arranger', 'genre', 'author'])
            ->get();
        return Inertia::render('Intern/Songs', ['songs' => $songs]);
    }

    private function checkAccessPermission()
    {
        Gate::authorize('route.access-intern');
    }
}
