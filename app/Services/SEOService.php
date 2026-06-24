<?php

namespace App\Services;

use App\Models\SEOMetadata;
use Illuminate\Database\Eloquent\Model;

class SEOService
{
    public function updateMetadata(Model $model, array $data): SEOMetadata
    {
        $seo = $model->seoMetadata()->firstOrNew([]);
        $seo->fill($data);
        $seo->seoable()->associate($model);
        $seo->save();

        return $seo;
    }

    public function getMetadata(Model $model): ?SEOMetadata
    {
        return $model->seoMetadata;
    }

    public function generateMetaTitle(?string $title, string $fallback, string $suffix = ' | Hunkie Productions'): string
    {
        return $title ? $title . $suffix : $fallback . $suffix;
    }

    public function generateMetaDescription(?string $description, string $fallback): string
    {
        return $description ?? $fallback;
    }

    public function buildStructuredData(string $type, array $data): array
    {
        $base = [
            '@context' => 'https://schema.org',
            '@type' => $type,
        ];

        return array_merge($base, $data);
    }
}
