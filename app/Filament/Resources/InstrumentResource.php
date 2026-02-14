<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstrumentResource\Pages;
use App\Filament\Resources\InstrumentResource\RelationManagers\MusiciansRelationManager;
use App\Models\Instrument;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class InstrumentResource extends Resource
{
    protected static ?string $model = Instrument::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Instrumente';

    protected static ?string $navigationGroup = 'Band';

    protected static ?string $pluralModelLabel = 'Instrumente';

    protected static ?string $modelLabel = 'InstrumentResource';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->string()
                    ->autofocus(),
                Forms\Components\TextInput::make('order')
                    ->label('Reihenfolge')
                    ->integer()
                    ->placeholder('leer')
                    ->unique('instruments'),
                Forms\Components\TextInput::make('default_picture_filepath')
                    ->label('Pfad zum Bild')
                    ->required()
                    ->string(),
                Forms\Components\TextInput::make('tux_filepath')
                    ->label('Pfad zum Tux Bild')
                    ->required()
                    ->string(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Reihenfolge')
                    ->sortable()
                    ->default('leer'),
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('musicians_count')
                    ->label('Anzahl der Musiker')
                    ->counts([
                        'musicians' => fn (Builder $query) => $query->where('isActive', '=', true),
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('order not null')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('order'))
                    ->label('Aktiv')
                    ->indicator('Aktive Instrumente')
                    ->default(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->requiresConfirmation()
                        ->action(fn (Collection $collection) => $collection->each->update(['order' => null]))
                        ->label('Deaktivieren'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('order');
    }

    public static function getRelations(): array
    {
        return [
            MusiciansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstruments::route('/'),
            'create' => Pages\CreateInstrument::route('/create'),
            'edit' => Pages\EditInstrument::route('/{record}/edit'),
            'view' => Pages\ViewInstrument::route('/{record}'),
        ];
    }

    //    public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    //    {
    //        return $infolist
    //            ->schema([
    //                \Filament\Infolists\Components\Grid::make(1)
    //                    ->schema([
    //                        \Filament\Infolists\Components\TextEntry::make('name'),
    //                        \Filament\Infolists\Components\RepeatableEntry::make('musicians')
    //                            ->label('Musiker')
    //                            ->columns(4)
    //                            ->schema([
    //                                \Filament\Infolists\Components\TextEntry::make('id')
    //                                    ->label('ID'),
    //                                \Filament\Infolists\Components\TextEntry::make('firstname')
    //                                    ->label('Vorname'),
    //                                \Filament\Infolists\Components\TextEntry::make('lastname')
    //                                    ->label('Nachname'),
    //                                \Filament\Infolists\Components\TextEntry::make('isActive')
    //                                    ->label('Status')
    //                                    ->badge()
    //                                    ->formatStateUsing(fn(string $state): string => $state ? "Aktiv" : "Inaktiv")
    //                                    ->color(function (int $state): string {
    //                                        \Illuminate\Support\Facades\Log::debug('states: ' . $state, [$state]);
    //                                        $color = match ($state) {
    //                                            1 => 'success',
    //                                            0 => 'warning',
    //                                            default => 'danger',
    //                                        };
    //                                        \Illuminate\Support\Facades\Log::debug('color: ' . $color);
    //                                        return $color;
    //                                    }),
    //                            ]),
    //                    ])
    //            ]);
    //    }
}
