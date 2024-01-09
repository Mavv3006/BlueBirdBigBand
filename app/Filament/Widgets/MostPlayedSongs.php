<?php

namespace App\Filament\Widgets;

use App\Models\Song;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MostPlayedSongs extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Song::query()
                    ->with('setlistEntries')
                    ->join('setlist_entries', 'songs.id', '=', 'setlist_entries.song_id')
                    ->groupBy(['songs.id', 'songs.title'])
                    ->withCount('setlistEntries.concert_id')
                    ->select('songs.title', 'songs.id')
            )
            ->columns([
                TextColumn::make('title'),
            ]);
    }
}
