<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        return [
            Stat::make('Total Visitors', Lead::count())
                ->description('Anonymous: ' . Lead::anonymous()->count())
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Today', Lead::whereDate('created_at', today())->count())
                ->description('Past 7 days: ' . Lead::where('created_at', '>=', now()->subDays(7))->count())
                ->descriptionIcon('heroicon-o-calendar')
                ->color('success'),
            Stat::make('Avg. Time Spent', function () {
                $avg = Lead::whereNotNull('time_spent_seconds')
                    ->where('time_spent_seconds', '>', 0)
                    ->avg('time_spent_seconds');

                return $avg ? gmdate('i:s', (int) $avg) . ' min' : '—';
            })
                ->description('Across all visitors')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
            Stat::make('Avg. Page Views', function () {
                return number_format(Lead::avg('page_views_count') ?? 0, 1);
            })
                ->description('Per visitor')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('info'),
        ];
    }
}
