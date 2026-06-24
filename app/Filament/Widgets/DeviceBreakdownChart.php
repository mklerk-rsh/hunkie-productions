<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DeviceBreakdownChart extends ChartWidget
{
    protected ?string $heading = 'Devices';

    protected int | string | array $columnSpan = 'half';

    protected function getData(): array
    {
        $data = Lead::select('device_type', DB::raw('count(*) as total'))
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->pluck('total', 'device_type')
            ->toArray();

        $labels = array_map(fn ($s) => ucfirst($s), array_keys($data));

        return [
            'datasets' => [
                [
                    'label' => 'Devices',
                    'data' => array_values($data),
                    'backgroundColor' => ['#6366f1', '#22c55e', '#eab308'],
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
