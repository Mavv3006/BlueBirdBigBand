<?php

namespace App\Http\Controllers\Inertia;

use App\Services\Song\SongService;
use Inertia\Inertia;
use Inertia\Response;

class InternalSongsController extends BaseInertiaController
{
    public function __construct(public SongService $songService)
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
        return Inertia::render('Intern/Songs', [
            'songs' => $this->songService->all(),
        ]);
    }
}
