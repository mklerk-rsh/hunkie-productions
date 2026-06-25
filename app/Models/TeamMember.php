<?php

namespace App\Models;

use App\Traits\HasMediaCollections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class TeamMember extends Model
{
    use HasFactory, HasMediaCollections, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'position',
        'bio',
        'email',
        'phone',
        'social_links',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
