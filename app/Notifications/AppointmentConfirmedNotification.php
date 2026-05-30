<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentConfirmedNotification extends Notification
{
    use Queueable;

    public $pasienNama;
    public $tanggal;

    public function __construct($pasienNama, $tanggal)
    {
        $this->pasienNama = $pasienNama;
        $this->tanggal = $tanggal;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            // Pesan khusus untuk Dokter
            'pesan' => "Pasien {$this->pasienNama} sudah dikonfirmasi pada {$this->tanggal}. Siap diperiksa.",
            // Link mengarah ke halaman Dokter (sesuaikan nama routenya kalau beda)
            'url' => route('dokter.riwayat-pasien'), 
        ];
    }
}