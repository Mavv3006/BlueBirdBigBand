<?php

namespace App\Filament\Resources\KonzertmeisterEventResource\Pages;

use App\Enums\BandName;
use App\Filament\Resources\KonzertmeisterEventResource;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventConversionStateDistribution;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventOverview;
use App\Filament\Resources\KonzertmeisterEventResource\Widgets\KonzertmeisterEventTypeDistribution;
use App\Models\Band;
use App\Services\KonzertmeisterIntegration\KonzertmeisterIntegrationService;
use Artisan;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\App;
use InvalidArgumentException;

class ListKonzertmeisterEvents extends ListRecords
{
    protected static string $resource = KonzertmeisterEventResource::class;

    protected function getHeaderWidgets(): array
    {
        return [KonzertmeisterEventOverview::class];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pull')
                ->label('Neue Konzertmeister Events holen')
                ->form([
                    Select::make('band_name')
                        ->label('Band')
                        ->required()
                        ->preload()
                        ->selectablePlaceholder(false)
                        ->helperText('Für welche Band sollen die nächsten Events geholt werden?')
                        ->native(false)
                        ->options(Band::query()
                            ->whereIn('name', array_map(fn ($bandName) => $bandName->value, BandName::cases()))
                            ->pluck('name', 'id')),
                ])
                ->requiresConfirmation()
                ->modalDescription('Hole die neuesten Events aus Konzertmeister. Bist du sicher, dass du das tun möchtest?')
                ->action(function (array $data) {
                    try {
                        KonzertmeisterIntegrationService::pullNewData(Band::find($data['band_name']));
                    } catch (InvalidArgumentException $e) {
                        report($e);
                        Notification::make()
                            ->title('Konzertmeister Integration')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            Action::make('seed')
                ->label('Run Seeder')
                ->action(function () {
                    Artisan::call('db:seed', ['--class' => 'KonzertmeisterEventSeeder']);
                })
                ->hidden(App::isProduction()),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            KonzertmeisterEventTypeDistribution::class,
            KonzertmeisterEventConversionStateDistribution::class,
        ];
    }
}
