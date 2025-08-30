<?php

namespace App\Filament\Resources\MusicianResource\Pages;

use App\Filament\Resources\MusicianResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMusician extends EditRecord
{
    protected static string $resource = MusicianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
