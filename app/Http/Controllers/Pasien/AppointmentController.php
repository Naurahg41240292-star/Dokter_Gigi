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
    // METHOD DASHBOARD (Jika masih dipakai di route lain)
    public function dashboard()
    {
        $user = Auth::user();
        
        // Cari data pasien dari user yang login
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (!$pasien) {
            $upcomingAppointment = null;
            $totalAppointments = 0;
        } else {
            // Gunakan pasien_id agar sinkron dengan sistem petugas & dokter
            $upcomingAppointment = Appointment::where('pasien_id', $pasien->id)
                ->whereIn('status', ['Terjadwal', 'Menunggu Konfirmasi'])
                ->where('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal', 'asc')
                ->orderBy('waktu', 'asc')
                ->first();

            $totalAppointments = Appointment::where('pasien_id', $pasien->id)
                ->whereNotIn('status', ['Dibatalkan'])
                ->count();
        }

        $totalPerawatan = 0; 
        $tagihanPending = 0;

        return view('pasien.dashboardpasien', compact(
            'upcomingAppointment', 
            'totalAppointments', 
            'totalPerawatan', 
            'tagihanPending'
        ));
    }

    // Nampilin list appointment
    public function index()
    {
        $pasien = Pasien::where('user_id', Auth::id())->first();

        if (!$pasien) {
            $appointments = collect(); // Kosongkan kalau belum punya data pasien
        } else {
            $appointments = Appointment::where('pasien_id', $pasien->id)
                                        ->orderBy('tanggal', 'desc')
                                        ->get();
        }
        
        return view('pasien.appointment', compact('appointments'));
    }

    // Nyimpen data form ke database (INI YANG PALING PENTING DIPERBAIKI)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'required|string|max:13', // Diubah jadi max:13 biar fleksibel
            'alamat' => 'required|string',
            'kontak_darurat_nama' => 'required|string',
            'kontak_darurat_hubungan' => 'required|string',
            'kontak_darurat_telepon' => 'required|string|max:13',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required|string',
            'dokter' => 'required|string', // Sementara string, nanti kita cari ID-nya
            'jenis_perawatan' => 'required|string',
            'keluhan' => 'nullable|string',
        ]);

        // 1. Cari atau Buat Data Pasien berdasarkan NIK
        $pasien = Pasien::firstOrCreate(
            ['nik' => $validated['nik']], 
            [
                'user_id' => Auth::id(), // Hubungkan ke akun pasien yang login
                'nama' => $validated['nama_lengkap'],
                'tanggal_lahir' => $validated['tgl_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'no_telp' => $validated['no_telepon'],
            ]
        );

        // 2. Cari ID Dokter berdasarkan nama yang dipilih di form
        $dokterUser = User::where('name', $request->dokter)->where('role', 'dokter')->first();
        $dokter_id = $dokterUser ? $dokterUser->id : null;
        $namaDokter = $dokterUser ? $dokterUser->name : $request->dokter;

        // 3. Simpan Appointment dengan pasien_id dan dokter_id
        Appointment::create([
            'user_id' => Auth::id(), // ID user pasien
            'pasien_id' => $pasien->id, // ID tabel pasien (WAJIB)
            'dokter_id' => $dokter_id, // ID user dokter (WAJIB)
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
            'dokter' => $namaDokter, // Simpan nama string juga
            'jenis_perawatan' => $validated['jenis_perawatan'],
            'keluhan' => $validated['keluhan'],
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('appointment.index')->with('success', 'Appointment berhasil dibuat! Silakan tunggu konfirmasi dari petugas.');
    }

    // Update status (misal pasien ngeklik batal)
    public function cancel($id)
    {
        $pasien = Pasien::where('user_id', Auth::id())->first();
        
        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }

        // Cari appointment milik pasien ini
        $appointment = Appointment::where('pasien_id', $pasien->id)->findOrFail($id);
        $appointment->status = 'Dibatalkan';
        $appointment->save();

        return redirect()->route('appointment.index')->with('success', 'Appointment berhasil dibatalkan.');
    }
}