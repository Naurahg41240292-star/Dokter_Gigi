<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pasien\PembayaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/layanan/{slug}', [LandingPageController::class, 'showLayanan'])->name('layanan.detail');
Route::get('/home', [AuthController::class, 'homeRedirect'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendForgotPassword'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Pasien Routes
    Route::get('/dashboardpasien', function () {
        return view('pasien.dashboardpasien');
    })->name('pasien.dashboard');

    Route::get('/appointment', function () {
        return view('pasien.appointment');
    });

    Route::get('/riwayat-perawatan', function () {
        return view('pasien.riwayatperawatan');
    });

    Route::get('/artikel', function () {
        return view('pasien.artikel');
    })->name('pasien.artikel');

    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');

    // Dokter Routes
    Route::get('/dashboarddokter', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    // Petugas Routes
    Route::get('/dashboardpetugas', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');
});

Route::get('/welcome', function () {
    return view('welcome');
});
