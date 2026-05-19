<?php

namespace App\Http\Controllers;

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
        $penerimaanHariIni = Pembayaran::whereDate('created_at', $today)->sum('amount');

        $jadwalHariIni = RekamMedis::whereDate('tanggal_kunjungan', $today)
                                ->with('pasien')
                                ->orderBy('created_at', 'asc')
                                ->take(5)
                                ->get();

        $pasienTerbaru = Pasien::latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'pasienHariIni', 'antrianHariIni', 'sedangDiperiksa', 'selesaiHariIni',
            'totalPasien', 'dokterAktif', 'penerimaanHariIni', 'jadwalHariIni', 'pasienTerbaru'
        ));
    }

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
                        ->with(['pasien', 'user', 'rekamMedis']) // PENTING: Ikut bawa data pasien/user
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

        // 1. Simpan Data Pasien
        $pasien = Pasien::create($validatedData);

        // 2. BUAT REKAM MEDIS OTOMATIS (INI KUNCINYA AGAR LANGSUNG MUNCUL DI REKAM MEDIS)
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
        return view('petugas.editpasien', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
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
        ]);

        $pasien->update($validatedData);

        return redirect()->route('petugas.data-pasien')->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('petugas.data-pasien')->with('success', 'Data pasien berhasil dihapus!');
    }

    // ================= REKAM MEDIS CRUD =================
    public function rmIndex()
    {
        $rekamMedis = RekamMedis::with('pasien')->latest()->paginate(10);
        return view('petugas.rekammedis', compact('rekamMedis'));
    }

    public function rmCreate()
    {
        $pasiens = Pasien::all();
        return view('petugas.tambah_rekammedis', compact('pasiens'));
    }

    public function rmStore(Request $request)
    {
        $validatedData = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
            'status' => 'required|in:Dalam Perawatan,Selesai',
        ]);

        RekamMedis::create($validatedData);

        return redirect()->route('petugas.rekam-medis')
            ->with('success', 'Rekam medis berhasil ditambahkan!');
    }

    public function rmEdit(RekamMedis $rekamMedis)
    {
        $pasiens = Pasien::all();
        return view('petugas.edit_rekammedis', compact('rekamMedis', 'pasiens'));
    }

    public function rmUpdate(Request $request, RekamMedis $rekamMedis)
    {
        $validatedData = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
            'status' => 'required|in:Dalam Perawatan,Selesai',
        ]);

        $rekamMedis->update($validatedData);

        return redirect()->route('petugas.rekam-medis')
            ->with('success', 'Rekam medis berhasil diperbarui!');
    }

    public function rmDestroy(RekamMedis $rekamMedis)
    {
        $rekamMedis->delete();
        return redirect()->route('petugas.rekam-medis')
            ->with('success', 'Rekam medis berhasil dihapus!');
    }
}