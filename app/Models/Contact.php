<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'phone',
        'source',
        'subscribed',
        'opted_in',
        'subject',
        'message',
        'is_read',
        'replied_at',
    ];

    protected function casts(): array
    {
        return [
            'subscribed' => 'boolean',
            'opted_in' => 'boolean',
            'is_read' => 'boolean',
            'replied_at' => 'datetime',
        ];
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ContactReply::class);
    }

    public function scopeSubscribed($query)
    {
        return $query->where('subscribed', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    public function markAsReplied(): void
    {
        $this->update([
            'is_read' => true,
            'replied_at' => now(),
        ]);
    }

    public function getHasQuotationAttribute(): bool
    {
        return $this->replies()->whereNotNull('quotation_path')->exists();
    }
}
