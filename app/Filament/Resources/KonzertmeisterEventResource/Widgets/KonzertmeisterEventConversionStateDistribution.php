<?php

namespace App\Filament\Resources\KonzertmeisterEventResource\Widgets;

use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\KonzertmeisterEvent;
use App\Services\KonzertmeisterIntegration\KonzertmeisterEventsCountSingleton;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KonzertmeisterEventConversionStateDistribution extends BaseWidget
{
    protected function getHeading(): ?string
    {
        return 'Verteilung der Konversions-Status';
    }

    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $totalCount = KonzertmeisterEventsCountSingleton::getInstance()->getCount();

        return collect(KonzertmeisterEventConversionState::cases())
            ->map(function ($case) use ($totalCount) {
                $rawValue = KonzertmeisterEvent::query()
                    ->where('conversion_state', $case->name)
                    ->count();
                $percentageValue = round($rawValue / $totalCount, 3) * 100;

                return Stat::make($case->name, $percentageValue.' %')
                    ->description($rawValue.' sind im Status '.$case->name.'.');
            })->toArray();
    }
}
