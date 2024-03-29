<?php

namespace App\Filament\Resources;

use App\Enums\StateMachines\UserStates;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'User';

    protected static ?string $pluralModelLabel = 'User';

    protected static ?string $modelLabel = 'User';

    public static function getNavigationGroup(): ?string
    {
        return __(config('filament-spatie-roles-permissions.navigation_section_group', 'filament-spatie-roles-permissions::filament-spatie.section.roles_and_permissions'));
    }

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
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Username')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(fn (UserStates $state): string => match ($state) {
                        UserStates::Registered => 'warning',
                        UserStates::Activated => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('status')
                    ->query(fn (Builder $query): Builder => $query->where('status', UserStates::Activated))
                    ->label('Aktivierte User')
                    ->indicator('Aktivierte User')
                    ->default(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('Aktivieren')
                        ->requiresConfirmation()
                        ->action(fn (Collection $collection) => $collection->each(function ($item) {
                            if ($item->status == UserStates::Activated) {
                                return;
                            }
                            $item->state()->activate();
                        })),
                ])->label('Status ändern'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
