<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to change the column to ENUM for MySQL. Adjust for other DBs if needed.
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('pasien','dokter','petugas') NOT NULL DEFAULT 'pasien'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `users` MODIFY `role` VARCHAR(255) NOT NULL DEFAULT 'pasien'");
    }
};
