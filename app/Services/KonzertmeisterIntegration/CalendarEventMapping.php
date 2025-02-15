<?php

namespace App\Services\KonzertmeisterIntegration;

use App\Enums\KonzertmeisterEventType;
use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use Carbon\Carbon;
use ICal\Event;

class CalendarEventMapping
{
    private Band $band;

    private ?KonzertmeisterEventType $type;

    public function __construct(
        public readonly ?string $id,
        public readonly ?string $summary,
        public readonly ?string $location,
        public readonly Carbon  $dtstart,
        public readonly Carbon  $dtend,
        public readonly ?string $description,
    ) {}

    public static function fromICalEvent(Event $event): self
    {
        return new self(
            id: $event->uid,
            summary: $event->summary,
            location: $event->location,
            dtstart: Carbon::parse($event->dtstart),
            dtend: Carbon::parse($event->dtend),
            description: $event->description == null ? null : KonzertmeisterEvent::shortenDescription($event->description),
        );
    }

    public function splitLocation(): self
    {
        // TODO: add splitting location for events
        // if ($event->location != null && str_contains($event->location, ' ') && str_contains($event->location, ',')) {
        //     [$street_name, $house_number, $plz, $city_name] = array_map(
        //         fn ($location) => explode(' ', trim($location)),
        //         explode(',', $event->location)
        //     );
        // }
        return $this;
    }

    /**
     * @return array{
     *     uid: null|string,
     *     summary: null|string,
     *     location: null|string,
     *     dtstart: Carbon,
     *     dtend: Carbon,
     *     description: null|string,
     *     band_id: int,
     *     type: KonzertmeisterEventType|null
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'summary' => $this->summary,
            'location' => $this->location,
            'dtstart' => $this->dtstart,
            'dtend' => $this->dtend,
            'description' => $this->description,
            'band_id' => $this->band->id,
            'type' => $this->type,
        ];
    }

    public function setBand(Band $band): CalendarEventMapping
    {
        $this->band = $band;

        return $this;
    }

    public function setType(?KonzertmeisterEventType $type): CalendarEventMapping
    {
        $this->type = $type;

        return $this;
    }
}
