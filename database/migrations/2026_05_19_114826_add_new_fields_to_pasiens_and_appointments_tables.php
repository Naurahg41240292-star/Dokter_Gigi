<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tambah kolom ke tabel pasiens
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nik');
            $table->string('no_telp')->nullable()->after('email');
            $table->string('tekanan_darah')->nullable()->after('riwayat_alergi');
            $table->string('alergi_makanan')->nullable()->after('tekanan_darah');
            $table->string('obat_dikonsumsi')->nullable()->after('alergi_makanan');
        });

        // 2. Tambah kolom ke tabel appointments
        Schema::table('appointments', function (Blueprint $table) {
            // Relasi ke pasien (karena petugas yang mendaftarkan)
            $table->foreignId('pasien_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            // Kolom waktu (jam kunjungan)
           //$table->time('waktu')->nullable()->after('tanggal');
        });
    }

    public function down()
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn(['email', 'no_telp', 'tekanan_darah', 'alergi_makanan', 'obat_dikonsumsi']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['pasien_id']);
            $table->dropColumn(['pasien_id']);
        });
    }
};