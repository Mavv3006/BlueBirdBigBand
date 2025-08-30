<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstrumentResource\Pages\CreateInstrument;
use App\Filament\Resources\InstrumentResource\Pages\EditInstrument;
use App\Filament\Resources\InstrumentResource\Pages\ListInstruments;
use App\Filament\Resources\InstrumentResource\Pages\ViewInstrument;
use App\Filament\Resources\InstrumentResource\RelationManagers\MusiciansRelationManager;
use App\Models\Instrument;
use BackedEnum;
use Exception;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;

class InstrumentResource extends Resource
{
    protected static ?string $model = Instrument::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Instrumente';

    protected static string | UnitEnum | null $navigationGroup = 'Band';

    protected static ?string $pluralModelLabel = 'Instrumente';

    protected static ?string $modelLabel = 'Instrument';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->string()
                    ->autofocus(),
                TextInput::make('order')
                    ->label('Reihenfolge')
                    ->integer()
                    ->placeholder('leer')
                    ->unique('instruments'),
                TextInput::make('default_picture_filepath')
                    ->label('Pfad zum Bild')
                    ->required()
                    ->string(),
                TextInput::make('tux_filepath')
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
                TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('order')
                    ->label('Reihenfolge')
                    ->sortable()
                    ->default('leer'),
                TextColumn::make('name')
                    ->sortable(),
                TextColumn::make('musicians_count')
                    ->label('Anzahl der Musiker')
                    ->counts([
                        'musicians' => fn (Builder $query) => $query->where('isActive', '=', true),
                    ]),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('order not null')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('order'))
                    ->label('Aktiv')
                    ->indicator('Aktive Instrumente')
                    ->default(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('deactivate')
                        ->requiresConfirmation()
                        ->action(fn (Collection $collection) => $collection->each->update(['order' => null]))
                        ->label('Deaktivieren'),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
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
            'index' => ListInstruments::route('/'),
            'create' => CreateInstrument::route('/create'),
            'edit' => EditInstrument::route('/{record}/edit'),
            'view' => ViewInstrument::route('/{record}'),
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
