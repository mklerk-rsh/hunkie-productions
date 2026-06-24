<?php

namespace App\Enums;

enum LeadSource: string
{
    case Website = 'website';
    case Referral = 'referral';
    case SocialMedia = 'social_media';
    case Google = 'google';
    case Direct = 'direct';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Website => 'Website',
            self::Referral => 'Referral',
            self::SocialMedia => 'Social Media',
            self::Google => 'Google',
            self::Direct => 'Direct',
            self::Other => 'Other',
        };
    }
}
