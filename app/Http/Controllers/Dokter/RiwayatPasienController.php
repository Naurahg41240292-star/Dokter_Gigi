<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPasien;
use App\Models\Pasien; // Panggil model pasien
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPasienController extends Controller
{
    public function index()
    {
        $riwayats = RiwayatPasien::with('pasien')->where('dokter_id', Auth::id())->latest()->get();
        return view('dokter.riwayat-pasien.index', compact('riwayats'));
    }

    public function create()
    {
        $pasiens = Pasien::all();
        return view('dokter.riwayat-pasien.create', compact('pasiens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'tanggal_periksa' => 'required|date',
            'diagnosa_tindakan' => 'required',
            'resep_obat' => 'nullable',
            'catatan' => 'nullable',
        ]);

        RiwayatPasien::create([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => Auth::id(),
            'tanggal_periksa' => $request->tanggal_periksa,
            'diagnosa_tindakan' => $request->diagnosa_tindakan,
            'resep_obat' => $request->resep_obat,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('dokter.riwayat-pasien')->with('success', 'Riwayat pasien berhasil disimpan!');
    }

    public function edit(RiwayatPasien $riwayatPasien)
    {
        $pasiens = Pasien::all();
        return view('dokter.riwayat-pasien.edit', compact('riwayatPasien', 'pasiens'));
    }

    public function update(Request $request, RiwayatPasien $riwayatPasien)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'tanggal_periksa' => 'required|date',
            'diagnosa_tindakan' => 'required',
            'resep_obat' => 'nullable',
            'catatan' => 'nullable',
        ]);

        $riwayatPasien->update($request->all());
        return redirect()->route('dokter.riwayat-pasien')->with('success', 'Riwayat pasien berhasil diperbarui!');
    }

    public function destroy(RiwayatPasien $riwayatPasien)
    {
        $riwayatPasien->delete();
        return redirect()->route('dokter.riwayat-pasien')->with('success', 'Riwayat pasien berhasil dihapus!');
    }
}
