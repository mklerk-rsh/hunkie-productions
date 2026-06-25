<?php

namespace App\Enums;

enum QuotationStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Viewed = 'viewed';
    case Negotiating = 'negotiating';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Expired = 'expired';
    case Revised = 'revised';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Sent => 'Sent',
            self::Viewed => 'Viewed',
            self::Negotiating => 'Negotiating',
            self::Accepted => 'Accepted',
            self::Rejected => 'Rejected',
            self::Expired => 'Expired',
            self::Revised => 'Revised',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Sent => 'info',
            self::Viewed => 'primary',
            self::Negotiating => 'warning',
            self::Accepted => 'success',
            self::Rejected => 'danger',
            self::Expired => 'gray',
            self::Revised => 'purple',
        };
    }
}
