<?php

namespace App\Http\Controllers\Admin\MusicianManagement;

use App\Http\Controllers\Controller;
use App\Services\Musician\MusicianService;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class MusicianSeatingPositionController extends Controller
{
    public function __construct(public MusicianService $musicianService)
    {
    }

    public function show(): Response
    {
        Log::debug('test');
        return Inertia::render(
            'Admin/MusicianManagement/SeatingPosition',
            ['data' => $this->musicianService->activeMusicians()]
        );
    }

    public function update()
    {

    }
}
