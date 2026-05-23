<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PetugasController extends Controller
{
    // ================= BERANDA =================
    public function dashboard()
    {
        $today = Carbon::today();

        $pasienHariIni = RekamMedis::whereDate('tanggal_kunjungan', $today)->count();
        $antrianHariIni = RekamMedis::whereDate('tanggal_kunjungan', $today)
                                ->where('status', 'Dalam Perawatan')
                                ->count();
        $sedangDiperiksa = $antrianHariIni; 
        $selesaiHariIni = RekamMedis::whereDate('tanggal_kunjungan', $today)
                                ->where('status', 'Selesai')
                                ->count();
        $totalPasien = Pasien::count();
        $dokterAktif = User::where('role', 'dokter')->count();
        

        $jadwalHariIni = RekamMedis::whereDate('tanggal_kunjungan', $today)
                                ->with('pasien')
                                ->orderBy('created_at', 'asc')
                                ->take(5)
                                ->get();

        $pasienTerbaru = Pasien::latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'pasienHariIni', 'antrianHariIni', 'sedangDiperiksa', 'selesaiHariIni',
            'totalPasien', 'dokterAktif','jadwalHariIni', 'pasienTerbaru'
            
        ));
    }

    // ================= JADWAL KONTROL =================
    public function jadwalKontrol()
    {
        $today = Carbon::today();

        // Statistik Kartu
        $totalJanji = Appointment::whereDate('tanggal', $today)->count();
        $menunggu = Appointment::whereDate('tanggal', $today)->where('status', 'Menunggu')->count();
        $sedangPeriksa = Appointment::whereDate('tanggal', $today)->where('status', 'Sedang Berjalan')->count();
        $selesai = Appointment::whereDate('tanggal', $today)->where('status', 'Selesai')->count();

        // Data Tabel
        $appointments = Appointment::whereDate('tanggal', $today)
                            ->with(['pasien', 'user', 'rekamMedis'])
                            ->orderBy('waktu', 'asc')
                            ->paginate(10);

        return view('petugas.jadwalkontrol', compact(
            'totalJanji', 'menunggu', 'sedangPeriksa', 'selesai', 'appointments'
        ));
    }

    // ================= DATA PASIEN CRUD =================
    public function create()
    {
        return view('petugas.inputdata');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:pasiens',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'riwayat_alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'kontak_nama' => 'nullable|string',
            'kontak_hubungan' => 'nullable|string',
            'kontak_telepon' => 'nullable|string',
        ]);

        $pasien = Pasien::create($validatedData);

        // Buat Rekam Medis Otomatis saat input pasien baru
        $sudahAdaRM = RekamMedis::where('pasien_id', $pasien->id)
                            ->whereDate('tanggal_kunjungan', now()->toDateString())
                            ->exists();

        if (!$sudahAdaRM) {
            RekamMedis::create([
                'pasien_id' => $pasien->id,
                'dokter' => 'Belum Ditentukan',
                'tanggal_kunjungan' => now()->toDateString(),
                'keluhan' => 'Belum ada keluhan',
                'diagnosa' => null,
                'tindakan' => null,
                'resep_obat' => null,
                'status' => 'Dalam Perawatan',
            ]);
        }

        return redirect()->route('petugas.input-data')->with('success', 'Data pasien berhasil disimpan!');
    }

    public function index()
    {
        $pasiens = Pasien::latest()->paginate(10);
        return view('petugas.datapasien', compact('pasiens'));
    }

    public function edit(Pasien $pasien)
    {
    // Ambil rekam medis terakhir pasien (kalau ada)
    $rekamMedis = RekamMedis::where('pasien_id', $pasien->id)->latest()->first();
    
    return view('petugas.editpasien', compact('pasien', 'rekamMedis'));
    }

    // REVISI 1: Update Pasien + Rekam Medis digabung
    public function update(Request $request, Pasien $pasien)
    {
        // Validasi Data Pasien + Data Rekam Medis
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:50|unique:pasiens,nik,' . $pasien->id,
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'riwayat_alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'kontak_nama' => 'nullable|string',
            'kontak_hubungan' => 'nullable|string',
            'kontak_telepon' => 'nullable|string',
            // Field dari Rekam Medis
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'status_perawatan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        // 1. Update Data Pasien
        $pasienData = $request->only([
            'nama', 'nik', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 
            'golongan_darah', 'riwayat_alergi', 'riwayat_penyakit', 
            'kontak_nama', 'kontak_hubungan', 'kontak_telepon'
        ]);
        $pasien->update($pasienData);

        // 2. Update Rekam Medis Terakhir Pasien
        $rekamMedis = RekamMedis::where('pasien_id', $pasien->id)->latest()->first();
        if ($rekamMedis) {
            $rekamMedis->update([
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'status' => $request->status_perawatan ?? $rekamMedis->status,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->route('petugas.data-pasien')->with('success', 'Data pasien & rekam medis berhasil diperbarui!');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('petugas.data-pasien')->with('success', 'Data pasien berhasil dihapus!');
    }

    public function manajemenUser()
{
    $users = User::whereIn('role', ['dokter', 'petugas'])
                ->orderByRaw("FIELD(status, 'pending') DESC")
                ->latest()
                ->get();

    return view('petugas.manajemen-user', compact('users'));
}

public function approveUser(User $user)
{
    $user->update(['status' => Status::APPROVED]);
    return redirect()->route('petugas.manajemen-user')->with('success', "User {$user->name} berhasil disetujui.");
}
public function destroyUser(User $user)
{
    // Hapus user dari database (aksi menolak/menghapus)
    $user->delete();
    return redirect()->route('petugas.manajemen-user')->with('success', "User {$user->name} berhasil dihapus.");
}
    // ================= PENGATURAN (REVISI 3) =================
    public function pengaturan()
    {
        return view('petugas.pengaturan');
    }
}