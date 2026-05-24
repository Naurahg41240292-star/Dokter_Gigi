<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    
    protected $fillable = [
        'pasien_id', 'dokter', 'tanggal_kunjungan', 'keluhan', 
        'diagnosa', 'tindakan', 'resep_obat', 'status'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}