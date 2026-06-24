<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Lead;
use App\Models\Project;
use App\Models\BlogPost;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', Project::count())
                ->description('Published: ' . Project::where('status', \App\Enums\ProjectStatus::Completed)->count())
                ->descriptionIcon('heroicon-o-briefcase')
                ->chart([7, 3, 10, 5, 15, 8, 12])
                ->color('success'),
            Stat::make('New Leads', Lead::where('status', \App\Enums\LeadStatus::New)->count())
                ->description('Total: ' . Lead::count() . ' leads')
                ->descriptionIcon('heroicon-o-inbox-arrow-down')
                ->chart([4, 7, 3, 8, 5, 10, 6])
                ->color('warning'),
            Stat::make('Unread Messages', Contact::where('is_read', false)->count())
                ->description('Total: ' . Contact::count() . ' messages')
                ->descriptionIcon('heroicon-o-envelope')
                ->chart([2, 5, 3, 7, 4, 6, 8])
                ->color('danger'),
            Stat::make('Blog Posts', BlogPost::count())
                ->description('Published: ' . BlogPost::where('is_published', true)->count())
                ->descriptionIcon('heroicon-o-document-text')
                ->chart([10, 15, 8, 12, 20, 14, 18])
                ->color('info'),
        ];
    }
}
