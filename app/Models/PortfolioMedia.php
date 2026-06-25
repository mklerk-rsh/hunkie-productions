<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'portfolio_category_id',
        'title',
        'description',
        'media_type',
        'file_path',
        'is_featured',
        'download_count',
        'like_count',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'download_count' => 'integer',
            'like_count' => 'integer',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function portfolioCategory(): BelongsTo
    {
        return $this->belongsTo(PortfolioCategory::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeImages($query)
    {
        return $query->where('media_type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('media_type', 'video');
    }
}
