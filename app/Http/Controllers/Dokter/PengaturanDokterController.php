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
        return view('dokter.pengaturan.index', compact('dokter'));
    }

    public function updateProfile(Request $request)
    {
        $dokter = Auth::user();

        // 1. Validasi semua input termasuk spesialisasi, SIP, dan foto
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $dokter->id,
            'spesialisasi'  => 'nullable|string|max:255',
            'nomor_sip'     => 'nullable|string|max:255',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil data teks yang mau disimpan
        $data = $request->only('name', 'email', 'spesialisasi', 'nomor_sip');

        // 3. Cek kalau ada foto yang diupload
        if ($request->hasFile('photo')) {
            // Hapus foto lama kalau ada
            if ($dokter->photo && \Storage::exists('public/' . $dokter->photo)) {
                \Storage::delete('public/' . $dokter->photo);
            }
            // Simpan foto baru
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        // 4. Simpan ke database
        $dokter->update($data);

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