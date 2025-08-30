<?php

namespace App\Filament\Resources\Concerts;

use App\Filament\Resources\Concerts\Pages\CreateConcert;
use App\Filament\Resources\Concerts\Pages\EditConcert;
use App\Filament\Resources\Concerts\Pages\ListConcerts;
use App\Filament\Resources\Concerts\Pages\ViewConcert;
use App\Filament\Resources\Concerts\RelationManagers\SetlistRelationManager;
use App\Models\Concert;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ConcertResource extends Resource
{
    protected static ?string $model = Concert::class;

    protected static string | BackedEnum | null $navigationIcon = 'icon-performance';

    protected static ?string $navigationLabel = 'Auftritte';

    protected static string | UnitEnum | null $navigationGroup = 'Auftritte';

    protected static ?string $pluralModelLabel = 'Auftritte';

    protected static ?string $modelLabel = 'Auftritt';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                TextColumn::make('date')
                    ->date('l d M Y')
                    ->label('Datum')
                    ->sortable(),
                TextColumn::make('start_time')
                    ->dateTime('H:i')
                    ->label('Startzeit')
                    ->toggleable(),
                TextColumn::make('end_time')
                    ->dateTime('H:i')
                    ->label('Endzeit')
                    ->toggleable(),
                TextColumn::make('event_description')
                    ->label('Beschreibung')
                    ->searchable(),
                TextColumn::make('venue_description')
                    ->label('Name der Location')
                    ->searchable(),
                TextColumn::make('venue.name')
                    ->label('Auftrittsort')
                    ->searchable()
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
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
            'index' => ListConcerts::route('/'),
            'create' => CreateConcert::route('/create'),
            'edit' => EditConcert::route('/{record}/edit'),
            'view' => ViewConcert::route('/{record}'),
        ];
    }
}
