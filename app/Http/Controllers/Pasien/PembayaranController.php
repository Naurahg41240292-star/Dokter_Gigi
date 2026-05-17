<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembayaran = Pembayaran::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.pembayaran', [
            'pembayaran' => $pembayaran,
            'user' => $user,
        ]);
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        // Ensure user can only view their own payments
        if ($pembayaran->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pasien.pembayaran-detail', [
            'pembayaran' => $pembayaran,
        ]);
    }
}
