<?php

namespace App\Services\KonzertmeisterIntegration;

use App\Enums\BandName;
use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Exceptions\KonzertmeisterException;
use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use Carbon\Carbon;
use ICal\Event;
use Illuminate\Support\Facades\Log;
use UnhandledMatchError;

class KonzertmeisterIntegrationService
{
    public function __construct(public ICalInterface $ical) {}

    private BandName $bandName;

    public function setBandName(BandName $bandName): void
    {
        $this->bandName = $bandName;
    }

    /**
     * @throws KonzertmeisterException
     */
    public function pullNewData(): void
    {
        $calendar = $this->ical->setup();

        Log::debug('KonzertmeisterUpdateConcertsController - post ICal fetching', [
            'url' => config('app.konzertmeister_url'),
            'event count' => count($calendar->events()),
            'events' => $calendar->events(),
        ]);

        $events = $calendar->events();

        if (count($events) === 0) {
            throw KonzertmeisterException::noEventsFound();
        }

        $mappedCalendarEvents = array_map(
            callback: fn (Event $event) => $this->mapSingleCalendarEvent(event: $event, band: $this->findBandToUse()),
            array: $events);

        Log::debug('KonzertmeisterUpdateConcertsController - mapped events', ['mapped events' => $mappedCalendarEvents]);

        $this->upsertAllEvents($mappedCalendarEvents);
    }

    protected function mapSingleCalendarEvent(Event $event, Band $band): array
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
        return match ($this->bandName) {
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
                context: ['event_id' => $event->id, 'description' => $event->description]
            );

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
