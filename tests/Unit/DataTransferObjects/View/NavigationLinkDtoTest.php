<?php

namespace Tests\Unit\DataTransferObjects\View;

use App\DataTransferObjects\View\NavigationLinkDto;
use App\Enums\NavigationLinkType;
use Tests\TestCase;

class NavigationLinkDtoTest extends TestCase
{
    public function test_constructor()
    {
        $dto = new NavigationLinkDto(
            name: 'test',
            link: '/navigation',
            type: NavigationLinkType::Link
        );

        $this->assertEquals('test', $dto->name);
        $this->assertEquals('/navigation', $dto->link);
        $this->assertEquals(NavigationLinkType::Link, $dto->type);
    }
}
