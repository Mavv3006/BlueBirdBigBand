<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Services\Concert\ConcertService;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __construct(protected ConcertService $concertService)
    {
    }

    public function __invoke()
    {
        return Inertia::render('v2/Index', [
            'upcomingConcerts' => $this->concertService->upcoming(3),
        ]);
    }
}
