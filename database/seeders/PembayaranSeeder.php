<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'pasien@example.test')->first();

        if (! $user) {
            return;
        }

        Pembayaran::updateOrCreate(
            ['invoice_number' => 'INV-2026-00001'],
            [
                'user_id' => $user->id,
                'amount' => 500000.00,
                'description' => 'Scaling Gigi Rutin',
                'status' => 'pending',
                'payment_method' => null,
                'payment_date' => null,
                'notes' => 'Pembayaran untuk pemeriksaan dan scaling gigi',
            ]
        );

        Pembayaran::updateOrCreate(
            ['invoice_number' => 'INV-2026-00002'],
            [
                'user_id' => $user->id,
                'amount' => 750000.00,
                'description' => 'Konsultasi Ortodonti',
                'status' => 'confirmed',
                'payment_method' => 'Transfer Bank',
                'payment_date' => now(),
                'notes' => 'Pembayaran untuk konsultasi ortodonti',
            ]
        );

        Pembayaran::updateOrCreate(
            ['invoice_number' => 'INV-2026-00003'],
            [
                'user_id' => $user->id,
                'amount' => 1500000.00,
                'description' => 'Perawatan Filling',
                'status' => 'completed',
                'payment_method' => 'Kartu Kredit',
                'payment_date' => now()->subDays(5),
                'notes' => 'Pembayaran untuk perawatan filling gigi berlubang',
            ]
        );
    }
}
