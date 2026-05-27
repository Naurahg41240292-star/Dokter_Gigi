<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function dashboard()
    {
        $dokterId = auth()->id();
        $today = Carbon::today();

        $antrianHariIni = Appointment::where('dokter_id', $dokterId)
            ->whereDate('tanggal', $today)
            ->orderBy('waktu', 'asc')
            ->get();

        return view('dokter.dashboard', compact('antrianHariIni'));
    }
}