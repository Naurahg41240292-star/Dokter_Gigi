<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien; // <--- TAMBAHKAN INI
use App\Models\User;   // <--- TAMBAHKAN INI
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id', 'dokter_id', 'user_id',
        'nama_lengkap', 'nik', 'tgl_lahir', 'jenis_kelamin', 'no_telepon', 'email', 'alamat',
        'golongan_darah', 'tekanan_darah', 'alergi_obat', 'alergi_makanan', 'riwayat_penyakit', 'obat_dikonsumsi',
        'kontak_darurat_nama', 'kontak_darurat_hubungan', 'kontak_darurat_telepon', 'kontak_darurat_alamat',
        'tanggal', 'waktu', 'dokter', 'jenis_perawatan', 'keluhan',
        'status',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}