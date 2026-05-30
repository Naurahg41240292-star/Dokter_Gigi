<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardDokterController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $dokterId = Auth::id(); // ID dokter yang sedang login

        // Ambil semua appointment hari ini milik dokter ini
        $antrianHariIni = Appointment::where('dokter_id', $dokterId)
                                ->whereDate('tanggal', $today)
                                ->with('pasien')
                                ->orderBy('waktu', 'asc')
                                ->get();

        // Kirim variabel $antrianHariIni ke view (Nama sama persis dengan di Blade kamu)
        return view('dokter.dashboard', compact('antrianHariIni'));
    }
}