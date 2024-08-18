<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\BandNames;
use App\Enums\KonzertmeisterEventType;
use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use Carbon\Carbon;
use ICal\Event;
use ICal\ICal;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class KonzertmeisterUpdateConcertsController
{
    private BandNames $band_name;

    public function __invoke(Request $request): ResponseFactory|Application|Response
    {
        $validator = Validator::make($request->all(), [
            'apiKey' => [
                'required',
                'string',
                Rule::in([config('app.konzertmeister_api_key')]),
            ],
            'band_name' => [
                'required',
                'string',
                Rule::enum(BandNames::class),
            ],
        ]);

        if ($validator->fails()) {
            return response(null, SymfonyResponse::HTTP_BAD_REQUEST);
        }

        $this->band_name = BandNames::fromString($request->get('band_name'));

        $this->pullNewConcertData();

        return response(null, SymfonyResponse::HTTP_ACCEPTED);
    }

    private function pullNewConcertData()
    {
        $calendar = new ICal(config('app.konzertmeister_url'), [
            'defaultTimeZone' => 'Europe/Berlin',
            'filterDaysBefore' => Carbon::now(),
        ]);

        Log::debug('KonzertmeisterUpdateConcertsController', [
            'event count' => count($calendar->events()),
            'events' => $calendar->events(),
        ]);

        $band = $this->findBandToUse();

        $mappedCalendarEvents = array_map(fn (Event $event) => $this->mapCalendarEvents(event: $event, band: $band), $calendar->events());

        Log::debug('KonzertmeisterUpdateConcertsController', ['mapped events' => $mappedCalendarEvents]);

        KonzertmeisterEvent::upsert(
            $mappedCalendarEvents,
            uniqueBy: ['id'],
            update: ['summary', 'description', 'dtstart', 'dtend', 'location', 'type', 'band_id'],
        );

        Log::debug('KonzertmeisterUpdateConcertsController', [
            'konzertmeister count' => KonzertmeisterEvent::all()->count(),
            'konzertmeister events' => KonzertmeisterEvent::query()->orderBy('dtstart')->get(),
        ]);
    }

    protected function mapCalendarEvents(Event $event, Band $band): array
    {
        $type = $event->description == null ? null : KonzertmeisterEventType::fromIcal($event->description);
        $band_id = $band->id;

        // TODO: add splitting location for events
        // if ($event->location != null && str_contains($event->location, ' ') && str_contains($event->location, ',')) {
        //     [$street_name, $house_number, $plz, $city_name] = array_map(
        //         fn ($location) => explode(' ', trim($location)),
        //         explode(',', $event->location)
        //     );
        // }

        return [
            'id' => $event->uid,
            'summary' => $event->summary,
            'location' => $event->location,
            'dtstart' => Carbon::parse($event->dtstart),
            'dtend' => Carbon::parse($event->dtend),
            'description' => $event->description,
            'band_id' => $band_id,
            'type' => $type,
        ];
    }

    protected function findBandToUse(): Band
    {
        return match ($this->band_name) {
            BandNames::BlueBird => Band::whereName(BandNames::BlueBird->value)->firstOrFail(),
            BandNames::DomeTown => Band::whereName(BandNames::DomeTown->value)->firstOrFail(),
        };
    }
}
