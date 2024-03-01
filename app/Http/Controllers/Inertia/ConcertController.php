<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Inertia\BaseInertiaController;
use App\Services\Concert\ConcertService;
use Inertia\Inertia;
use Inertia\Response;

class ConcertController extends BaseInertiaController
{
    public function __construct(public ConcertService $concertService)
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
        return Inertia::render('LatestInfos/ConcertsPage', [
            'concerts' => $this->concertService->upcoming(),
        ]);
    }
}
