<?php

namespace App\Filament\Resources\PortfolioMediaResource\Pages;

use App\Filament\Resources\PortfolioMediaResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListPortfolioMedia extends ListRecords
{
    protected static string $resource = PortfolioMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
