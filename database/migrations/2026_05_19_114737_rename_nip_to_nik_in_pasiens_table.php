<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pasiens', function (Blueprint $table) {
            // Ganti nama kolom dari 'nip' menjadi 'nik'
            $table->renameColumn('nip', 'nik');
        });
    }

    public function down()
    {
        Schema::table('pasiens', function (Blueprint $table) {
            // Untuk rollback jika diperlukan
            $table->renameColumn('nik', 'nip');
        });
    }
};