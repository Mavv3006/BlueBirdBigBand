<?php

namespace App\Http\Controllers\Inertia;

use App\Services\Musician\MusicianService;
use Inertia\Inertia;
use Inertia\Response;

class MusiciansController extends BaseInertiaController
{
    public function __construct(public MusicianService $musicianService)
    {
    }

    public function getDescription(): string
    {
        return '';
    }

    public function getTitle(): string
    {
        return '';
    }

    public function render(): Response
    {
        return Inertia::render('Band/MusiciansPage', [
            'data' => $this->musicianService->activeMusicians(),
        ]);
    }
}
