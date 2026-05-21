<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengaturanDokterController extends Controller
{
    public function index()
    {
        $dokter = Auth::user();
        return view('dokter.pengaturan', compact('dokter'));
    }

    public function updateProfile(Request $request)
    {
        $dokter = Auth::user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $dokter->id,
        ]);

        $dokter->update($request->only('name', 'email'));
        return redirect()->route('dokter.pengaturan')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        $dokter = Auth::user();
        if (!Hash::check($request->current_password, $dokter->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $dokter->update(['password' => Hash::make($request->password)]);
        return redirect()->route('dokter.pengaturan')->with('success', 'Password berhasil diubah!');
    }
}