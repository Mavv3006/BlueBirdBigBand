<?php

namespace App\Filament\Resources\ConcertResource\RelationManagers;

use App\Models\Concert;
use App\Models\Song;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class SetlistRelationManager extends RelationManager
{
    protected static string $relationship = 'setlist';

    protected static ?string $modelLabel = 'Setlist Eintrag';

    protected static ?string $pluralLabel = 'Setlist Einträge';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('song_id')
                    ->required()
                    ->label('Song - Test')
                    ->getOptionLabelFromRecordUsing(fn (Song $song): string => "$song->title, arr. $song->arranger")
                    ->searchable()
                    ->preload()
                    ->relationship(
                        name: 'song',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn (EloquentBuilder $query) => $query
                            ->select('id', 'title', 'arranger')
                            ->whereNotIn('id', function (QueryBuilder $query) {
                                /** @var Concert $entry */
                                $entry = $this->ownerRecord;
                                $query->select('song_id')
                                    ->from('setlist_entries')
                                    ->where('concert_id', $entry->id);
                            })
                            ->orderBy('title'))
                    ->native(false),
                TextInput::make('sequence_number')
                    ->label('Reihenfolgen-Nummer')
                    ->required()
                    ->integer()
                    ->minValue(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('sequence_number')
                    ->label('Reihenfolgen-Nummer')
                    ->sortable(),
                TextColumn::make('song.title')
                    ->label('Titel')
                    ->sortable(),
                TextColumn::make('song.author')
                    ->label('Komponist'),
                TextColumn::make('song.arranger')
                    ->label('Arrangeur'),
                TextColumn::make('song.genre')
                    ->label('Genre'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sequence_number');
    }
}
