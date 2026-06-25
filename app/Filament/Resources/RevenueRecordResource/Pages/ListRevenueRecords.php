<?php

namespace App\Filament\Resources\RevenueRecordResource\Pages;

use App\Filament\Resources\RevenueRecordResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListRevenueRecords extends ListRecords
{
    protected static string $resource = RevenueRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
