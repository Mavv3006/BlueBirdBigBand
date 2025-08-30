<?php

namespace App\Filament\Resources\NewsletterRequests\Pages;

use App\Filament\Resources\NewsletterRequests\NewsletterRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterRequests extends ListRecords
{
    protected static string $resource = NewsletterRequestResource::class;
}
