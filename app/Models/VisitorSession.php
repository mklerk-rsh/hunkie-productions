<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitorSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'page_views_count',
        'time_spent_seconds',
        'referrer_url',
        'landing_page',
        'device_type',
        'browser',
        'os',
        'country',
        'city',
        'latitude',
        'longitude',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'first_visited_at',
        'last_visited_at',
    ];

    protected function casts(): array
    {
        return [
            'page_views_count' => 'integer',
            'time_spent_seconds' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
            'first_visited_at' => 'datetime',
            'last_visited_at' => 'datetime',
        ];
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }
}
