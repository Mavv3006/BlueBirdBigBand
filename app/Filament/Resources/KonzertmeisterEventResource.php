<?php

namespace App\Filament\Resources;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Filament\Resources\KonzertmeisterEventResource\Pages;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventConversionStateDistribution;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventOverview;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventTypeDistribution;
use App\Models\Concert;
use App\Models\KonzertmeisterEvent;
use App\Models\Venue;
use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class KonzertmeisterEventResource extends Resource
{
    protected static ?string $model = KonzertmeisterEvent::class;

    protected static ?string $navigationIcon = 'icon-event-o';

    protected static ?string $navigationGroup = 'Auftritte';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dtstart')
                    ->label('Beginn')
                    ->dateTime('D d M Y H:i')
                    ->sortable(),
                TextColumn::make('dtend')
                    ->label('Ende')
                    ->dateTime('D d M Y H:i')
                    ->sortable(),
                TextColumn::make('summary')
                    ->label('Beschreibung'),
                TextColumn::make('band.name')
                    ->label('Band')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('location')
                    ->label('Ort')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('type')
                    ->label('Typ')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon(fn (KonzertmeisterEventType $state): string => match ($state) {
                        KonzertmeisterEventType::Probe => 'icon-movie-open',
                        KonzertmeisterEventType::Auftritt => 'icon-performance',
                        KonzertmeisterEventType::Sonstiges => 'icon-tag-question-mark-16',
                    }),
                TextColumn::make('conversion_state')
                    ->label('Status')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge()
                    ->color(fn (KonzertmeisterEventConversionState $state): string => match ($state) {
                        KonzertmeisterEventConversionState::Open => 'info',
                        KonzertmeisterEventConversionState::Rejected => 'gray',
                        KonzertmeisterEventConversionState::Converted => 'success',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->preload()
                    ->multiple()
                    ->options(self::getTypeFilterOptions()),
                Tables\Filters\SelectFilter::make('conversion_state')
                    ->label('Status')
                    ->preload()
                    ->multiple()
                    ->options(self::getConversionStateFilterOptions()),
            ])
            ->actions([
                Tables\Actions\Action::make('convert')
                    ->label('Konvertieren')
                    ->hidden(fn (KonzertmeisterEvent $record) => $record->conversion_state != KonzertmeisterEventConversionState::Open)
                    ->form([
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
                                    'md' => 2,])
                                    ->schema([
                                        TextInput::make('prefilled-location')
                                            ->placeholder('n/a')
                                            ->disabled(),
                                    ]),
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
                                        ->label('Postleitzahl (PLZ)')
                                        ->minValue(10000)
                                        ->maxValue(99999)
                                        ->required()
                                        ->numeric(),
                                    TextInput::make('venue_name')
                                        ->required()
                                        ->label('Ort'),
                                ]),
                            ]),
                    ])
                    ->fillForm(fn(KonzertmeisterEvent $record) => [
                        'event_description' => $record->summary,
                        'prefilled-location' => $record->location,
                    ])
                    ->action(self::getConvertTableRowAction()),
            ])
            ->deferFilters()
            ->bulkActions([
                Tables\Actions\BulkAction::make('reject')
                    ->label('Ablehnen')
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->action(self::getRejectBulkAction()),
            ])
            ->checkIfRecordIsSelectableUsing(fn (KonzertmeisterEvent $record): bool => $record->conversion_state == KonzertmeisterEventConversionState::Open)
            ->defaultSort('dtstart');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKonzertmeisterEvents::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            KonzertmeisterEventOverview::class,
            KonzertmeisterEventTypeDistribution::class,
            KonzertmeisterEventConversionStateDistribution::class,
        ];
    }

    private static function getTypeFilterOptions(): Closure
    {
        return function (): array {
            $keys = array_map(fn ($case) => $case->value, KonzertmeisterEventType::cases());
            $values = array_map(fn ($case) => $case->name, KonzertmeisterEventType::cases());

            return array_combine($keys, $values);
        };
    }

    private static function getConversionStateFilterOptions(): Closure
    {
        return function (): array {
            $keys = array_map(fn ($case) => $case->value, KonzertmeisterEventConversionState::cases());
            $values = array_map(fn ($case) => $case->name, KonzertmeisterEventConversionState::cases());

            return array_combine($keys, $values);
        };
    }

    public static function getRejectBulkAction(): Closure
    {
        return function (Collection $collection) {
            $collection->each(function (KonzertmeisterEvent $record) {
                if ($record->conversion_state == KonzertmeisterEventConversionState::Open) {
                    $record->state()->reject();
                }
            });
        };
    }

    public static function getConvertTableRowAction(): Closure
    {
        return function (array $data, KonzertmeisterEvent $record) {
            // Start database transaction
            DB::beginTransaction();

            // search for venue, create if not exist
            $venue = Venue::createOrFirst([
                'plz' => $data['venue_plz'],
                'name' => $data['venue_name'],
            ]);

            // create concert record
            Concert::create([
                'date' => $record->dtstart,
                'start_time' => $record->dtstart,
                'end_time' => $record->dtend,
                'band_id' => $record->band_id,
                'konzertmeister_event_id' => $record->id,
                'event_description' => $data['event_description'],
                'venue_plz' => $venue->plz,
                'venue_description' => $data['venue_description'],
                'venue_street' => $data['venue_street'],
                'venue_street_number' => $data['venue_street_number'],
            ]);

            // Update record conversion status
            $record->state()->convert();

            // commit database changes
            DB::commit();

            // Send notification about status of transaction
            Notification::make()
                ->title('Konvertierung erfolgreich')
                ->success()
                ->send();
        };
    }
}
