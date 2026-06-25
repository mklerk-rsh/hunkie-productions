<?php

namespace App\Filament\Resources\SocialGalleryDownloadResource\Pages;

use App\Filament\Resources\SocialGalleryDownloadResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListSocialGalleryDownloads extends ListRecords
{
    protected static string $resource = SocialGalleryDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
