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
        Schema::create('riwayat_pasien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade'); // Relasi ke tabel pasien
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel user (dokter)
            $table->date('tanggal_periksa');
            $table->text('diagnosa_tindakan');
            $table->text('resep_obat')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pasien');
    }
};
