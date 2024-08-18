<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\BandName;
use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
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
use UnhandledMatchError;

class KonzertmeisterUpdateConcertsController
{
    private BandName $band_name;

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
                Rule::enum(BandName::class),
            ],
        ]);

        if ($validator->fails()) {
            return response(null, SymfonyResponse::HTTP_BAD_REQUEST);
        }

        $this->band_name = BandName::fromString($validator->validated()['band_name']);

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

        $mappedCalendarEvents = array_map(
            callback: fn (Event $event) => $this->mapCalendarEvents(event: $event, band: $this->findBandToUse()),
            array: $calendar->events());

        Log::debug('KonzertmeisterUpdateConcertsController', ['mapped events' => $mappedCalendarEvents]);

        $this->upsertAllEvents($mappedCalendarEvents);

        Log::debug('KonzertmeisterUpdateConcertsController', [
            'konzertmeister count' => KonzertmeisterEvent::all()->count(),
            'konzertmeister events' => KonzertmeisterEvent::query()->orderBy('dtstart')->get(),
        ]);
    }

    protected function mapCalendarEvents(Event $event, Band $band): array
    {
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
            'band_id' => $band->id,
            'type' => $this->getEventType($event),
        ];
    }

    protected function findBandToUse(): Band
    {
        return match ($this->band_name) {
            BandName::BlueBird => Band::whereName(BandName::BlueBird->value)->firstOrFail(),
            BandName::DomeTown => Band::whereName(BandName::DomeTown->value)->firstOrFail(),
        };
    }

    protected function getEventType(Event $event): ?KonzertmeisterEventType
    {
        try {
            return $event->description == null ? null : KonzertmeisterEventType::fromIcal($event->description);
        } catch (UnhandledMatchError) {
            Log::notice(
                message: 'KonzertmeisterUpdateConcertsController - cannot get correct type from description - setting to default',
                context: ['event_id' => $event->id, 'description' => $event->description]);

            return KonzertmeisterEventType::Sonstiges;
        }
    }

    protected function upsertAllEvents(array $mappedCalendarEvents): void
    {
        foreach ($mappedCalendarEvents as $event) {
            $savedEvent = KonzertmeisterEvent::find($event['id']);
            if ($savedEvent != null && $savedEvent->conversion_state == KonzertmeisterEventConversionState::Rejected) {
                continue;
            }

            KonzertmeisterEvent::upsert(
                $event,
                uniqueBy: ['id'],
                update: ['summary', 'description', 'dtstart', 'dtend', 'location', 'type', 'band_id'],
            );
        }
    }
}
