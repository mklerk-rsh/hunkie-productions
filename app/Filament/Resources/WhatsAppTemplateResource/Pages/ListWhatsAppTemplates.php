<?php

namespace App\Filament\Resources\WhatsAppTemplateResource\Pages;

use App\Filament\Resources\WhatsAppTemplateResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListWhatsAppTemplates extends ListRecords
{
    protected static string $resource = WhatsAppTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
