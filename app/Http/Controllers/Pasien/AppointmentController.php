<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // METHOD DASHBOARD YANG SUDAH AKTIF KEMBALI (DATA ASLI)
    public function dashboard()
{
    // MODE AMAN: Pakai data dummy dulu
    $isNewUser = true;
    $upcomingAppointment = null;
    $totalAppointments = 0;
    $totalPerawatan = 0;
    $tagihanPending = 0;

    return view('pasien.dashboardpasien', compact(
        'upcomingAppointment', 
        'totalAppointments', 
        'totalPerawatan', 
        'tagihanPending', 
        'isNewUser'
    ));
}

    // Nampilin list appointment
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())
                                    ->orderBy('tanggal', 'desc')
                                    ->get();
        
        return view('pasien.appointment', compact('appointments'));
    }

    // Nyimpen data form ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
            'kontak_darurat_nama' => 'required|string',
            'kontak_darurat_hubungan' => 'required|string',
            'kontak_darurat_telepon' => 'required|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required|string',
            'dokter' => 'required|string',
            'jenis_perawatan' => 'required|string',
            'keluhan' => 'nullable|string', // Tambahin validasi keluhan biar gak error
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Menunggu Konfirmasi'; // Default dari migration

        Appointment::create($validated);

        return redirect()->route('appointment.index')->with('success', 'Appointment berhasil dibuat!');
    }

    // Update status (misal pasien ngeklik batal)
    public function update(Request $request, $id)
    {
        $appointment = Appointment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $appointment->update(['status' => 'Dibatalkan']);

        return redirect()->route('pasien.dashboard')->with('success', 'Appointment berhasil dibatalkan.');
    }
}