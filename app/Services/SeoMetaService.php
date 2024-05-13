<?php

namespace App\Services;

use App\DataTransferObjects\SeoMetaDto;

class SeoMetaService
{
    protected static ?SeoMetaDto $seoMetaDto = null;

    public static function getSeoMetaDto(): ?SeoMetaDto
    {
        return self::$seoMetaDto;
    }

    public static function setSeoMetaDto(SeoMetaDto $seoMetaDto): void
    {
        self::$seoMetaDto = $seoMetaDto;
    }
}
