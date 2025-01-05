<?php

namespace App\Filament\Resources;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Filament\Resources\KonzertmeisterEventResource\Pages;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventConversionStateDistribution;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventOverview;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventTypeDistribution;
use App\Models\KonzertmeisterEvent;
use Closure;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

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
                //                    ->default([KonzertmeisterEventType::Sonstiges->value])
                Tables\Filters\SelectFilter::make('conversion_state')
                    ->label('Status')
                    ->preload()
                    ->multiple()
                    ->options(self::getConversionStateFilterOptions()),
                //                    ->default([KonzertmeisterEventConversionState::Open->value]),
            ])
            ->actions([
                Tables\Actions\Action::make('convert')
                    // TODO: konvertieren ermöglichen -> https://bluebirdbigband.youtrack.cloud/issue/BBBB-26/Konzertmeister-Events-in-Auftritte-konvertieren
                    ->label('Konvertieren')
                    ->hidden(fn (KonzertmeisterEvent $record) => $record->conversion_state != KonzertmeisterEventConversionState::Open)
                    ->disabled(),
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
}
