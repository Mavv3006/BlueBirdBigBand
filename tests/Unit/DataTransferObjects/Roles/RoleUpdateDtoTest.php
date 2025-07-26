<?php

namespace Tests\Unit\DataTransferObjects\Roles;

use App\DataTransferObjects\IdDto;
use App\DataTransferObjects\Roles\RoleUpdateDto;
use Tests\TestCase;

class RoleUpdateDtoTest extends TestCase
{
    public function test_construct_false_type()
    {
        $dto = new RoleUpdateDto(
            role_id: 4,
            permission_ids: [1, 2, 3]
        );

        $this->assertEquals(4, $dto->role_id);
        $this->assertEquals([1, 2, 3], $dto->permission_ids);
        $this->assertNotInstanceOf(IdDto::class, $dto->permission_ids[0]);
    }

    public function test_construct()
    {
        $dto = new RoleUpdateDto(
            role_id: 4,
            permission_ids: [
                new IdDto(1),
                new IdDto(2),
                new IdDto(3),
            ]
        );

        $this->assertEquals(4, $dto->role_id);
        $this->assertEquals(1, $dto->permission_ids[0]->id);
        $this->assertEquals(2, $dto->permission_ids[1]->id);
        $this->assertEquals(3, $dto->permission_ids[2]->id);
        $this->assertInstanceOf(IdDto::class, $dto->permission_ids[0]);
    }
}
