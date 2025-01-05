<?php

namespace App\Filament\Resources\KonzertmeisterEventResource\Widgets;

use App\Enums\KonzertmeisterEventType;
use App\Models\KonzertmeisterEvent;
use App\Services\KonzertmeisterIntegration\KonzertmeisterEventsCountSingleton;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KonzertmeisterEventTypeDistribution extends BaseWidget
{
    protected function getHeading(): ?string
    {
        return 'Verteilung der Event Types';
    }

    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $totalCount = KonzertmeisterEventsCountSingleton::getInstance()->getCount();

        return collect(KonzertmeisterEventType::cases())
            ->map(function ($case) use ($totalCount) {
                $rawValue = KonzertmeisterEvent::query()
                    ->where('type', $case->name)
                    ->count();
                if ($totalCount == 0) {
                    $percentageValue = 0;
                } else {
                    $percentageValue = round($rawValue / $totalCount, 3) * 100;
                }

                return Stat::make($case->name, $percentageValue.' %')
                    ->description($rawValue.' sind vom Typ '.$case->name.'.');
            })->toArray();
    }
}
