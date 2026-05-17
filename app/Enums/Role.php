<?php

namespace App\Enums;

enum Role: string
{
    case PASIEN = 'pasien';
    case DOKTER = 'dokter';
    case PETUGAS = 'petugas';

    public function label(): string
    {
        return match($this) {
            self::PASIEN => 'Pasien',
            self::DOKTER => 'Dokter',
            self::PETUGAS => 'Petugas',
        };
    }
}
