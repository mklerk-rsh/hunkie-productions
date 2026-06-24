<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use App\Filament\Widgets\DeviceBreakdownChart;
use App\Filament\Widgets\LeadStatsOverview;
use App\Filament\Widgets\TrafficSourcesChart;
use App\Filament\Widgets\VisitorsOverTimeChart;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            LeadStatsOverview::class,
            VisitorsOverTimeChart::class,
            TrafficSourcesChart::class,
            DeviceBreakdownChart::class,
        ];
    }

    public function getDefaultHeaderWidgetsColumns(): int | array
    {
        return 2;
    }
}
