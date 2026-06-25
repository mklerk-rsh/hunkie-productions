<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProjectsChart extends ChartWidget
{
    protected ?string $heading = 'Projects by Status';

    protected function getData(): array
    {
        $data = Project::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Projects',
                    'data' => array_values($data),
                    'backgroundColor' => ['#6366f1', '#22c55e', '#eab308', '#ef4444'],
                ],
            ],
            'labels' => array_map(fn ($s) => ucfirst($s), array_keys($data)),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
