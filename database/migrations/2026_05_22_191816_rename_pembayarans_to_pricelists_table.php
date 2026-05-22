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
        // Ini akan mengubah nama tabel di database kamu
        Schema::rename('pembayarans', 'pricelists');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ini untuk rollback kalau kamu butuh balik ke nama lama
        Schema::rename('pricelists', 'pembayarans');
    }
};