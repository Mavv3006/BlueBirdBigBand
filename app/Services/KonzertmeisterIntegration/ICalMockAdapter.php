<?php

namespace App\Services\KonzertmeisterIntegration;

use ICal\Event;

class ICalMockAdapter implements ICalInterface
{
    public function events(): array
    {
        return [
            new Event([
                'DTSTAMP' => '20240812T143121Z',
                'DTSTART' => '20240828T180000Z',
                'DTEND' => '20240828T200000Z',
                'SUMMARY' => 'BBBB Probe (BlueBirdBigBand)',
                'UID' => '2036713',
                'TZID' => 'Europe/Berlin',
                'URL' => 'https://web.konzertmeister.app/appointment/2036713',
                'GEO' => '49.3276295;8.4352534',
                'LOCATION' => 'Mausbergweg 144\, 67346 Speyer\, Deutschland',
                'DESCRIPTION' => 'Probe',
            ]),
            new Event([
                'DTSTAMP' => '20240812T143121Z',
                'DTSTART' => '20240904T180000Z',
                'DTEND' => '20240904T200000Z',
                'SUMMARY' => 'BBBB Probe (BlueBirdBigBand)',
                'UID' => '2036716',
                'TZID' => 'Europe/Berlin',
                'URL' => 'https://web.konzertmeister.app/appointment/2036716',
                'GEO' => '49.3276295;8.4352534',
                'LOCATION' => 'Langgasse 66\, 67454 Haßloch\, Deutschland',
                'DESCRIPTION' => 'Probe',
            ]),
            new Event([
                'DTSTAMP' => '20240812T143121Z',
                'DTSTART' => '20240911T180000Z',
                'DTEND' => '20240911T200000Z',
                'SUMMARY' => 'BBBB Probe (BlueBirdBigBand)',
                'UID' => '2036717',
                'TZID' => 'Europe/Berlin',
                'URL' => 'https://web.konzertmeister.app/appointment/2036717',
                'GEO' => '49.3276295;8.4352534',
                'LOCATION' => 'Mausbergweg 144\, 67346 Speyer\, Deutschland',
                'DESCRIPTION' => 'Auftritt - Brauerei-Saal alter Löwer 2x40min\, 20min Pause dazwischen\, danach 1 Runde Glühwein auf dem Weihnachtsmarkt Haßloch',
            ]),
            new Event([
                'DTSTAMP' => '20240812T143121Z',
                'DTSTART' => '20240918T180000Z',
                'DTEND' => '20240918T200000Z',
                'SUMMARY' => 'BBBB Probe (BlueBirdBigBand)',
                'UID' => '2036720',
                'TZID' => 'Europe/Berlin',
                'URL' => 'https://web.konzertmeister.app/appointment/2036720',
                'GEO' => '49.3276295;8.4352534',
                'LOCATION' => 'Martin-Luther-Straße 44\, 67433 Neustadt an der Weinstraße\, Deutschland',
                'DESCRIPTION' => 'lkasjdföalskdjf',
            ]),
        ];
    }

    public function setup(): \App\Services\KonzertmeisterIntegration\ICalInterface
    {
        return $this;
    }
}
