<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Lead extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'message',
        'service_interest',
        'source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'status',
        'lead_score',
        'assigned_to',
        'notes',
        'ip_address',
        'latitude',
        'longitude',
        'user_agent',
        'referrer_url',
        'landing_page',
        'time_spent_seconds',
        'page_views_count',
        'device_type',
        'browser',
        'os',
        'session_id',
    ];

    protected function casts(): array
    {
        return [
            'lead_score' => 'integer',
            'time_spent_seconds' => 'integer',
            'page_views_count' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function pageActivities(): HasMany
    {
        return $this->hasMany(PageActivity::class);
    }

    public function isAnonymous(): bool
    {
        return is_null($this->email);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    public function scopeAnonymous($query)
    {
        return $query->whereNull('email');
    }

    public function scopeWithEmail($query)
    {
        return $query->whereNotNull('email');
    }

    public function scopeFromSource($query, string $source)
    {
        return $query->where('source', $source);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
