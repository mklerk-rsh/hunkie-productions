<?php

namespace App\Filament\Resources\SocialGalleryPostResource\Pages;

use App\Filament\Resources\SocialGalleryPostResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListSocialGalleryPosts extends ListRecords
{
    protected static string $resource = SocialGalleryPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
