<?php

namespace App\Http\Controllers\Admin\MusicianManagement;

use App\Http\Controllers\Controller;
use App\Services\Musician\MusicianService;
use Inertia\Inertia;
use Inertia\Response;

class MusicianSeatingPositionController extends Controller
{
    public function __construct(public MusicianService $musicianService)
    {
    }

    public function show(): Response
    {
        $activeMusicians = $this->musicianService->activeMusicians();
        return Inertia::render(
            'Admin/MusicianManagement/SeatingPosition',
            ['data' => $activeMusicians]
        );
    }

    public function update()
    {

    }
}
