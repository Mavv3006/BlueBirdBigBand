<?php

namespace App\Filament\Resources\InstrumentResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MusiciansRelationManager extends RelationManager
{
    protected static string $relationship = 'musicians';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('firstname')
                    ->required()
                    ->string()
                    ->autofocus(),
                TextInput::make('lastname')
                    ->required()
                    ->string(),
                Select::make('instrument_id')
                    ->relationship('instrument', 'name')
                    ->preload()
                    ->required()
                    ->searchable(),
                Checkbox::make('isActive')
                    ->label('Aktiv?')
                    ->inline(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->numeric(),
                TextColumn::make('firstname')
                    ->label('Vorname'),
                TextColumn::make('lastname')
                    ->label('Nachname'),
                CheckboxColumn::make('isActive')
                    ->label('Aktiv?')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('isActive')
                    ->query(fn (Builder $query): Builder => $query->where('isActive', '=', true))
                    ->label('Musiker aktiv?')
                    ->indicator('Aktive Musiker'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }
}
