<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ActiveMusicianController extends Controller
{
    public function show(): Response
    {
        $activeMusicians = [];
        $instruments = Instrument::select(['name', 'default_picture_filepath'])->get();
        foreach ($instruments as $instrument) {
            $musicians = DB::table('musicians')
                ->join('instruments', 'musicians.instrument_id', '=', 'instruments.id')
                ->where([
                    'instruments.name' => $instrument->name,
                    'musicians.isActive' => true
                ])
                ->select([
                    'musicians.firstname',
                    'musicians.lastname',
                    'musicians.picture_filepath',
                ])->get();
            $activeMusicians = array_merge($activeMusicians, [['instrument' => $instrument, 'musicians' => $musicians]]
            );
        }

        return Inertia::render('Band/MusiciansPage', ['data' => $activeMusicians]);
    }
}


