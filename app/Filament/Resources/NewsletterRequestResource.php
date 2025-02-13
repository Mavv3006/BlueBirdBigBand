<?php

namespace App\Filament\Resources;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Filament\Resources\NewsletterRequestResource\Pages;
use App\Models\NewsletterRequest;
use Exception;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterRequestResource extends Resource
{
    protected static ?string $model = NewsletterRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('E-Mail')
                    ->icon('heroicon-m-envelope')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->color(fn (NewsletterType $state): string => match ($state) {
                        NewsletterType::Adding => 'success',
                        NewsletterType::Removing => 'warning',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (NewsletterState $state): string => match ($state) {
                        NewsletterState::Requested => 'gray',
                        NewsletterState::Completed => 'success',
                        NewsletterState::Confirmed => 'warning',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y h:i')
                    ->label('Angelegt')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('confirmed_at')
                    ->dateTime('d M Y h:i')
                    ->placeholder('null')
                    ->label('Bestätigt')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime('d M Y h:i')
                    ->label('Abgeschlossen')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('null'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        NewsletterType::Removing->value => NewsletterType::Removing->name,
                        NewsletterType::Adding->value => NewsletterType::Adding->name,
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->default(NewsletterState::Confirmed->value)
                    ->options([
                        NewsletterState::Requested->value => NewsletterState::Requested->name,
                        NewsletterState::Confirmed->value => NewsletterState::Confirmed->name,
                        NewsletterState::Completed->value => NewsletterState::Completed->name,
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('complete')
                    ->label('Abschließen')
                    ->requiresConfirmation()
                    ->action(fn (NewsletterRequest $request) => $request->state()->complete())
                    ->visible(fn (NewsletterRequest $request) => $request->status == NewsletterState::Confirmed),
            ])
            ->deferFilters()
            ->defaultSort('confirmed_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterRequests::route('/'),
        ];
    }
}
