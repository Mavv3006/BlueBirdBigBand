<?php

namespace App\Services\KonzertmeisterIntegration;

use Carbon\Carbon;
use ICal\ICal;

class KonzertmeisterIntegrationService
{
    public Ical $calendar;

    public function __construct()
    {
        $this->calendar = new ICal('https://rest.konzertmeister.app/api/v1/ical/47d3bb2d-4499-4833-87bb-133266f93375?orgId=106461&history=false&excludeMeetingPoints=false&hideNegative=false', [
            'defaultTimeZone' => 'Europe/Berlin',
            'filterDaysBefore' => Carbon::now(),  // Default value
        ]);
    }

    public function filterConcerts() {}
}
