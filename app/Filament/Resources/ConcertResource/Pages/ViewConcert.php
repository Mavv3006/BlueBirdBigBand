<?php

namespace App\Filament\Resources\ConcertResource\Pages;

use App\Filament\Resources\ConcertResource;
use App\Models\Concert;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewConcert extends ViewRecord
{
    protected static string $resource = ConcertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make()
                ->hidden($this->concertIsPlayed()),
        ];
    }

    private function concertIsPlayed(): bool
    {
        /**
         * @var Concert $concert
         */
        $concert = $this->getRecord();

        return $concert->isPlayed();
    }
}
