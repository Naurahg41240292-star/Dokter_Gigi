<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
   
    protected $fillable = [
        'pasien_id', 
        'dokter_id', 
        'dokter',              // Baru ditambahkan
        'tanggal_kunjungan',   // Baru ditambahkan
        'keluhan',             // Baru ditambahkan
        'diagnosa',            // Baru ditambahkan (terpisah)
        'tindakan',            // Baru ditambahkan (terpisah)
        'resep_obat', 
        'catatan',
        'status'               // Baru ditambahkan
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokterUser()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}