<?php

namespace App\Filament\Resources\ConcertResource\Pages;

use App\Filament\Resources\ConcertResource;
use App\Models\Concert;
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
