<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama', 
        'nik', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'alamat', 
        'golongan_darah', 
        'riwayat_alergi', 
        'riwayat_penyakit',
        'kontak_nama', 
        'kontak_hubungan', 
        'kontak_telepon'
    ];

    // Relasi ke Rekam Medis (1 Pasien bisa punya banyak Rekam Medis)
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}