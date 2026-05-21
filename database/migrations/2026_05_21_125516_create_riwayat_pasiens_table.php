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
        Schema::create('riwayat_pasiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade'); // Sesuaikan nama tabel pasienmu
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade'); // Asumsi dokter login di tabel users
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
        Schema::dropIfExists('riwayat_pasiens');
    }
};
