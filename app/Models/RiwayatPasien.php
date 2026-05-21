<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id', 'dokter_id', 'tanggal_periksa', 'diagnosa_tindakan', 'resep_obat', 'catatan',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class); // Sesuaikan dengan model pasienmu
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
