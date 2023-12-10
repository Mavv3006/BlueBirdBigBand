<?php

namespace App\Filament\Resources\ConcertResource\Pages;

use App\Filament\Resources\ConcertResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewConcert extends ViewRecord
{
    protected static string $resource = ConcertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make()
                ->hidden($this->isPlayedConcert()),
        ];
    }

    private function isPlayedConcert(): bool
    {
        return $this->record->isPlayed();
    }
}
