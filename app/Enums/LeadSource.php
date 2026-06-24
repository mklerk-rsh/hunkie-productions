<?php

namespace App\Enums;

enum LeadSource: string
{
    case Website = 'website';
    case Referral = 'referral';
    case SocialMedia = 'social_media';
    case Google = 'google';
    case GoogleOrganic = 'google_organic';
    case GoogleAds = 'google_ads';
    case Facebook = 'facebook';
    case Instagram = 'instagram';
    case LinkedIn = 'linkedin';
    case Twitter = 'twitter';
    case YouTube = 'youtube';
    case Email = 'email';
    case Direct = 'direct';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Website => 'Website',
            self::Referral => 'Referral',
            self::SocialMedia => 'Social Media',
            self::Google => 'Google',
            self::GoogleOrganic => 'Google Organic',
            self::GoogleAds => 'Google Ads',
            self::Facebook => 'Facebook',
            self::Instagram => 'Instagram',
            self::LinkedIn => 'LinkedIn',
            self::Twitter => 'Twitter / X',
            self::YouTube => 'YouTube',
            self::Email => 'Email',
            self::Direct => 'Direct',
            self::Other => 'Other',
        };
    }

    public static function fromReferrer(?string $referrer): self
    {
        if (empty($referrer)) {
            return self::Direct;
        }

        $referrer = strtolower($referrer);

        if (str_contains($referrer, 'google')) {
            return str_contains($referrer, 'ad') ? self::GoogleAds : self::GoogleOrganic;
        }
        if (str_contains($referrer, 'facebook')) {
            return self::Facebook;
        }
        if (str_contains($referrer, 'instagram')) {
            return self::Instagram;
        }
        if (str_contains($referrer, 'linkedin')) {
            return self::LinkedIn;
        }
        if (str_contains($referrer, 'twitter') || str_contains($referrer, 'x.com')) {
            return self::Twitter;
        }
        if (str_contains($referrer, 'youtube')) {
            return self::YouTube;
        }
        if (str_contains($referrer, 'mail') || str_contains($referrer, 'email')) {
            return self::Email;
        }

        return self::Referral;
    }
}
