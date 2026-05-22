<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // METHOD DASHBOARD YANG SUDAH AKTIF KEMBALI (DATA ASLI)
    public function dashboard()
{
    $user = Auth::user();

    // Cari appointment paling segera yang statusnya masih Aktif (Terjadwal / Menunggu Konfirmasi)
    $upcomingAppointment = Appointment::where('user_id', $user->id)
        ->whereIn('status', ['Terjadwal', 'Menunggu Konfirmasi'])
        ->where('tanggal', '>=', now()->toDateString()) // Hanya tanggal hari ini & seterusnya
        ->orderBy('tanggal', 'asc')
        ->orderBy('waktu', 'asc')
        ->first();

    // 🔥 FIX: Hitung total appointment TANPA yang dibatalkan
    $totalAppointments = Appointment::where('user_id', $user->id)
        ->whereNotIn('status', ['Dibatalkan']) // <-- Tambahkan ini
        ->count();


    // Biarin ini dummy dulu soalnya fiturnya belum ada
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
    'no_telepon' => 'required|string|size:12', // UBAH JADI SIZE:12
    'alamat' => 'required|string',
    'kontak_darurat_nama' => 'required|string',
    'kontak_darurat_hubungan' => 'required|string',
    'kontak_darurat_telepon' => 'required|string|size:12', // UBAH JADI SIZE:12
    'tanggal' => 'required|date|after_or_equal:today',
    'waktu' => 'required|string',
    'dokter' => 'required|string',
    'jenis_perawatan' => 'required|string',
    'keluhan' => 'nullable|string',
]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Menunggu Konfirmasi'; // Default dari migration

        Appointment::create($validated);

        return redirect()->route('appointment.index')->with('success', 'Appointment berhasil dibuat!');
    }

    // Update status (misal pasien ngeklik batal)
    public function cancel($id)
{
    $appointment = Appointment::where('user_id', Auth::id())->findOrFail($id);
    $appointment->status = 'Dibatalkan'; // Sesuaikan dengan status di database kamu
    $appointment->save();

    return redirect()->route('appointment.index')->with('success', 'Appointment berhasil dibatalkan.');
}
}