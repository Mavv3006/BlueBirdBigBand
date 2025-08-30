<?php

namespace App\Filament\Resources\Songs;

use App\Filament\Resources\Songs\Pages\CreateSong;
use App\Filament\Resources\Songs\Pages\EditSong;
use App\Filament\Resources\Songs\Pages\ListSongs;
use App\Models\Song;
use App\Rules\StartsWithUppercaseLetterRule;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SongResource extends Resource
{
    protected static ?string $model = Song::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-musical-note';

    protected static string|UnitEnum|null $navigationGroup = 'Auftritte';

    protected static ?string $pluralModelLabel = 'Songs';

    protected static ?string $modelLabel = 'Song';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->label('Titel')
                    ->rule(new StartsWithUppercaseLetterRule),
                TextInput::make('author')
                    ->label('Komponist'),
                TextInput::make('arranger')
                    ->label('Arrangeur'),
                TextInput::make('genre')
                    ->label('Genre'),
                FileUpload::make('file_path')
                    ->label('Audio Datei')
                    ->downloadable()
                    ->moveFiles()
                    ->directory('songs')
                    ->acceptedFileTypes(['audio/mpeg']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titel')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('arranger')
                    ->label('Arrangeur')
                    ->sortable(),
                TextColumn::make('author')
                    ->label('Komponist')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('genre')
                    ->label('Genre')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            ->defaultSort('title');
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
            'index' => ListSongs::route('/'),
            'create' => CreateSong::route('/create'),
            'edit' => EditSong::route('/{record}/edit'),
        ];
    }
}
