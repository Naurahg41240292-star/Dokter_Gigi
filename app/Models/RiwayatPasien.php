<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPasien extends Model
{
    use HasFactory;

    // Tentukan nama tabel di database (karena namanya jamak/pakai hubung)
    protected $table = 'riwayat_pasien'; // Sesuaikan dengan nama tabelmu di database!

    // Izinkan kolom-kolom ini untuk diisi massal (mass assignment)
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal_periksa',
        'diagnosa_tindakan',
        'resep_obat',
        'catatan',
    ];

    // Relasi: Riwayat ini milik 1 Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
}