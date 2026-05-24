<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pasien_id')->constrained()->onDelete('cascade'); // Relasi ke tabel pasiens
    $table->string('dokter');
    $table->date('tanggal_kunjungan');
    $table->text('keluhan')->nullable();
    $table->string('diagnosa')->nullable();
    $table->string('tindakan')->nullable();
    $table->string('resep_obat')->nullable();
     $table->enum('status', ['Menunggu Konfirmasi', 'Sedang Perawatan', 'Dalam Perawatan', 'Selesai']);
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};