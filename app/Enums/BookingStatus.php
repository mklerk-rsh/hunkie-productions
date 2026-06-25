<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Inquiry = 'inquiry';
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case DepositPaid = 'deposit_paid';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
    case Rescheduled = 'rescheduled';

    public function label(): string
    {
        return match ($this) {
            self::Inquiry => 'Inquiry',
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::DepositPaid => 'Deposit Paid',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
            self::Delivered => 'Delivered',
            self::Cancelled => 'Cancelled',
            self::Rescheduled => 'Rescheduled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Inquiry => 'info',
            self::Pending => 'warning',
            self::Confirmed => 'primary',
            self::DepositPaid => 'success',
            self::InProgress => 'purple',
            self::Completed => 'success',
            self::Delivered => 'success',
            self::Cancelled => 'danger',
            self::Rescheduled => 'gray',
        };
    }
}
