<?php

namespace App\Models;

use App\Traits\HasMediaCollections;
use App\Traits\HasSEO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Project extends Model
{
    use HasFactory, HasMediaCollections, HasSEO, LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'client_name',
        'project_date',
        'completion_year',
        'url',
        'is_featured',
        'status',
        'published_at',
        'service_category_id',
    ];

    protected function casts(): array
    {
        return [
            'project_date' => 'date',
            'completion_year' => 'integer',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'project_categories')
            ->withTimestamps();
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function portfolioMedia(): HasMany
    {
        return $this->hasMany(PortfolioMedia::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
