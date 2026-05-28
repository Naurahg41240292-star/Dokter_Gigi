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
        $pasien = Pasien::where('user_id', Auth::id())->first();


        if (!$pasien) {
            $appointments = collect(); // Kosongkan kalau belum punya data pasien
        } else {
            // Cari appointment berdasarkan pasien_id
            $appointments = Appointment::where('pasien_id', $pasien->id)
                                        ->orderBy('tanggal', 'desc')
                                        ->get();
        }
        
        return view('pasien.appointment', compact('appointments'));
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
            'waktu' => 'required|string',
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

        // Update user_id kalau pasien sudah ada tapi belum terhubung akun
        if (!$pasien->user_id) {
            $pasien->update(['user_id' => Auth::id()]);
        }

        // 2. Cari ID Dokter berdasarkan nama yang dipilih di form
        $dokterUser = User::where('name', $request->dokter)->where('role', 'dokter')->first();
        $dokter_id = $dokterUser ? $dokterUser->id : null;
        $namaDokter = $dokterUser ? $dokterUser->name : $request->dokter;

        // 3. Simpan Appointment dengan pasien_id dan dokter_id
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
        $pasien = Pasien::where('user_id', Auth::id())->first();
        
        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }

        $appointment = Appointment::where('pasien_id', $pasien->id)->findOrFail($id);
        $appointment->status = 'Dibatalkan';
        $appointment->save();

        return redirect()->route('appointment.index')->with('success', 'Appointment berhasil dibatalkan.');
    }
}