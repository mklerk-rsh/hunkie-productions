<?php

namespace App\Filament\Resources\VisitorSessionResource\Pages;

use App\Filament\Resources\VisitorSessionResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListVisitorSessions extends ListRecords
{
    protected static string $resource = VisitorSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
