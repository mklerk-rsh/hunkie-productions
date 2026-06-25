<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'visitor_session_id',
    ];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }

    public function visitorSession(): BelongsTo
    {
        return $this->belongsTo(VisitorSession::class);
    }
}
