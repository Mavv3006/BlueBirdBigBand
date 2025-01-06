<?php

declare(strict_types=1);

namespace App\Services\KonzertmeisterIntegration;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use Carbon\Carbon;
use ICal\Event;
use ICal\ICal;
use Illuminate\Support\Facades\Log;
use UnhandledMatchError;

class KonzertmeisterIntegrationService
{
    public static function pullNewData(Band $band): void
    {
        Log::info('KonzertmeisterIntegrationService - starting to pull new Konzertmeister events for band "'.$band->name.'" ('.$band->id.')');

        $calendar = new ICal(config('app.konzertmeister_url'), [
            'defaultTimeZone' => 'Europe/Berlin',
            // 'filterDaysBefore' => Carbon::now(),
        ]);

        Log::debug('KonzertmeisterIntegrationService', [
            'event count' => count($calendar->events()),
            'events' => $calendar->events(),
        ]);

        $mappedCalendarEvents = array_map(
            callback: fn (Event $event) => self::mapCalendarEvents($event, $band),
            array: $calendar->events());

        Log::debug('KonzertmeisterIntegrationService', ['mapped events' => $mappedCalendarEvents]);

        self::upsertAllEvents($mappedCalendarEvents);

        Log::debug('KonzertmeisterIntegrationService', [
            'konzertmeister count' => KonzertmeisterEvent::all()->count(),
            'konzertmeister events' => KonzertmeisterEvent::query()->orderBy('dtstart')->get(),
        ]);
    }

    protected static function mapCalendarEvents(Event $event, Band $band): array
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
            'description' => KonzertmeisterEvent::shortenDescription($event->description),
            'band_id' => $band->id,
            'type' => self::getEventType($event),
        ];
    }

    protected static function getEventType(Event $event): ?KonzertmeisterEventType
    {
        try {
            return $event->description == null ? null : KonzertmeisterEventType::fromIcal($event->description);
        } catch (UnhandledMatchError) {
            Log::notice(
                message: 'KonzertmeisterIntegrationService - cannot get correct type from description - setting to default',
                context: ['event_id' => $event->id, 'description' => $event->description]);

            return KonzertmeisterEventType::Sonstiges;
        }
    }

    protected static function upsertAllEvents(array $mappedCalendarEvents): void
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
