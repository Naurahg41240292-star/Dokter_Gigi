<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\Status;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Make the demo seed idempotent so it can be rerun safely.
        User::updateOrCreate(
            ['email' => 'pasien@example.test'],
            [
                'name' => 'Pasien Demo',
                'phone' => '081234567890',
                'role' => Role::PASIEN,
                'status' => Status::APPROVED,
            ]
        );

        User::updateOrCreate(
            ['email' => 'dokter@example.test'],
            [
                'name' => 'Dokter Demo',
                'phone' => '081234567891',
                'role' => Role::DOKTER,
                'status' => Status::APPROVED,
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@example.test'],
            [
                'name' => 'Petugas Demo',
                'phone' => '081234567892',
                'role' => Role::PETUGAS,
                'status' => Status::APPROVED,
            ]
        );

        $this->call(PembayaranSeeder::class);
    }
}
