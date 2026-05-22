<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Pricelist;
use Illuminate\Support\Facades\Auth;

class PricelistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pricelist = Pricelist::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.pricelist', [
            'pricelist' => $pricelist,
            'user' => $user,
        ]);
    }

    public function show($id)
    {
        $pricelist = Pricelist::findOrFail($id);

        // Ensure user can only view their own pricelist items
        if ($pricelist->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pasien.pricelist-detail', [
            'pricelist' => $pricelist,
        ]);
    }
}
