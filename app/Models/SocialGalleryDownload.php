<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialGalleryDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_gallery_post_id',
        'session_id',
        'ip_address',
        'downloaded_at',
    ];

    protected function casts(): array
    {
        return [
            'downloaded_at' => 'datetime',
        ];
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(SocialGalleryPost::class, 'social_gallery_post_id');
    }
}
