<?php

namespace Tests\Unit\DataTransferObjects;

use App\DataTransferObjects\AuthenticateDto;
use PHPUnit\Framework\TestCase;

class AuthenticateDtoTest extends TestCase
{
    public function test_constructor_sets_properties_correctly(): void
    {
        // Definieren der Testdaten
        $name = 'testuser';
        $password = 'securepassword123';

        // Erstellen einer Instanz des DTO
        $dto = new AuthenticateDto($name, $password);

        // Überprüfen, ob die Eigenschaften korrekt gesetzt wurden
        $this->assertEquals($name, $dto->name);
        $this->assertEquals($password, $dto->password);
    }
}
