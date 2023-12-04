<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConcertResource\Pages;
use App\Models\Concert;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConcertResource extends Resource
{
    protected static ?string $model = Concert::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    protected static ?string $navigationLabel = 'Auftritte';

    protected static ?string $navigationGroup = 'Auftritte';

    protected static ?string $pluralModelLabel = 'Auftritte';

    protected static ?string $modelLabel = 'Auftritt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListConcerts::route('/'),
            'create' => Pages\CreateConcert::route('/create'),
            'edit' => Pages\EditConcert::route('/{record}/edit'),
        ];
    }
}
