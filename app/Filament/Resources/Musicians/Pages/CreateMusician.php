<?php

namespace App\Filament\Resources\Musicians\Pages;

use App\Filament\Resources\Musicians\MusicianResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMusician extends CreateRecord
{
    protected static string $resource = MusicianResource::class;
}
