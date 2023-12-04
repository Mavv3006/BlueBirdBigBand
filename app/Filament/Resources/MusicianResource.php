<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusicianResource\Pages;
use App\Models\Musician;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MusicianResource extends Resource
{
    protected static ?string $model = Musician::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Musiker';

    protected static ?string $navigationGroup = 'Band';

    protected static ?string $pluralModelLabel = 'Musiker';

    protected static ?string $modelLabel = 'Musiker';

    public static function form(Form $form): Form
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

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('firstname')
                    ->label('Vorname'),
                Tables\Columns\TextColumn::make('lastname')
                    ->label('Nachname'),
                Tables\Columns\TextColumn::make('instrument.name')
                    ->searchable(),
                Tables\Columns\CheckboxColumn::make('isActive')
                    ->label('Aktiv?')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->indicator('Aktive Musiker')
                    ->default(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMusicians::route('/'),
            'create' => Pages\CreateMusician::route('/create'),
            'edit' => Pages\EditMusician::route('/{record}/edit'),
        ];
    }
}
