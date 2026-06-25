<?php

namespace App\Filament\Resources\CalendarAvailabilityResource\Pages;

use App\Filament\Resources\CalendarAvailabilityResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListCalendarAvailabilities extends ListRecords
{
    protected static string $resource = CalendarAvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
