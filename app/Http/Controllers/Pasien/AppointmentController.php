<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Nampilin list appointment pasien
    public function index()
    {
        $userId = Auth::id();

        // Cari appointment yang terkait dengan user yang login
        // Baik melalui user_id di appointment (daftar sendiri)
        // Maupun melalui pasien_id yang terhubung ke user_id di tabel pasiens (daftar oleh petugas)
        $appointments = Appointment::where('user_id', $userId)
            ->orWhereHas('pasien', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pasien.appointment', compact('appointments'));
    }

    public function cekJadwal(Request $request)
    {
        $dokter = $request->query('dokter');
        $tanggal = $request->query('tanggal');

        // Cari appointment yang sudah dibooking (status selain Dibatalkan)
        $bookedSlots = Appointment::where('dokter', $dokter)
            ->where('tanggal', $tanggal)
            ->whereNotIn('status', ['Dibatalkan'])
            ->pluck('waktu') // Ambil kolom waktu yang sudah dibooking
            ->toArray();

        return response()->json($bookedSlots);
    }

    // Nyimpen data form ke database (INI YANG PALING PENTING)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'required|string|max:13',
            'alamat' => 'required|string',
            'kontak_darurat_nama' => 'required|string',
            'kontak_darurat_hubungan' => 'required|string',
            'kontak_darurat_telepon' => 'required|string|max:13',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Kalau tanggal yang dipilih adalah HARI INI
                    if (request('tanggal') === now()->toDateString()) {
                        // Pecah waktu "08:00 - 08:45" jadi ambil bagian "08:00" saja
                        $waktuMulai = explode(' - ', $value)[0];
                        
                        // Bandingkan dengan jam sekarang
                        if ($waktuMulai < now()->format('H:i')) {
                            $fail('Tidak bisa memilih waktu yang sudah lewat untuk hari ini.');
                        }
                    }
                },
            ],
            'dokter' => 'required|string',
            'jenis_perawatan' => 'required|string',
            'keluhan' => 'nullable|string',
        ]);

        // 1. Cari atau Buat Data Pasien berdasarkan NIK
        $pasien = Pasien::firstOrCreate(
            ['nik' => $validated['nik']], 
            [
                'user_id' => Auth::id(),
                'nama' => $validated['nama_lengkap'],
                'tanggal_lahir' => $validated['tgl_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'no_telp' => $validated['no_telepon'],
            ]
        );

        // PASTIKAN user_id di tabel pasien SELALU terhubung ke akun yang sedang login
        // Ini mencegah data putus kalau NIK sudah pernah diinput petugas sebelumnya
        if ($pasien->user_id !== Auth::id()) {
            $pasien->update(['user_id' => Auth::id()]);
        }

        // 2. Cari ID Dokter berdasarkan nama yang dipilih di form
        $dokterUser = User::where('name', $request->dokter)->where('role', 'dokter')->first();
        $dokter_id = $dokterUser ? $dokterUser->id : null;
        $namaDokter = $dokterUser ? $dokterUser->name : $request->dokter;

        // 3. Simpan Appointment dengan pasien_id ve dokter_id
        Appointment::create([
            'user_id' => Auth::id(),
            'pasien_id' => $pasien->id,       // WAJIB ADA
            'dokter_id' => $dokter_id,         // WAJIB ADA
            'nama_lengkap' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'tgl_lahir' => $validated['tgl_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_telepon' => $validated['no_telepon'],
            'alamat' => $validated['alamat'],
            'kontak_darurat_nama' => $validated['kontak_darurat_nama'],
            'kontak_darurat_hubungan' => $validated['kontak_darurat_hubungan'],
            'kontak_darurat_telepon' => $validated['kontak_darurat_telepon'],
            'tanggal' => $validated['tanggal'],
            'waktu' => $validated['waktu'],
            'dokter' => $namaDokter,
            'jenis_perawatan' => $validated['jenis_perawatan'],
            'keluhan' => $validated['keluhan'],
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('appointment.index')->with('success', 'Appointment berhasil dibuat! Silakan tunggu konfirmasi dari petugas.');
    }

    // Update status (misal pasien ngeklik batal)
    public function cancel($id)
    {
        $userId = Auth::id();

        // Cari appointment yang terkait dengan user (aman untuk Hafiz & Aminah)
        $appointment = Appointment::where('user_id', $userId)
            ->orWhereHas('pasien', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->findOrFail($id);

        $appointment->status = 'Dibatalkan';
        $appointment->save();

        return redirect()->route('appointment.index')->with('success', 'Appointment berhasil dibatalkan.');
    }
}