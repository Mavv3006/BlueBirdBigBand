<?php

namespace App\Filament\Resources\ConcertResource\RelationManagers;

use App\Models\Concert;
use App\Models\Song;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class SetlistRelationManager extends RelationManager
{
    protected static string $relationship = 'setlist';

    protected static ?string $modelLabel = 'Setlist Eintrag';

    protected static ?string $pluralLabel = 'Setlist Einträge';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('song_id')
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
                Forms\Components\TextInput::make('sequence_number')
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
                Tables\Columns\TextColumn::make('sequence_number')
                    ->label('Reihenfolgen-Nummer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('song.title')
                    ->label('Titel')
                    ->sortable(),
                Tables\Columns\TextColumn::make('song.author')
                    ->label('Komponist'),
                Tables\Columns\TextColumn::make('song.arranger')
                    ->label('Arrangeur'),
                Tables\Columns\TextColumn::make('song.genre')
                    ->label('Genre'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sequence_number');
    }
}
