<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
   public function index()
    {
        return view('landing.index'); // Ini merujuk ke file yang kita bikin di step 1
    }
    public function showLayanan($slug)
    {
    $layanans = [
        'behel-gigi' => [
            'title' => 'Behel Gigi (Ortodonti)',
            'icon' => 'fas fa-teeth-open',
            'description' => 'Layanan perapian gigi menggunakan kawat gigi konvensional atau clear aligner. Dapatkan senyum yang rapi dan percaya diri dengan perawatan dari dokter spesialis ortodonti kami.',
            'image' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?q=80&w=800&auto=format&fit=crop'
        ],
        'bleaching-gigi' => [
            'title' => 'Bleaching Gigi (Pemutihan)',
            'icon' => 'fas fa-sun',
            'description' => 'Ingin gigi seputih mutiara? Layanan bleaching kami menggunakan bahan aman dan teknologi terkini untuk mengembangkan warna alami gigi Anda tanpa merusak enamel.',
            'image' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?q=80&w=800&auto=format&fit=crop'
        ],
        'gigi-tiruan' => [
            'title' => 'Gigi Tiruan (Prosthodonti)',
            'icon' => 'fas fa-teeth',
            'description' => 'Solusi gigi palsu (gigi tiruan) untuk mengembalikan fungsi mengunyah dan keindahan senyum Anda. Tersedia gigi tiruan lepas maupun tiruan cekat (implan).',
            'image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?q=80&w=800&auto=format&fit=crop'
        ],
        'gum-lifting' => [
            'title' => 'Gum Lifting (Crown Lengthening)',
            'icon' => 'fas fa-hand-holding-medical',
            'description' => 'Perbaikan kontur gusi yang terlalu banyak menutupi gigi (gummy smile). Prosedur ini membuat proporsi gigi dan gusi menjadi lebih harmonis.',
            'image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=800&auto=format&fit=crop'
        ],
        'veneer' => [
            'title' => 'Veneer Gigi',
            'icon' => 'fas fa-gem',
            'description' => 'Lapisan tipis berbahan porselen atau resin yang ditempelkan pada permukaan depan gigi. Solusi cepat untuk gigi rusak, menguning, atau bentuk tidak rata.',
            'image' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?q=80&w=800&auto=format&fit=crop'
        ],
        'tambal-gigi' => [
            'title' => 'Tambal Gigi (Restorasi)',
            'icon' => 'fas fa-tooth',
            'description' => 'Perbaikan gigi yang berlubang atau rusak dengan material tambal berkualitas tinggi yang warnanya menyerupai gigi asli sehingga terlihat natural.',
            'image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?q=80&w=800&auto=format&fit=crop'
        ],
        'pencabutan-gigi' => [
            'title' => 'Pencabutan Gigi (Ekstraksi)',
            'icon' => 'fas fa-hand-scissors',
            'description' => 'Prosedur pencabutan gigi yang bermasalah (seperti gigi bungsu) dengan teknik modern, minim rasa sakit, dan proses penyembuhan yang cepat.',
            'image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=800&auto=format&fit=crop'
        ],
        'scaling-gigi' => [
            'title' => 'Scaling Gigi (Pembersihan)',
            'icon' => 'fas fa-broom',
            'description' => 'Pembersihan karang gigi dan plak secara menyeluruh menggunakan alat ultrasonik. Penting untuk mencegah penyakit gusi dan bau mulut.',
            'image' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?q=80&w=800&auto=format&fit=crop'
        ]
    ];

        abort_if(!isset($layanans[$slug]), 404);

            $layanan = $layanans[$slug];

        return view('landing.detail', compact('layanan'));
    }
}
