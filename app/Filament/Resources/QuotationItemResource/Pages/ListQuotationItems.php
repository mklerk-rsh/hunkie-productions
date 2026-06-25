<?php

namespace App\Filament\Resources\QuotationItemResource\Pages;

use App\Filament\Resources\QuotationItemResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListQuotationItems extends ListRecords
{
    protected static string $resource = QuotationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
