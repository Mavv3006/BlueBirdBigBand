<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Services\Song\SongService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

class InternController extends Controller
{
    public function __construct(
        public SongService $songService,
    ) {
    }

    public function index(): Redirector|RedirectResponse|Application
    {
        return redirect(route('home'), 301);
    }

    public function emails(): Response
    {
        return Inertia::render('Intern/Emails');
    }

    public function songs(): Response
    {
        return Inertia::render('Intern/Songs', [
            'songs' => $this->songService->all(),
        ]);
    }
}
