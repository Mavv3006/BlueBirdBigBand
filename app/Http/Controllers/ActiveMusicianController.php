<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Inertia\Inertia;
use Inertia\Response;

class ActiveMusicianController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Band/MusiciansPage', [
            'data' => Instrument::all()->map(fn(Instrument $instrument) => [
                'instrument' => $instrument,
                'musicians' => $instrument->musicians()->get()
            ])
        ]);
    }
}


