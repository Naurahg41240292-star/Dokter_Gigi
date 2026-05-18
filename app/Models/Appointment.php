<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // WAJIB ADA INI BIAR BISA SIMPAN DATA!
    protected $fillable = [
        'user_id',
        'nama_lengkap', 'nik', 'tgl_lahir', 'jenis_kelamin', 'no_telepon', 'email', 'alamat',
        'golongan_darah', 'tekanan_darah', 'alergi_obat', 'alergi_makanan', 'riwayat_penyakit', 'obat_dikonsumsi',
        'kontak_darurat_nama', 'kontak_darurat_hubungan', 'kontak_darurat_telepon', 'kontak_darurat_alamat',
        'tanggal', 'waktu', 'dokter', 'jenis_perawatan', 'keluhan',
        'status',
    ];
}