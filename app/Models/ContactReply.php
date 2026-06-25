<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContactReply extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'contact_id',
        'admin_id',
        'message',
        'quotation_path',
        'quotation_filename',
    ];

    protected $touches = ['contact'];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('quotations')
            ->singleFile();

        $this->addMediaCollection('attachments');
    }

    public function hasQuotation(): bool
    {
        return $this->getFirstMedia('quotations') !== null || $this->quotation_path !== null;
    }
}
