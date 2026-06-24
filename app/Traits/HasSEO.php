<?php

namespace App\Traits;

use App\Models\SEOMetadata;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSEO
{
    public static function bootHasSEO(): void
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }
            $model->seoMetadata?->delete();
        });
    }

    public function seoMetadata(): MorphOne
    {
        return $this->morphOne(SEOMetadata::class, 'seoable');
    }

    public function getSEOMetadata(): ?SEOMetadata
    {
        return $this->seoMetadata()->first() ?? new SEOMetadata();
    }
}
