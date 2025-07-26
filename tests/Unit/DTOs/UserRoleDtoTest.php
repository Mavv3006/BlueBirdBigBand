<?php

namespace Tests\Unit\DTOs;

use App\DataTransferObjects\UserRoleDto;
use Tests\TestCase;

class UserRoleDtoTest extends TestCase
{
    public function test_to_array()
    {
        $dto = new UserRoleDto(id: 20, name: 'test', assigned: true);

        $array = $dto->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('assigned', $array);
        $this->assertEquals($array['id'], $dto->id);
        $this->assertEquals($array['name'], $dto->name);
        $this->assertEquals($array['assigned'], $dto->assigned);
        $this->assertEquals(20, $array['id']);
        $this->assertEquals('test', $array['name']);
        $this->assertTrue($array['assigned']);
    }

    public function test_to_string()
    {
        $dto = new UserRoleDto(id: 20, name: 'test', assigned: true);
        $string = $dto->toString();
        $this->assertEquals($string, json_encode($dto));
        $this->assertStringContainsString('test', $string);
        $this->assertStringContainsString('id', $string);
        $this->assertStringContainsString('20', $string);
        $this->assertStringContainsString('assigned', $string);
    }
}
