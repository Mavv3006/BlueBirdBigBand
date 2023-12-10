<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConcertResource\Pages;
use App\Models\Concert;
use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ConcertResource extends Resource
{
    protected static ?string $model = Concert::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    protected static ?string $navigationLabel = 'Auftritte';

    protected static ?string $navigationGroup = 'Auftritte';

    protected static ?string $pluralModelLabel = 'Auftritte';

    protected static ?string $modelLabel = 'Auftritt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date('d M Y')
                    ->label('Datum')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->dateTime('H:i')
                    ->label('Startzeit')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->dateTime('H:i')
                    ->label('Endzeit')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('event_description')
                    ->label('Beschreibung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('venue_description')
                    ->label('Name der Location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('venue.name')
                    ->label('Auftrittsort')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('past')
                    ->query(fn (Builder $query): Builder => $query->whereDate('date', '<', Carbon::today()->toDateString()))
                    ->label('vergangene')
                    ->indicator('Bereits gespielte Auftritte'),
                Tables\Filters\Filter::make('upcoming')
                    ->query(fn (Builder $query): Builder => $query->whereDate('date', '>=', Carbon::today()->toDateString()))
                    ->label('zukünftige')
                    ->indicator('Kommende Auftritte')
                    ->default(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('date');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConcerts::route('/'),
            'create' => Pages\CreateConcert::route('/create'),
            'edit' => Pages\EditConcert::route('/{record}/edit'),
        ];
    }
}
