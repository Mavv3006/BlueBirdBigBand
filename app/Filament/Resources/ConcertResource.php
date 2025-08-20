<?php

namespace App\Filament\Resources;

use App\Enums\ConcertStatus;
use App\Filament\Resources\ConcertResource\Pages;
use App\Filament\Resources\ConcertResource\RelationManagers\SetlistRelationManager;
use App\Models\Concert;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ConcertResource extends Resource
{
    protected static ?string $model = Concert::class;

    protected static ?string $navigationIcon = 'icon-performance';

    protected static ?string $navigationLabel = 'Auftritte';

    protected static ?string $navigationGroup = 'Auftritte';

    protected static ?string $pluralModelLabel = 'Auftritte';

    protected static ?string $modelLabel = 'Auftritt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Band')
                    ->description('Wähle aus welche Band den Auftritt spielt.')
                    ->schema([
                        Select::make('band_id')
                            ->native(false)
                            ->label('Band')
                            ->searchable()
                            ->required()
                            ->preload()
                            ->relationship(name: 'band', titleAttribute: 'name'),
                    ]),
                Section::make('Datum und Uhrzeit')
                    ->description('Beschreibt an welchem Datum und von wann bis wann der Auftritt stattfindet.')
                    ->columns([
                        'default' => 1,
                        'sm' => 3,
                    ])
                    ->schema([
                        DatePicker::make('date')
                            ->label('Datum')
                            ->displayFormat('d M Y')
                            ->native(false)
                            ->weekStartsOnMonday()
                            ->closeOnDateSelection()
                            ->required()
                            ->minDate(now()),
                        TimePicker::make('start_time')
                            ->label('Startzeit')
                            ->seconds(false)
                            ->required(),
                        TimePicker::make('end_time')
                            ->label('Endzeit')
                            ->seconds(false)
                            ->required(),
                    ]),
                Section::make('Beschreibungen')
                    ->columns([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->schema([
                        TextInput::make('event_description')
                            ->label('Beschreibung')
                            ->required(),
                        TextInput::make('venue_description')
                            ->label('Name der Location')
                            ->required(),
                    ]),
                Section::make('Adresse')
                    ->description('An welcher Adresse wird die Band spielen?')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([
                            TextInput::make('venue_street')
                                ->required()
                                ->label('Straßenname'),
                            TextInput::make('venue_street_number')
                                ->required()
                                ->label('Hausnummer'),
                        ]),
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([
                            TextInput::make('venue_plz')
                                ->disabled()
                                ->label('Postleitzahl (PLZ)'),
                            Select::make('venue_plz')
                                ->native(false)
                                ->label('Ort')
                                ->searchable()
                                ->preload()
                                // TODO: make it work
//                                ->createOptionForm([
//                                    TextInput::make('plz')
//                                        ->numeric()
//                                        ->minValue(10000)
//                                        ->maxValue(99999)
//                                        ->unique('venues', 'plz')
//                                        ->required(),
//                                    TextInput::make('name')
//                                        ->required(),
//                                ])
                                ->relationship(name: 'venue', titleAttribute: 'name'),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date('l d M Y')
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
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn (ConcertStatus $state): string => match ($state) {
                        ConcertStatus::Draft => 'gray',
                        ConcertStatus::Public => 'success',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('set_public')
                        ->label('Veröffentlichen')
                        ->deselectRecordsAfterCompletion()
                        ->action(fn (Collection $records) => $records
                            ->filter(fn (Concert $record) => $record->status == ConcertStatus::Draft)
                            ->each(fn (Concert $record) => $record->setPublic())
                        ),
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
            SetlistRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConcerts::route('/'),
            'create' => Pages\CreateConcert::route('/create'),
            'edit' => Pages\EditConcert::route('/{record}/edit'),
            'view' => Pages\ViewConcert::route('/{record}'),
        ];
    }
}
