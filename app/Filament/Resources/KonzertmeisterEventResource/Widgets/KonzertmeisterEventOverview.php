<?php

namespace App\Filament\Resources\KonzertmeisterEventResource\Widgets;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\KonzertmeisterEvent;
use App\Services\KonzertmeisterIntegration\KonzertmeisterEventsCountSingleton;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KonzertmeisterEventOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getHeading(): ?string
    {
        return 'Übersicht über alle offene KonzertmeisterEvents';
    }

    protected function getStats(): array
    {
        $totalCount = KonzertmeisterEventsCountSingleton::getInstance()->getCount();
        $openConcertsCount = KonzertmeisterEvent::query()
            ->where('type', KonzertmeisterEventType::Auftritt)
            ->where('conversion_state', KonzertmeisterEventConversionState::Open)
            ->count();

        return [
            Stat::make('Gesamtanzahl', $totalCount)
                ->description('Gesamtanzahl aller KonzertmeisterEvents in der Datenbank'),
            Stat::make('# offener Auftritte', $openConcertsCount)
                ->description('Wie viele Auftritte sind noch offen?'),
        ];
    }
}
