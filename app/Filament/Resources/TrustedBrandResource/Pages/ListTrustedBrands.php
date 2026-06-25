<?php

namespace App\Filament\Resources\TrustedBrandResource\Pages;

use App\Filament\Resources\TrustedBrandResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListTrustedBrands extends ListRecords
{
    protected static string $resource = TrustedBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
