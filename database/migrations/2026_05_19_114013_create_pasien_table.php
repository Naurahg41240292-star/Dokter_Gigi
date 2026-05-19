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
        Schema::create('pasiens', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nip')->unique();
        $table->date('tanggal_lahir')->nullable();
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
        $table->text('alamat')->nullable();
        $table->string('golongan_darah')->nullable();
        $table->string('riwayat_alergi')->nullable();
        $table->text('riwayat_penyakit')->nullable();
        $table->string('kontak_nama')->nullable();
        $table->string('kontak_hubungan')->nullable();
        $table->string('kontak_telepon')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};