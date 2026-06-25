<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialGalleryLike extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'social_gallery_post_id',
        'session_id',
        'ip_address',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(SocialGalleryPost::class, 'social_gallery_post_id');
    }
}
