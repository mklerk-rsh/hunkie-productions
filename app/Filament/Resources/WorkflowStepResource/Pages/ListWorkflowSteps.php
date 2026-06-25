<?php

namespace App\Filament\Resources\WorkflowStepResource\Pages;

use App\Filament\Resources\WorkflowStepResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListWorkflowSteps extends ListRecords
{
    protected static string $resource = WorkflowStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
