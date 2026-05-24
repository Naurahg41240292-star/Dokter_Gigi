<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
          public function up(): void
    {
        // 1. Tambah user_id ke pasiens
        if (!Schema::hasColumn('pasiens', 'user_id')) {
            Schema::table('pasiens', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            });
        }

        // 2. Tambah pasien_id & dokter_id ke appointments
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'pasien_id')) {
                $table->foreignId('pasien_id')->nullable()->after('user_id')->constrained('pasiens')->nullOnDelete();
            }
            if (!Schema::hasColumn('appointments', 'dokter_id')) {
                $table->foreignId('dokter_id')->nullable()->after('dokter')->constrained('users')->nullOnDelete();
            }
        });

        // 3. Tambah dokter_id ke rekam_medis (PERHATIKAN NAMA TABELNYA)
        if (Schema::hasTable('rekam_medis') && !Schema::hasColumn('rekam_medis', 'dokter_id')) {
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->foreignId('dokter_id')->nullable()->after('pasien_id')->constrained('users')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Sesuaikan juga di down()
        if (Schema::hasColumn('pasiens', 'user_id')) {
            Schema::table('pasiens', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'pasien_id')) {
                $table->dropForeign(['pasien_id']);
                $table->dropColumn('pasien_id');
            }
            if (Schema::hasColumn('appointments', 'dokter_id')) {
                $table->dropForeign(['dokter_id']);
                $table->dropColumn('dokter_id');
            }
        });

        if (Schema::hasTable('rekam_medis') && Schema::hasColumn('rekam_medis', 'dokter_id')) {
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->dropForeign(['dokter_id']);
                $table->dropColumn('dokter_id');
            });
        }
    }
};