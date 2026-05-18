<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        
        // Relasi ke user/pasien (opsional tapi bagus punya)
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        // Data Pasien
        $table->string('nama_lengkap');
        $table->string('nik', 16);
        $table->date('tgl_lahir');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->string('no_telepon');
        $table->string('email')->nullable();
        $table->text('alamat');
        
        // Data Medis Awal
        $table->string('golongan_darah')->nullable();
        $table->string('tekanan_darah')->nullable();
        $table->string('alergi_obat')->nullable();
        $table->string('alergi_makanan')->nullable();
        $table->text('riwayat_penyakit')->nullable();
        $table->text('obat_dikonsumsi')->nullable();
        
        // Kontak Darurat
        $table->string('kontak_darurat_nama');
        $table->string('kontak_darurat_hubungan');
        $table->string('kontak_darurat_telepon');
        $table->string('kontak_darurat_alamat')->nullable();
        
        // Detail Appointment
        $table->date('tanggal');
        $table->string('waktu');
        $table->string('dokter');
        $table->string('jenis_perawatan');
        $table->text('keluhan')->nullable();
        
        // Status & Log
        $table->enum('status', ['Menunggu Konfirmasi', 'Terjadwal', 'Selesai', 'Dibatalkan'])->default('Menunggu Konfirmasi');
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
