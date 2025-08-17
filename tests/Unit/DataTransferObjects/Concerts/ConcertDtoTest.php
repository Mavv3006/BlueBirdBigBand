<?php

namespace Tests\Unit\DataTransferObjects\Concerts;

use App\DataTransferObjects\Concerts\ConcertDescriptionDto;
use App\DataTransferObjects\Concerts\ConcertDto;
use App\DataTransferObjects\Concerts\ConcertVenueDto;
use App\Models\Band;
use App\Models\Venue; // Angenommen, es gibt ein Venue Model
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ConcertDtoTest extends TestCase
{
    /**
     * Testet, ob der Konstruktor die Eigenschaften korrekt setzt.
     */
    public function test_constructor_sets_properties_correctly(): void
    {
        // Mocken der Abhängigkeiten
        $date = Carbon::create(2025, 12, 25, 19, 0, 0);

        // Mock für Band
        $bandMock = $this->createMock(Band::class);
        $bandMock->id = 123; // Setze eine ID für den Mock

        // Mock für Venue (innerhalb von ConcertVenueDto)
        $venueModelMock = $this->createMock(Venue::class);
        $venueModelMock->plz = '12345'; // Setze eine PLZ für den Mock

        // Mock für ConcertVenueDto
        $venueDto = new ConcertVenueDto(
            street: 'Teststraße', house_number: '10a', venue: $venueModelMock,
        );

        // Mock für ConcertDescriptionDto
        $descriptionDto = new ConcertDescriptionDto(
            event: 'Ein tolles Konzert', venue: 'Große Halle'
        );

        $startTime = '20:00';
        $endTime = '22:30';

        // Erstellen einer Instanz des DTO
        $dto = new ConcertDto(
            date: $date,
            band: $bandMock,
            start_time: $startTime,
            end_time: $endTime,
            venueDto: $venueDto,
            descriptionDto: $descriptionDto
        );

        // Überprüfen, ob die Eigenschaften korrekt gesetzt wurden
        $this->assertEquals($date, $dto->date);
        $this->assertEquals($bandMock, $dto->band);
        $this->assertEquals($startTime, $dto->start_time);
        $this->assertEquals($endTime, $dto->end_time);
        $this->assertEquals($venueDto, $dto->venueDto);
        $this->assertEquals($descriptionDto, $dto->descriptionDto);
    }

    /**
     * Testet die toArray-Methode, um sicherzustellen, dass sie die erwarteten Daten zurückgibt.
     */
    public function test_to_array_method_returns_correct_data(): void
    {
        // Mocken der Abhängigkeiten
        $date = Carbon::create(2025, 12, 25, 19);

        // Mock für Band
        $bandMock = Band::factory()->make(['id' => 456]);

        // Mock für Venue (innerhalb von ConcertVenueDto)
        $venueModelMock = Venue::factory()->make(['plz' => 54321]);

        // Mock für ConcertVenueDto
        $venueDto = new ConcertVenueDto(
            street: 'Musterweg', house_number: '5', venue: $venueModelMock,
        );

        // Mock für ConcertDescriptionDto
        $descriptionDto = new ConcertDescriptionDto(
            event: 'Rockkonzert', venue: 'Stadthalle'
        );

        $startTime = '19:30';
        $endTime = '23:00';

        // Erstellen einer Instanz des DTO
        $dto = new ConcertDto(
            date: $date,
            band: $bandMock,
            start_time: $startTime,
            end_time: $endTime,
            venueDto: $venueDto,
            descriptionDto: $descriptionDto
        );

        // Überprüfen, ob die toArray-Methode das erwartete Array zurückgibt
        $this->assertEquals([
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'event_description' => 'Rockkonzert',
            'venue_description' => 'Stadthalle',
            'venue_street' => 'Musterweg',
            'venue_street_number' => '5',
            'band_id' => 456,
            'venue_plz' => 54321,
        ], $dto->toArray());
    }
}
