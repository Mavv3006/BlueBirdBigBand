<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Musician\MusicianService;

class MusiciansGroupedByInstrumentController extends Controller
{
    public function __construct(public MusicianService $service) {}

    public function __invoke()
    {
        return $this->service->activeMusicians();
    }
}
