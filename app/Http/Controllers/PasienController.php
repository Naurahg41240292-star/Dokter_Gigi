<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Appointment;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    // Helper: Ambil data pasien dari user yang login
    private function getPasien()
    {
        return Pasien::where('user_id', auth()->id())->first();
    }

    // 1. Dashboard Pasien
        public function dashboard()
    {
        $pasien = $this->getPasien();

        // Jika akun pasien belum terhubung ke tabel pasiens
        if (!$pasien) {
            $totalAppointments = 0;
            $upcomingAppointment = null;
            $totalPerawatan = 0;
            $tagihanPending = 0;
            
            return view('pasien.dashboard', compact('totalAppointments', 'upcomingAppointment', 'totalPerawatan', 'tagihanPending'));
        }

        // 1. Total Appointment (Semua waktu)
        $totalAppointments = Appointment::where('pasien_id', $pasien->id)->count();

        // 2. Appointment mendatang yang aktif (Menunggu Konfirmasi / Terjadwal)
        $upcomingAppointment = Appointment::where('pasien_id', $pasien->id)
            ->whereIn('status', ['Menunggu Konfirmasi', 'Terjadwal'])
            ->whereDate('tanggal', '>=', \Carbon\Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->first();

        // 3. Total Perawatan Selesai (Rekam Medis)
        $totalPerawatan = RekamMedis::where('pasien_id', $pasien->id)
            ->where('status', 'Selesai')
            ->count();

        // 4. Tagihan Pending (Sementara 0, nanti bisa dihubungkan ke tabel pembayaran)
        $tagihanPending = 0;

        return view('pasien.dashboard', compact(
            'totalAppointments', 
            'upcomingAppointment', 
            'totalPerawatan', 
            'tagihanPending'
        ));
    }

    // 2. Lihat Semua Riwayat Rekam Medis
    public function rekamMedis()
    {
        $pasien = $this->getPasien();

        if (!$pasien) {
            return redirect()->route('pasien.dashboard');
        }

        $rekamMedis = RekamMedis::where('pasien_id', $pasien->id)
            ->where('status', 'Selesai')
            ->orderBy('tanggal_kunjungan', 'desc')
            ->paginate(10);

        return view('pasien.rekam-medis', compact('rekamMedis'));
    }

    // 3. Detail 1 Rekam Medis
    public function showRekamMedis($id)
    {
        $pasien = $this->getPasien();

        // Pastikan rekam medis ini milik pasien yang login (keamanan)
        $rekamMedis = RekamMedis::where('pasien_id', $pasien->id)
            ->where('status', 'Selesai')
            ->findOrFail($id);

        return view('pasien.rekam-medis-detail', compact('rekamMedis'));
    }
}