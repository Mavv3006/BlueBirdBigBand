<?php

namespace App\Filament\Resources\ConcertResource\Pages;

use App\Filament\Resources\ConcertResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListConcerts extends ListRecords
{
    protected static string $resource = ConcertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'upcoming' => Tab::make('zukünftige')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereDate('date', '>=', Carbon::today()->toDateString())),
            'past' => Tab::make('gespielte')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereDate('date', '<', Carbon::today()->toDateString())),
        ];
    }
}
