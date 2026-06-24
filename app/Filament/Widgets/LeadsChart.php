<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class LeadsChart extends ChartWidget
{
    protected ?string $heading = 'Leads by Status';

    protected function getData(): array
    {
        $data = Lead::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $labels = array_map(fn ($s) => \App\Enums\LeadStatus::tryFrom($s)?->label() ?? ucfirst($s), array_keys($data));

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => array_values($data),
                    'backgroundColor' => ['#6366f1', '#22c55e', '#eab308', '#ef4444', '#ec4899'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
