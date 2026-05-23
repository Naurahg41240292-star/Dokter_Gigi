<?php

namespace App\Enums;

enum Status: string
{
    case Approved = 'approved'; // Diubah ke PascalCase, nilainya lowercase
    case Pending  = 'pending';  // Diubah ke PascalCase, nilainya lowercase

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
        };
    }
} 