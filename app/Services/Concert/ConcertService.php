<?php

namespace App\Services\Concert;

use App\Models\Concert;
use Carbon\Carbon;

class ConcertService
{
    public function upcoming()
    {
        return Concert::with('band', 'venue')
            ->whereDate('date', '>=', Carbon::today()->toDateString())
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
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
    }
}
