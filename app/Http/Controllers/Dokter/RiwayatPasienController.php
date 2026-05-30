<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\User;
use App\Models\Pasien;
use App\Notifications\RekamMedisSelesaiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
            'pasien_id'   => 'required|exists:pasiens,id',
            'diagnosa'    => 'required|string',
            'tindakan'    => 'required|string',
            'resep_obat'  => 'nullable|string',
            'catatan'     => 'nullable|string',
        ]);

        $rekamMedis = RekamMedis::create([
            'pasien_id'          => $validated['pasien_id'],
            'dokter_id'          => auth()->id(),
            'dokter'             => auth()->user()->name,
            'tanggal_kunjungan'  => now(),
            'keluhan'            => $request->keluhan ?? '-',
            'diagnosa'           => $validated['diagnosa'],
            'tindakan'           => $validated['tindakan'],
            'resep_obat'         => $validated['resep_obat'],
            'catatan'            => $validated['catatan'],
            'status'             => 'Selesai',
        ]);

        // Kirim notifikasi ke pasien
        $pasien = Pasien::find($validated['pasien_id']);

        if ($pasien && $pasien->user_id) {
            $userPasien = User::find($pasien->user_id);

            if ($userPasien) {
                $userPasien->notify(
                    new RekamMedisSelesaiNotification($pasien->nama)
                );
            }
        }

        return redirect()
            ->route('dokter.riwayat-pasien')
            ->with('success', 'Riwayat berhasil ditambahkan!');
    }

    /**
     * Get notifications.
     */
    public function getNotifikasi()
    {
        $user = Auth::user();

        $notifications = $user->unreadNotifications->map(function ($notif) {
            return [
                'id'      => $notif->id,
                'pesan'   => $notif->data['pesan'] ?? 'Notifikasi baru',
                'url'     => $notif->data['url'] ?? '#',
                'waktu'   => $notif->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'diagnosa'   => 'required|string',
            'tindakan'   => 'required|string',
            'resep_obat' => 'nullable|string',
            'catatan'    => 'nullable|string',
        ]);

        $rekamMedis->update($validated);

        return redirect()
            ->route('dokter.riwayat-pasien')
            ->with('success', 'Riwayat berhasil diperbarui!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rekamMedis = RekamMedis::where('dokter_id', auth()->id())
            ->findOrFail($id);

        return view('dokter.editriwayat', compact('rekamMedis'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekamMedis = RekamMedis::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $rekamMedis->delete();

        return redirect()
            ->route('dokter.riwayat-pasien')
            ->with('success', 'Riwayat berhasil dihapus!');
    }
}