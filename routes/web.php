<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pasien\PembayaranController;
use App\Http\Controllers\Pasien\AppointmentController;
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

    // ==========================================
    // REVISI: Dashboard Pasien sekarang memanggil Controller
    // ==========================================
    Route::get('/dashboardpasien', [AppointmentController::class, 'dashboard'])->name('pasien.dashboard');
    // ==========================================

    // ==========================================
    // ROUTE APPOINTMENT
    // ==========================================
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    // Ubah nama route dari appointment.cancel jadi appointment.update biar nyambung sama kode blade sebelumnya
    Route::put('/appointment/{id}', [AppointmentController::class, 'update'])->name('appointment.update');
    // Tambahkan route cancel ini
Route::post('/appointment/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
    // ==========================================

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

    // Dashboard Petugas (Menggunakan Controller)
    Route::get('/dashboardpetugas', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');

    // Input Data Pasien
    Route::get('/input-data-pasien', [PetugasController::class, 'create'])->name('petugas.input-data');
    Route::post('/input-data-pasien', [PetugasController::class, 'store'])->name('petugas.input-data.store');
    
    // Data Pasien
    Route::get('/data-pasien', [PetugasController::class, 'index'])->name('petugas.data-pasien');
    Route::get('/edit-pasien/{pasien}', [PetugasController::class, 'edit'])->name('petugas.edit-pasien');
    Route::put('/update-pasien/{pasien}', [PetugasController::class, 'update'])->name('petugas.update-pasien');
    Route::delete('/hapus-pasien/{pasien}', [PetugasController::class, 'destroy'])->name('petugas.hapus-pasien');


    // Route untuk Jadwal Kontrol
    Route::get('/jadwal-kontrol', [PetugasController::class, 'jadwalKontrol'])->name('petugas.jadwal-kontrol');

    // === ROUTE PLACEHOLDER (Sementara untuk menghilangkan error) ===
    // Nanti kalau halamannya sudah dibuat, baru kita ganti dengan Controller aslinya

    // Rekam Medis CRUD
    Route::get('/rekam-medis-petugas', [PetugasController::class, 'rmIndex'])->name('petugas.rekam-medis');
    Route::get('/tambah-rekam-medis', [PetugasController::class, 'rmCreate'])->name('petugas.tambah-rm');
    Route::post('/simpan-rekam-medis', [PetugasController::class, 'rmStore'])->name('petugas.simpan-rm');
    Route::get('/edit-rekam-medis/{rekamMedis}', [PetugasController::class, 'rmEdit'])->name('petugas.edit-rm');
    Route::put('/update-rekam-medis/{rekamMedis}', [PetugasController::class, 'rmUpdate'])->name('petugas.update-rm');
    Route::delete('/hapus-rekam-medis/{rekamMedis}', [PetugasController::class, 'rmDestroy'])->name('petugas.hapus-rm');

    Route::get('/keuangan', function () {
        return '<h1 class="text-center text-2xl mt-20">Halaman Keuangan (Segera Dibuat)</h1>';
    })->name('petugas.keuangan');

    Route::get('/pengaturan', function () {
        return '<h1 class="text-center text-2xl mt-20">Halaman Pengaturan (Segera Dibuat)</h1>';
    })->name('petugas.pengaturan');


    // Halaman appointment
    Route::get('/appointment', [AppointmentController::class, 'index'])
        ->name('pasien.appointment');

    // Simpan appointment
    Route::post('/appointment', [AppointmentController::class, 'store'])
        ->name('pasien.appointment.store');

    // API ambil data perawatan
    Route::get('/api/perawatan/{jenisId}', [AppointmentController::class, 'getPerawatan']);

    // Hapus appointment
    Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy'])
        ->name('pasien.appointment.destroy');


    Route::get('/riwayat-perawatan', function () {
        return view('pasien.riwayatperawatan');
    })->name('pasien.riwayat');

    Route::get('/artikel', function () {
        return view('pasien.artikel');
    })->name('pasien.artikel');


    Route::get('/pembayaran', [PembayaranController::class, 'index'])
        ->name('pembayaran.index');

    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])
        ->name('pembayaran.show');

});

Route::get('/welcome', function () {
    return view('welcome');
});