<?php

namespace App\Filament\Resources\ConcertResource\Pages;

use App\Filament\Resources\ConcertResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConcerts extends ListRecords
{
    protected static string $resource = ConcertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
