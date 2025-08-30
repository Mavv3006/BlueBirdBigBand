<?php

namespace App\Filament\Resources\KonzertmeisterEvents;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Filament\Resources\KonzertmeisterEvents\Pages\ListKonzertmeisterEvents;
use App\Filament\Resources\KonzertmeisterEvents\Widgets\KonzertmeisterEventConversionStateDistribution;
use App\Filament\Resources\KonzertmeisterEvents\Widgets\KonzertmeisterEventOverview;
use App\Filament\Resources\KonzertmeisterEvents\Widgets\KonzertmeisterEventTypeDistribution;
use App\Models\Concert;
use App\Models\KonzertmeisterEvent;
use App\Models\Venue;
use BackedEnum;
use Closure;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class KonzertmeisterEventResource extends Resource
{
    protected static ?string $model = KonzertmeisterEvent::class;

    protected static string | BackedEnum | null $navigationIcon = 'icon-event-o';

    protected static string | UnitEnum | null $navigationGroup = 'Auftritte';

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
                SelectFilter::make('type')
                    ->label('Type')
                    ->preload()
                    ->multiple()
                    ->options(self::getTypeFilterOptions()),
                SelectFilter::make('conversion_state')
                    ->label('Status')
                    ->preload()
                    ->multiple()
                    ->options(self::getConversionStateFilterOptions()),
            ])
            ->recordActions([
                Action::make('convert')
                    ->label('Konvertieren')
                    ->hidden(function (KonzertmeisterEvent $record): bool {
                        $isNotOpen = $record->conversion_state != KonzertmeisterEventConversionState::Open;
                        $concertExists = self::checkIfConcertForDateExists($record);

                        return $isNotOpen || $concertExists;
                    })
                    ->schema([
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
                                    'md' => 2, ])
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
                    ->fillForm(fn (KonzertmeisterEvent $record) => [
                        'event_description' => $record->summary,
                        'prefilled-location' => $record->location,
                    ])
                    ->action(self::getConvertTableRowAction()),
            ])
            ->toolbarActions([
                BulkAction::make('reject')
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
            'index' => ListKonzertmeisterEvents::route('/'),
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

    public static function checkIfConcertForDateExists(KonzertmeisterEvent $record): bool
    {
        return Concert::where('date', $record->dtstart->format('Y-m-d'))->exists();
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
            $concert = Concert::create([
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
                ->actions([
                    Action::make('open concert')
                        ->label('öffne Auftritt')
                        ->url(route('filament.admin.resources.concerts.view', $concert), shouldOpenInNewTab: true)
                        ->button()
                        ->close(),
                ])
                ->send();
        };
    }
}
