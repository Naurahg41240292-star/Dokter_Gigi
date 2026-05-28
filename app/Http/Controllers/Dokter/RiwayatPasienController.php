<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RiwayatPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua rekam medis yang sudah selesai, yang diperiksa oleh dokter ini
        $riwayatPasien = RekamMedis::where('dokter_id', auth()->id())
            ->where('status', 'Selesai')
            ->with('pasien')
            ->orderBy('tanggal_kunjungan', 'desc')
            ->paginate(10);

       return view('dokter.riwayat-pasien.index', compact('riwayatPasien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokter.tambahriwayat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        RekamMedis::create([
            'pasien_id' => $validated['pasien_id'],
            'dokter_id' => auth()->id(),
            'dokter' => auth()->user()->name,
            'tanggal_kunjungan' => now(),
            'keluhan' => $request->keluhan ?? '-',
            'diagnosa' => $validated['diagnosa'],
            'tindakan' => $validated['tindakan'],
            'resep_obat' => $validated['resep_obat'],
            'catatan' => $validated['catatan'],
            'status' => 'Selesai',
        ]);

        return redirect()->route('dokter.riwayat-pasien')->with('success', 'Riwayat berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rekamMedis = RekamMedis::where('dokter_id', auth()->id())->findOrFail($id);
        return view('dokter.editriwayat', compact('rekamMedis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::where('dokter_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $rekamMedis->update($validated);

        return redirect()->route('dokter.riwayat-pasien')->with('success', 'Riwayat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekamMedis = RekamMedis::where('dokter_id', auth()->id())->findOrFail($id);
        $rekamMedis->delete();

        return redirect()->route('dokter.riwayat-pasien')->with('success', 'Riwayat berhasil dihapus!');
    }
}