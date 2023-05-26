<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\Instrument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class PublicController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Index');
    }

    public function aboutUs(): Response
    {
        return Inertia::render('Band/AboutPage');
    }

    public function arrival(): Response
    {
        return Inertia::render('Band/ArrivalPage');
    }

    public function concerts(): Response
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

    public function booking(): Response
    {
        return Inertia::render('LatestInfos/BookingPage');
    }

    public function imprint(): Response
    {
        return Inertia::render('Contact/ImprintPage');
    }

    public function contact(): Response
    {
        return Inertia::render('Contact/ContactPage');
    }

    public function pressInfo(): Response
    {
        return Inertia::render('LatestInfos/PressInfoPage');
    }

    public function musicians(): Response
    {
        return Inertia::render('Band/MusiciansPage', [
            'data' => Instrument::all()->map(fn(Instrument $instrument) => [
                'instrument' => $instrument,
                'musicians' => $instrument->musicians()->get()
            ])
        ]);
    }
}
