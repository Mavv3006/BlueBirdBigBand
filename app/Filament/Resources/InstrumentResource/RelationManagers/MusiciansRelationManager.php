<?php

namespace App\Filament\Resources\InstrumentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MusiciansRelationManager extends RelationManager
{
    protected static string $relationship = 'musicians';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('firstname')
                    ->required()
                    ->string()
                    ->autofocus(),
                Forms\Components\TextInput::make('lastname')
                    ->required()
                    ->string(),
                Forms\Components\Select::make('instrument_id')
                    ->relationship('instrument', 'name')
                    ->preload()
                    ->required()
                    ->searchable(),
                Forms\Components\Checkbox::make('isActive')
                    ->label('Aktiv?')
                    ->inline(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric(),
                Tables\Columns\TextColumn::make('firstname')
                    ->label('Vorname'),
                Tables\Columns\TextColumn::make('lastname')
                    ->label('Nachname'),
                Tables\Columns\CheckboxColumn::make('isActive')
                    ->label('Aktiv?')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('isActive')
                    ->query(fn (Builder $query): Builder => $query->where('isActive', '=', true))
                    ->label('Musiker aktiv?')
                    ->indicator('Aktive Musiker'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
