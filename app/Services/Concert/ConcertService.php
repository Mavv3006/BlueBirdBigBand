<?php

namespace App\Services\Concert;

use App\DataTransferObjects\Concerts\ConcertAddressDto;
use App\DataTransferObjects\Concerts\ConcertDescriptionDto;
use App\DataTransferObjects\Concerts\ConcertDto;
use App\DataTransferObjects\Concerts\ConcertVenueDto;
use App\DataTransferObjects\Concerts\FormattedConcertDto;
use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ConcertService
{
    /**
     * @return Collection|FormattedConcertDto[]
     */
    public function upcoming(int $limit = null, bool $returnDtoFlag = false): Collection|array
    {
        $queryBuilder = Concert::with('band', 'venue')
            ->whereDate('date', '>=', Carbon::today()->toDateString())
            ->orderBy('date');

        if ($limit) {
            $queryBuilder->limit(3);
        }

        return $queryBuilder
            ->get()
            ->map(function (Concert $item) use ($returnDtoFlag) {
                $formattedConcertDto = $this->formatConcert($item);
                if ($returnDtoFlag) {
                    return $formattedConcertDto;
                }

                return $formattedConcertDto->toArray();
            });
    }

    public function formatConcert(Concert $concert): FormattedConcertDto
    {
        return new FormattedConcertDto(
            id: $concert->id,
            date: $concert->date,
            start_time: $concert->start_time,
            end_time: $concert->end_time,
            band: $concert->band->name,
            description: new ConcertDescriptionDto(
                event: $concert->event_description,
                venue: $concert->venue_description,
            ),
            address: new ConcertAddressDto(
                street: $concert->venue_street,
                number: $concert->venue_street_number,
                plz: $concert->venue_plz,
                city: $concert->venue->name
            ),
        );
    }

    public function allBands(): Collection
    {
        return Band::select(['id', 'name'])->get();
    }

    public function store(ConcertDto $dto): Concert
    {
        return Concert::create($dto->toArray());
    }

    public function update(Concert $concert, ConcertDto $concertDto): Concert
    {
        $concert->update($concertDto->toArray());

        return $concert;
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

    public function past(): Collection
    {
        return Concert::with('band', 'venue')
            ->whereDate('date', '<', Carbon::today()->toDateString())
            ->orderBy('date')
            ->get()
            ->map(function (Concert $item) {
                return $this->formatConcert($item)->toArray();
            });
    }

    public function delete(Concert $concert): void
    {
        Log::info('deleting concert', $concert->toArray());
        $concert->delete();
    }
}
