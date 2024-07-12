<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\TestMail;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Mail;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // used for testing sending emails on the server.
            Actions\Action::make('email')
                ->label('Sende Test-E-Mail')
                ->form([
                    TextInput::make('email')
                        ->label('E-Mail Adresse')
                        ->helperText('Hiermit kann eine Test-E-Mail an die angegebene E-Mail-Adresse geschickt werden.')
                        ->autofocus()
                        ->email()
                        ->required(),
                ])
                ->action(
                    fn (array $data) => Mail::to($data['email'])->send(new TestMail())
                )
                ->requiresConfirmation(),
        ];
    }
}
