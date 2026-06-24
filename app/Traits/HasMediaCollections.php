<?php

namespace App\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;

trait HasMediaCollections
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile()
            ->useDisk('public');

        $this->addMediaCollection('gallery')
            ->useDisk('public');
    }
}
