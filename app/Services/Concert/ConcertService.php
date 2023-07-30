<?php

namespace App\Services\Concert;

use App\DataTransferObjects\Concerts\ConcertDescriptionDto;
use App\DataTransferObjects\Concerts\ConcertDto;
use App\DataTransferObjects\Concerts\ConcertVenueDto;
use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ConcertService
{
    public function upcoming()
    {
        return Concert::with('band', 'venue')
            ->whereDate('date', '>=', Carbon::today()->toDateString())
            ->orderBy('date')
            ->get()
            ->map(function (Concert $item) {
                return $this->formatConcert($item);
            });
    }

    public function formatConcert(Concert $concert): array
    {
        return [
            'id' => $concert->id,
            'date' => $concert->date->format('Y-m-d'),
            'start_time' => $concert->start_time->format('H:i'),
            'end_time' => $concert->end_time->format('H:i'),
            'band' => $concert->band->name,
            'description' => [
                'venue' => $concert->venue_description,
                'event' => $concert->event_description
            ],
            'address' => [
                'street' => $concert->venue_street,
                'number' => $concert->venue_street_number,
                'plz' => $concert->venue_plz,
                'city' => $concert->venue->name
            ]
        ];
    }

    public function allBands(): Collection
    {
        return Band::select(['id', 'name'])->get();
    }

    public function store(ConcertDto $dto): Concert
    {
        return Concert::create([
            'date' => $dto->date,
            'start_time' => $dto->start_time,
            'end_time' => $dto->end_time,
            'event_description' => $dto->descriptionDto->event,
            'venue_description' => $dto->descriptionDto->venue,
            'venue_street' => $dto->venueDto->street,
            'venue_street_number' => $dto->venueDto->house_number,
            'band_id' => $dto->band->id,
            'venue_plz' => $dto->venueDto->venue->plz
        ]);
    }

    public function createDto(array $data): ConcertDto
    {
        return new ConcertDto(
            Carbon::parse($data['date']),
            Band::find($data['band_id']),
            $data['times']['start'],
            $data['times']['end'],
            new ConcertVenueDto(
                $data['venue']['street'],
                $data['venue']['house_number'],
                $this->getRequestVenue($data)
            ),
            new ConcertDescriptionDto(
                $data['description']['event'],
                $data['description']['venue']
            )
        );
    }

    public function getRequestVenue(array $data): Venue
    {
        if ($data['venue']['create_new_venue']) {
            return Venue::firstOrCreate(
                ['plz' => $data['venue']['new_plz']],
                ['name' => $data['venue']['new_name']]
            );
        }
        return Venue::find($data['venue']['selected_plz']);
    }
}
