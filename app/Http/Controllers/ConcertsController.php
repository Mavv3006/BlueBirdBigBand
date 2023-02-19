<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ConcertsController extends Controller
{
    public function index(): Response
    {
        $concerts = Concert::with('band', 'venue')
            ->whereDate('date', '>=', Carbon::today()->toDateString())
            ->get()
            ->map(function ($item, $key) {
                return [
                    'date' => $item->date->format('Y-m-d'),
                    'start_time' => $item->start_time->format('H:i'),
                    'end_time' => $item->end_time->format('H:i'),
                    'band' => $item->band->name,
                    'description' => [
                        'venue' => $item->venue_description,
                        'event' => $item->event_description
                    ],
                    'address' => [
                        'street' => $item->venue_street,
                        'number' => $item->venue_street_number,
                        'plz' => $item->venue_plz,
                        'city' => $item->venue->name
                    ]
                ];
            });
        Log::debug($concerts);
        return Inertia::render('LatestInfos/ConcertsPage', ['concerts' => $concerts]);
    }
}
