<?php

namespace App\Filament\Resources;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Filament\Resources\KonzertmeisterEventResource\Pages;
use App\Models\KonzertmeisterEvent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class KonzertmeisterEventResource extends Resource
{
    protected static ?string $model = KonzertmeisterEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Band'),
                TextColumn::make('type')
                    ->label('Typ')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon(fn (KonzertmeisterEventType $state): string => match ($state) {
                        KonzertmeisterEventType::Probe => 'mdi-movie-open',
                        KonzertmeisterEventType::Auftritt => 'icon-performance',
                        KonzertmeisterEventType::Sonstiges => '',
                    })
                    ->sortable(),
                TextColumn::make('conversion_state')
                    ->sortable()
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(fn (KonzertmeisterEventConversionState $state): string => match ($state) {
                        KonzertmeisterEventConversionState::Open => 'info',
                        KonzertmeisterEventConversionState::Rejected => 'gray',
                        KonzertmeisterEventConversionState::Converted => 'success',
                    })
                    ->label('Status'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options(function (): array {
                        $keys = array_map(fn ($case) => $case->value, KonzertmeisterEventType::cases());
                        $values = array_map(fn ($case) => $case->name, KonzertmeisterEventType::cases());

                        return array_combine($keys, $values);
                    }),
                Tables\Filters\SelectFilter::make('conversion_state')
                    ->label('Status')
                    ->options(function (): array {
                        $keys = array_map(fn ($case) => $case->value, KonzertmeisterEventConversionState::cases());
                        $values = array_map(fn ($case) => $case->name, KonzertmeisterEventConversionState::cases());

                        return array_combine($keys, $values);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('convert')
                    ->label('Konvertieren'),
                // TODO: konvertieren ermöglichen -> https://bluebirdbigband.youtrack.cloud/issue/BBBB-26/Konzertmeister-Events-in-Auftritte-konvertieren
            ])
            ->deferFilters()
            ->bulkActions([
                Tables\Actions\BulkAction::make('reject')
                    ->label('Ablehnen')
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $collection) {
                        /** @var KonzertmeisterEvent $event */
                        foreach ($collection as $event) {
                            if ($event->conversion_state == KonzertmeisterEventConversionState::Open) {
                                $event->state()->reject();
                            }
                        }
                    }),
            ])
            ->defaultSort('dtstart');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKonzertmeisterEvents::route('/'),
        ];
    }
}
