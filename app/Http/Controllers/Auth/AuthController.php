<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Redirect from root path (/)
     */
    public function homeRedirect()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Pakai logic yang sama dengan dashboard()
        return $this->dashboard(); 
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // ✅ UBAH: Bandingkan dengan Enum Status, bukan string 'pending'
        if ($user->status === Status::PENDING) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum disetujui oleh Admin.',
            ]);
        }

        // ✅ UBAH: Bandingkan dengan Enum Role, bukan string 'dokter'/'petugas'/'pasien'
        switch ($user->role) {
            case Role::DOKTER:
                return redirect()->route('dokter.dashboard');
            case Role::PETUGAS:
                return redirect()->route('petugas.dashboard');
            case Role::PASIEN:
            default:
                return redirect()->route('pasien.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:pasien,dokter,petugas'],
        ]);

         $statusAkun = ($request->role === Role::PASIEN->value)
            ? Status::APPROVED   
            : Status::PENDING;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $statusAkun,
        ]);

        if ($user->status === 'pending') {
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan Admin.');
        } else {
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan masuk menggunakan email dan kata sandi Anda.');
        }
    }

    public function sendForgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return back()->withInput()->withErrors([
                'email' => 'Email tidak terdaftar di sistem.',
            ]);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($user->email)->send(
            new ResetPasswordMail($token, $user->email)
        );

        return redirect()->route('password.request')->with('status', 'Link reset password telah dikirim ke email Anda. Silakan cek email untuk melanjutkan.');
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->where('token', $validated['token'])
            ->where('created_at', '>=', now()->subMinutes(60))
            ->first();

        if (! $reset) {
            return back()->withErrors([
                'email' => 'Tautan reset password tidak valid atau sudah kadaluarsa.',
            ]);
        }

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard()
{
    $user = Auth::user();

    if ($user->status === Status::PENDING) {
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Akun Anda belum disetujui oleh Admin.',
        ]);
    }

    switch ($user->role) {
        case Role::DOKTER:
            return redirect()->route('dokter.dashboard');
        case Role::PETUGAS:
            return redirect()->route('petugas.dashboard');
        case Role::PASIEN:
        default:
            return redirect()->route('pasien.dashboard');
    }
}
}