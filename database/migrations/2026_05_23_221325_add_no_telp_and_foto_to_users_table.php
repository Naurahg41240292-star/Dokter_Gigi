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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom baru. Nullable() berarti boleh dikosongkan.
            $table->string('no_telp')->nullable()->after('email');
            $table->string('foto')->nullable()->after('no_telp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Untuk rollback jika suatu saat diperlukan
            $table->dropColumn(['no_telp', 'foto']);
        });
    }
};