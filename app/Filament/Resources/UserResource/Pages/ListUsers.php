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
            Actions\Action::make('email')
                ->label('E-Mail')
                ->form([
                    TextInput::make('email')
                        ->label('E-Mail Adresse')
                        ->email()
                        ->required(),
                ])
                ->action(
                    fn (array $data) => Mail::to($data['email'])->send(new TestMail())
                ),
        ];
    }
}
