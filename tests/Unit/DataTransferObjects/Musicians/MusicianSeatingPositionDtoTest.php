<?php

namespace Tests\Unit\DataTransferObjects\Musicians;

use App\DataTransferObjects\IdDto;
use App\DataTransferObjects\Musicians\MusicianSeatingPositionDto;
use PHPUnit\Framework\TestCase;

class MusicianSeatingPositionDtoTest extends TestCase
{
    /**
     * Testet, ob der Konstruktor die Eigenschaften korrekt setzt.
     */
    public function test_constructor_sets_properties_correctly(): void
    {
        // Definieren der Testdaten
        $instrumentId = 101;
        $musicians = [
            new IdDto(1),
            new IdDto(2),
            new IdDto(3),
        ];

        // Erstellen einer Instanz des DTO
        $dto = new MusicianSeatingPositionDto($instrumentId, $musicians);

        // Überprüfen, ob die instrument_id korrekt gesetzt wurde
        $this->assertEquals($instrumentId, $dto->instrument_id);

        // Überprüfen, ob die musicians korrekt gesetzt wurden und die richtigen Typen haben
        $this->assertIsArray($dto->musicians);
        $this->assertCount(3, $dto->musicians);

        foreach ($dto->musicians as $musician) {
            $this->assertInstanceOf(IdDto::class, $musician);
        }

        // Optional: Überprüfen der Werte der IdDto-Objekte
        $this->assertEquals(1, $dto->musicians[0]->id);
        $this->assertEquals(2, $dto->musicians[1]->id);
        $this->assertEquals(3, $dto->musicians[2]->id);
    }

    /**
     * Testet den Fall, wenn keine Musiker übergeben werden.
     */
    public function test_constructor_with_no_musicians(): void
    {
        $instrumentId = 200;
        $musicians = [];

        $dto = new MusicianSeatingPositionDto($instrumentId, $musicians);

        $this->assertEquals($instrumentId, $dto->instrument_id);
        $this->assertIsArray($dto->musicians);
        $this->assertEmpty($dto->musicians);
    }
}
