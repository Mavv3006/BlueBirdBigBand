<?php

declare(strict_types=1);

namespace App\Services\KonzertmeisterIntegration;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use ICal\Event;
use ICal\ICal;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use UnhandledMatchError;

class KonzertmeisterIntegrationService
{
    /**
     * @throws InvalidArgumentException
     */
    public static function pullNewData(Band $band): void
    {
        $konzertmeisterUrl = config('app.konzertmeister_url');
        if ($konzertmeisterUrl === null) {
            Log::error('KonzertmeisterIntegrationService - config key "app.konzertmeister_url" is missing. Pulling new event data is not possible.');
            throw new InvalidArgumentException('Pulling new event data is not possible. Please check your log file for more information.');
        }

        $calendar = new ICal($konzertmeisterUrl, [
            'defaultTimeZone' => 'Europe/Berlin',
            // 'filterDaysBefore' => Carbon::now(),
        ]);

        Log::debug('KonzertmeisterIntegrationService - information about new events', [
            'event count' => count($calendar->events()),
            'events' => $calendar->events(),
        ]);

        $mappedCalendarEvents = array_map(
            callback: fn (Event $event) => CalendarEventMapping::fromICalEvent($event)
                ->setType(self::getEventType($event))
                ->setBand($band)
                ->splitLocation()
                ->trimDescription()
                ->shortenDescription()
                ->toArray(),
            array: $calendar->events());

        Log::debug('KonzertmeisterIntegrationService', ['mapped events' => $mappedCalendarEvents]);

        self::upsertAllEvents($mappedCalendarEvents);

        Log::debug('KonzertmeisterIntegrationService - information about all events in database', [
            'konzertmeister count' => KonzertmeisterEvent::count(),
            'konzertmeister events' => KonzertmeisterEvent::query()->orderBy('dtstart')->get(),
        ]);

        Log::info('KonzertmeisterIntegrationService - pulling new data completed');
    }

    protected static function getEventType(Event $event): ?KonzertmeisterEventType
    {
        try {
            return $event->description == null ? null : KonzertmeisterEventType::fromIcal($event->description);
        } catch (UnhandledMatchError) {
            Log::notice(
                message: 'KonzertmeisterIntegrationService - cannot get correct type from description - setting to default',
                context: ['event_id' => $event->uid, 'description' => $event->description]
            );

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
                values: $event,
                uniqueBy: ['id'],
                update: ['summary', 'description', 'dtstart', 'dtend', 'location', 'type', 'band_id'],
            );
        }
    }
}
