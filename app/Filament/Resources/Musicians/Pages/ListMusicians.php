<?php

namespace App\Filament\Resources\Musicians\Pages;

use App\Filament\Resources\Musicians\MusicianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMusicians extends ListRecords
{
    protected static string $resource = MusicianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
