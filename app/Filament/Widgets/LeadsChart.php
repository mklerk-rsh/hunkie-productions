<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class LeadsChart extends ChartWidget
{
    protected ?string $heading = 'Leads by Source';

    protected function getData(): array
    {
        $data = Lead::select('source', DB::raw('count(*) as total'))
            ->groupBy('source')
            ->pluck('total', 'source')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => array_values($data),
                    'backgroundColor' => ['#6366f1', '#22c55e', '#eab308', '#ef4444', '#ec4899'],
                ],
            ],
            'labels' => array_map(fn ($s) => ucfirst($s), array_keys($data)),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
