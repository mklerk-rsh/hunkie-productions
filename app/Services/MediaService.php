<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaService
{
    public function upload(Model $model, $file, string $collection = 'default', array $customProperties = []): Media
    {
        return $model->addMedia($file)
            ->withCustomProperties($customProperties)
            ->toMediaCollection($collection);
    }

    public function uploadMultiple(Model $model, array $files, string $collection = 'gallery'): void
    {
        foreach ($files as $file) {
            $model->addMedia($file)->toMediaCollection($collection);
        }
    }

    public function getMedia(Model $model, string $collection = 'default')
    {
        return $model->getMedia($collection);
    }

    public function getFirstMediaUrl(Model $model, string $collection = 'default', string $conversion = ''): string
    {
        return $model->getFirstMediaUrl($collection, $conversion);
    }

    public function deleteMedia(Model $model, int $mediaId): void
    {
        $model->media()->where('id', $mediaId)->first()?->delete();
    }

    public function clearCollection(Model $model, string $collection = 'default'): void
    {
        $model->clearMediaCollection($collection);
    }
}
