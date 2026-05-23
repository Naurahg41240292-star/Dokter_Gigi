<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pasien\PricelistController;
use App\Http\Controllers\Pasien\AppointmentController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\Dokter\PengaturanDokterController;
use App\Http\Controllers\Pasien\PengaturanController;

// ==========================================
// ROUTE PUBLIK (Tanpa Login)
// ==========================================
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


// ==========================================
// ROUTE AUTH (Wajib Login)
// ==========================================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Utama (Auth Controller)
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // ==========================================
    // ROUTE PASIEN
    // ==========================================
    // Dashboard Pasien Khusus
    Route::get('/dashboardpasien', [AppointmentController::class, 'dashboard'])->name('pasien.dashboard');

    // Appointment
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::put('/appointment/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointment.cancel');

    // Riwayat & Artikel
    Route::get('/riwayat-perawatan', function () {
        return view('pasien.riwayatperawatan');
    })->name('pasien.riwayat');

    Route::get('/artikel', function () {
        return view('pasien.artikel');
    })->name('pasien.artikel');

    // Pricelist
    Route::get('/pricelist', [PricelistController::class, 'index'])->name('pricelist.index');
    Route::get('/pricelist/{id}', [PricelistController::class, 'show'])->name('pricelist.show');

    // Pengaturan Pasien
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');

     // TAMBAHKAN 2 ROUTE INI:
    Route::put('/pengaturan/profile', [PengaturanController::class, 'updateProfile'])->name('pengaturan.profile.update');
    Route::put('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.password.update');


    // ==========================================
    // ROUTE DOKTER (FITUR BARU)
    // ==========================================
    // 1. Dashboard
    Route::get('/dashboarddokter', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    // 2. Riwayat Pasien (Diagnosa & Resep Obat)
    Route::get('/dokter/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('dokter.riwayat-pasien');
    Route::get('/dokter/tambah-riwayat', [RiwayatPasienController::class, 'create'])->name('dokter.tambah-riwayat');
    Route::post('/dokter/simpan-riwayat', [RiwayatPasienController::class, 'store'])->name('dokter.simpan-riwayat');
    Route::get('/dokter/edit-riwayat/{riwayatPasien}', [RiwayatPasienController::class, 'edit'])->name('dokter.edit-riwayat');
    Route::put('/dokter/update-riwayat/{riwayatPasien}', [RiwayatPasienController::class, 'update'])->name('dokter.update-riwayat');
    Route::delete('/dokter/hapus-riwayat/{riwayatPasien}', [RiwayatPasienController::class, 'destroy'])->name('dokter.hapus-riwayat');

    // 3. Pengaturan Akun Dokter
    Route::get('/dokter/pengaturan', [PengaturanDokterController::class, 'index'])->name('dokter.pengaturan');
    Route::put('/dokter/pengaturan/profile', [PengaturanDokterController::class, 'updateProfile'])->name('dokter.pengaturan.profile');
    Route::put('/dokter/pengaturan/password', [PengaturanDokterController::class, 'updatePassword'])->name('dokter.pengaturan.password');


    // ==========================================
    // ROUTE PETUGAS (TIDAK DIGANGGU)
    // ==========================================
    // Dashboard Petugas
    Route::get('/dashboardpetugas', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');

    // Input Data Pasien
    Route::get('/input-data-pasien', [PetugasController::class, 'create'])->name('petugas.input-data');
    Route::post('/input-data-pasien', [PetugasController::class, 'store'])->name('petugas.input-data.store');

    // Data Pasien
    Route::get('/data-pasien', [PetugasController::class, 'index'])->name('petugas.data-pasien');
    Route::get('/edit-pasien/{pasien}', [PetugasController::class, 'edit'])->name('petugas.edit-pasien');
    Route::put('/update-pasien/{pasien}', [PetugasController::class, 'update'])->name('petugas.update-pasien');
    Route::delete('/hapus-pasien/{pasien}', [PetugasController::class, 'destroy'])->name('petugas.hapus-pasien');

    // Jadwal Kontrol
    Route::get('/jadwal-kontrol', [PetugasController::class, 'jadwalKontrol'])->name('petugas.jadwal-kontrol');

    Route::get('/manajemen-user', [PetugasController::class, 'manajemenUser'])->name('petugas.manajemen-user');
    Route::put('/manajemen-user/{user}/approve', [PetugasController::class, 'approveUser'])->name('petugas.approve-user');
    Route::delete('/manajemen-user/{user}', [PetugasController::class, 'destroyUser'])->name('petugas.destroy-user');
    
    // Pengaturan Petugas (URL DIPISAHKAN SUPAYA TIDAK BENTROK DENGAN PASIEN)
    Route::get('/petugas/pengaturan', function () {
        return '<h1 class="text-center text-2xl mt-20">Halaman Pengaturan Petugas (Segera Dibuat)</h1>';
    })->name('petugas.pengaturan');
});

Route::get('/welcome', function () {
    return view('welcome');
});