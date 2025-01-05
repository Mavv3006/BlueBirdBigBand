<?php

namespace App\Filament\Resources\KonzertmeisterEventResource\Pages;

use App\Filament\Resources\KonzertmeisterEventResource;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventConversionStateDistribution;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventOverview;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventTypeDistribution;
use Filament\Resources\Pages\ListRecords;

class ListKonzertmeisterEvents extends ListRecords
{
    protected static string $resource = KonzertmeisterEventResource::class;

    protected function getHeaderWidgets(): array
    {
        return [KonzertmeisterEventOverview::class];
    }

    protected function getFooterWidgets(): array
    {
        return [
            KonzertmeisterEventTypeDistribution::class,
            KonzertmeisterEventConversionStateDistribution::class,
        ];
    }
}
