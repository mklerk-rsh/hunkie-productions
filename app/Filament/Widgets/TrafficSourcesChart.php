<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TrafficSourcesChart extends ChartWidget
{
    protected ?string $heading = 'Traffic Sources';

    protected int | string | array $columnSpan = 'half';

    protected function getData(): array
    {
        $data = Lead::select('source', DB::raw('count(*) as total'))
            ->groupBy('source')
            ->pluck('total', 'source')
            ->toArray();

        $labels = array_map(fn ($s) => \App\Enums\LeadSource::tryFrom($s)?->label() ?? ucfirst($s), array_keys($data));

        return [
            'datasets' => [
                [
                    'label' => 'Visitors',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#6366f1', '#22c55e', '#eab308', '#ef4444', '#ec4899',
                        '#14b8a6', '#f97316', '#8b5cf6', '#06b6d4', '#84cc16',
                        '#a855f7', '#d946ef', '#64748b',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
