<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected function casts(): array
    {
        return [
            'subscribed' => 'boolean',
            'opted_in' => 'boolean',
        ];
    }

    public function scopeSubscribed($query)
    {
        return $query->where('subscribed', true);
    }
}
