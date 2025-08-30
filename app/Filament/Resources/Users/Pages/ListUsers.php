<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Mail\TestMail;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Mail;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('email')
                ->label('E-Mail')
                ->schema([
                    TextInput::make('email')
                        ->label('E-Mail Adresse')
                        ->email()
                        ->required(),
                ])
                ->action(
                    fn (array $data) => Mail::to($data['email'])->send(new TestMail)
                ),
        ];
    }
}
