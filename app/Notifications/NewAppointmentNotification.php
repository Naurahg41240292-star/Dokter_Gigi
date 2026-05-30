<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAppointmentNotification extends Notification
{
    use Queueable;

    public $pasienNama;
    public $tanggal;

    public function __construct($pasienNama, $tanggal)
    {
        $this->pasienNama = $pasienNama;
        $this->tanggal = $tanggal;
    }

    // Kita simpan notifikasi ke DATABASE (bukan email)
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Format data yang akan disimpan ke tabel notifications
    public function toDatabase(object $notifiable): array
    {
        return [
            'pesan' => "Pasien baru, {$this->pasienNama}, mendaftar janji temu pada {$this->tanggal}.",
            'url' => route('petugas.jadwal-kontrol'), // Tombol akan mengarahkan ke halaman ini
        ];
    }
}