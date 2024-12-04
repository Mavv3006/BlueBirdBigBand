<?php

namespace App\Services\KonzertmeisterIntegration;

use ICal\Event;
use ICal\ICal;

class ICalAdapter implements ICalInterface
{
    protected ICal $ical;

    /**
     * @return Event[]
     */
    public function events(): array
    {
        return $this->ical->events();
    }

    public function setup(): self
    {
        $this->ical = new ICal(config('app.konzertmeister_url'), [
            'defaultTimeZone' => 'Europe/Berlin',
        ]);

        return $this;
    }
}
