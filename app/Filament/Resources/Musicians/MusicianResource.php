<?php

namespace App\Filament\Resources\Musicians;

use App\Filament\Resources\Musicians\Pages\CreateMusician;
use App\Filament\Resources\Musicians\Pages\EditMusician;
use App\Filament\Resources\Musicians\Pages\ListMusicians;
use App\Models\Musician;
use BackedEnum;
use Exception;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class MusicianResource extends Resource
{
    protected static ?string $model = Musician::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Musiker';

    protected static string | UnitEnum | null $navigationGroup = 'Band';

    protected static ?string $pluralModelLabel = 'Musiker';

    protected static ?string $modelLabel = 'Musiker';

    public static function form(Schema $schema): Schema
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
                    ->inline(false)
                    ->default(true),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('firstname')
                    ->label('Vorname')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('lastname')
                    ->label('Nachname')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('instrument.name')
                    ->sortable()
                    ->searchable(),
                CheckboxColumn::make('isActive')
                    ->label('Aktiv?')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('isActive')
                    ->query(fn (Builder $query): Builder => $query->where('isActive', '=', true))
                    ->label('Musiker aktiv?')
                    ->indicator('Aktive Musiker')
                    ->default(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMusicians::route('/'),
            'create' => CreateMusician::route('/create'),
            'edit' => EditMusician::route('/{record}/edit'),
        ];
    }
}
