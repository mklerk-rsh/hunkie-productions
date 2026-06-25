<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialGalleryPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'caption',
        'client_name',
        'event_type',
        'posted_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'posted_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function likes(): HasMany
    {
        return $this->hasMany(SocialGalleryLike::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(SocialGalleryDownload::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('posted_at', 'desc');
    }
}
