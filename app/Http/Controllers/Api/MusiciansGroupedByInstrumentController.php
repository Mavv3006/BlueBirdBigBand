<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstrumentResource;
use App\Models\Instrument;
use App\Services\Musician\MusicianService;

class MusiciansGroupedByInstrumentController extends Controller
{
    public function __invoke()
    {
        $instruments = Instrument::with(['musicians' => function ($query) {
            $query->where('isActive', true)
                ->orderBy('firstname')
                ->orderBy('lastname');
        }])->orderBy('order')
            ->get();

        return InstrumentResource::collection($instruments);
    }
}
