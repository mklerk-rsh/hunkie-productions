<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'page_url',
        'page_title',
        'referer_url',
        'user_agent',
        'ip_address',
        'session_id',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'visited_at',
    ];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }
}
