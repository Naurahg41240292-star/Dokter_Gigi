<?php

namespace App\Enums;

enum Status: string
{
    case APPROVED = 'approved'; 
    case PENDING  = 'pending';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
        };
    }
}
