<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\RekamMedis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    // Dashboard Dokter
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

    // Tampilkan Form Isi Rekam Medis
    public function isiRekamMedis($id)
    {
        $appointment = Appointment::where('dokter_id', auth()->id())
            ->findOrFail($id);

        // Cek apakah sudah ada rekam medis untuk appointment ini
        $rekamMedis = RekamMedis::where('pasien_id', $appointment->pasien_id)
            ->whereDate('tanggal_kunjungan', $appointment->tanggal)
            ->first();

        return view('dokter.isi-rekam-medis', compact('appointment', 'rekamMedis'));
    }

    // Simpan Rekam Medis & Selesai Periksa
    public function simpanRekamMedis(Request $request, $id)
    {
        $appointment = Appointment::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'diagnosa'   => 'required|string',
            'tindakan'   => 'required|string',
            'resep_obat' => 'nullable|string',
            'catatan'    => 'nullable|string',
        ]);

        // Update atau Buat Rekam Medis
        $rekamMedis = RekamMedis::where('pasien_id', $appointment->pasien_id)
            ->whereDate('tanggal_kunjungan', $appointment->tanggal)
            ->first();

        if ($rekamMedis) {
            // Update yang sudah ada
            $rekamMedis->update([
                'pasien_id'         => $appointment->pasien_id,
                'dokter_id'         => auth()->id(),
                'dokter'            => auth()->user()->name,
                'tanggal_kunjungan' => $appointment->tanggal,
                'keluhan'           => $appointment->keluhan,
                'diagnosa'          => $validated['diagnosa'],
                'tindakan'          => $validated['tindakan'],
                'resep_obat'        => $validated['resep_obat'],
                'catatan'           => $validated['catatan'],
                'status'            => 'Selesai',
            ]);
        } else {
            // Buat baru kalau belum ada
            RekamMedis::create([
               'pasien_id'         => $appointment->pasien_id ?? $appointment->user_id, // Fallback kalau pasien_id null
                'dokter_id'         => auth()->id(),
                'dokter'            => auth()->user()->name,
                'tanggal_kunjungan' => $appointment->tanggal,
                'keluhan'           => $appointment->keluhan,
                'diagnosa'          => $validated['diagnosa'],
                'tindakan'          => $validated['tindakan'],
                'resep_obat'        => $validated['resep_obat'],
                'catatan'           => $validated['catatan'],
                'status'            => 'Selesai',
            ]);
        }

        // Update status appointment jadi Selesai
        $appointment->update(['status' => 'Selesai']);

        return redirect()->route('dokter.dashboard')
            ->with('success', 'Rekam medis berhasil disimpan & pemeriksaan selesai!');
    }
}