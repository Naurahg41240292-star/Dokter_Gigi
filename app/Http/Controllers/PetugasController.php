<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\NewAppointmentNotification;
use App\Notifications\AppointmentConfirmedNotification;

class PetugasController extends Controller
{
    // ================= BERANDA =================
      public function dashboard()
    {
        $today = Carbon::today();

        // STATISTIK KARTU
        $pasienHariIni = Appointment::whereDate('tanggal', $today)->count();
        $selesaiHariIni = Appointment::whereDate('tanggal', $today)->where('status', 'Selesai')->count();
        $totalPasien = Pasien::count();
        $dokterAktif = User::where('role', 'dokter')->count();
        
        // TABEL JADWAL HARI INI (5 Teratas)
        $jadwalHariIni = Appointment::whereDate('tanggal', $today)
                                ->with(['pasien', 'user']) // Eager load relasi
                                ->orderBy('waktu', 'asc')
                                ->take(5)
                                ->get();

        // PASIEN TERBARU (5 Teratas)
        $pasienTerbaru = Pasien::latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'pasienHariIni', 'selesaiHariIni',
            'totalPasien', 'dokterAktif','jadwalHariIni', 'pasienTerbaru'
        ));
    }
     public function jadwalKontrol()
    {
        $today = Carbon::today();

        // Statistik HARI INI
        $totalJanji = Appointment::whereDate('tanggal', $today)->count();
        $menunggu = Appointment::whereDate('tanggal', $today)->where('status', 'Menunggu Konfirmasi')->count();
        $sedangPeriksa = Appointment::whereDate('tanggal', $today)->where('status', 'Sedang Berjalan')->count();
        $selesai = Appointment::whereDate('tanggal', $today)->where('status', 'Selesai')->count();

        // Data Tabel: Tampilkan HARI INI dan MASA DEPAN (besok, lusa, dll)
        $appointments = Appointment::whereDate('tanggal', '>=', $today) // Diubah dari == menjadi >=
                            ->with(['pasien', 'user'])
                            ->orderBy('tanggal', 'asc') // Urutkan berdasarkan tanggal terdekat
                            ->orderBy('waktu', 'asc')
                            ->paginate(15);

        return view('petugas.jadwalkontrol', compact(
            'totalJanji', 'menunggu', 'sedangPeriksa', 'selesai', 'appointments'
        ));
    }

        // Method untuk AJAX notifikasi
    // Method untuk AJAX Notifikasi Dropdown
    public function getNotifikasi()
    {
        $today = Carbon::today();

        // Ambil 5 appointment terbaru yang butuh konfirmasi
        $pendingAppointments = Appointment::where('status', 'Menunggu Konfirmasi')
            ->whereDate('tanggal', '>=', $today)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $count = $pendingAppointments->count();

        // Render ke HTML khusus untuk di-inject ke dropdown via AJAX
        $html = '';
        foreach ($pendingAppointments as $ap) {
            $timeAgo = $ap->created_at->diffForHumans();
            $html .= '
                <a href="'.route('petugas.jadwal-kontrol').'" class="block px-5 py-3.5 hover:bg-slate-50 transition relative">
                    <div class="flex gap-3">
                        <div class="w-9 h-9 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-clock text-yellow-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">Appointment Baru</p>
                            <p class="text-[11px] text-slate-500 mt-0.5"><strong>' . $ap->nama_lengkap . '</strong> mendaftar untuk periksa.</p>
                            <p class="text-[10px] text-slate-400 mt-1.5 font-medium">' . $timeAgo . '</p>
                        </div>
                    </div>
                    <span class="absolute top-4 right-4 w-2 h-2 bg-yellow-500 rounded-full"></span>
                </a>
            ';
        }

        return response()->json([
            'count' => $count,
            'html' => $html
        ]);
    }
public function konfirmasiAppointment($id)
{
    try {
        // Cari appointment berdasarkan ID
        $appointment = Appointment::findOrFail($id);

        // Cegah konfirmasi ganda
        if ($appointment->status == 'Terjadwal') {
            return redirect()
                ->route('petugas.jadwal-kontrol')
                ->with('warning', 'Janji temu sudah dikonfirmasi sebelumnya.');
        }

        // Update status appointment
        $appointment->status = 'Terjadwal';
        $appointment->save();

        // Kirim notifikasi ke Pasien
        if ($appointment->user_id) {
            $pasienUser = User::find($appointment->user_id);
            if ($pasienUser) {
                $pasienUser->notify(new AppointmentConfirmedNotification(
                    $appointment->nama_lengkap, 
                    $appointment->tanggal,
                    'pasien' // Parameter ketiga untuk membedakan pesan dokter & pasien
                ));
            }
        }

        // Kirim notifikasi ke dokter
        if ($appointment->dokter_id) {
                $dokter = User::find($appointment->dokter_id);
                if ($dokter) {
                    $dokter->notify(new AppointmentConfirmedNotification(
                        $appointment->nama_lengkap, 
                        $appointment->tanggal
                    )); 
                } 
            } 

            // 4. Sinkronkan ke rekam medis
            $rekamMedis = RekamMedis::where('pasien_id', $appointment->pasien_id)
                                ->whereDate('tanggal_kunjungan', $appointment->tanggal)
                                ->first();

            if ($rekamMedis) {
                $rekamMedis->status = 'Terjadwal'; // Atau 'Sedang Berjalan' sesuaikan
                $rekamMedis->save();
            }

            return redirect()
                ->route('petugas.jadwal-kontrol')
                ->with('success', 'Janji temu berhasil dikonfirmasi dan diteruskan ke Dokter!');

        } catch (\Exception $e) {
            return redirect()
                ->route('petugas.jadwal-kontrol')
                ->with('error', 'Gagal mengkonfirmasi: ' . $e->getMessage());
        }
    }
    
    // ================= DATA PASIEN CRUD =================
    public function create()
    {
        $dokters = User::where('role', 'dokter')->get(); // Ambil data dokter
        return view('petugas.inputdata', compact('dokters')); // Kirim ke view
    }

    public function index()
    {
        try {
            $pasiens = Pasien::latest()->paginate(10);
            return view('petugas.datapasien', compact('pasiens'));
        } catch (\Exception $e) {
            dd("ERROR DATA PASIEN: " . $e->getMessage());
        }
    }

        public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tanggal_lahir' => 'required|date', // Wajib isi
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'required|string|max:13', // Wajib isi sesuai permintaanmu
            'email' => 'nullable|email', // Ditambahkan karena ada di form & model
            'alamat' => 'nullable|string',
            'golongan_darah' => 'nullable|string|max:10',
            'riwayat_alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'kontak_nama' => 'nullable|string',
            'kontak_hubungan' => 'nullable|string',
            'kontak_telepon' => 'nullable|string|max:13',
            'tanggal_appointment' => 'required|date',
            'waktu' => 'required',
            'dokter_id' => 'required|exists:users,id',
            'jenis_perawatan' => 'required|string',
            'keluhan' => 'nullable|string',
        ]);

        // 1. Cari pasien berdasarkan NIK, kalau tidak ada buat baru
        $pasien = Pasien::firstOrCreate(
            ['nik' => $validatedData['nik']], 
            $request->only([
                'nama', 'tanggal_lahir', 'jenis_kelamin', 'no_telepon', 'email', 'alamat', 
                'golongan_darah', 'riwayat_alergi', 'riwayat_penyakit', 
                'kontak_nama', 'kontak_hubungan', 'kontak_telepon'
            ])
        );

        // 2. Ambil Data Dokter langsung dari ID
        $dokterUser = User::findOrFail($request->dokter_id);
        $dokter_id = $dokterUser->id;
        $namaDokter = $dokterUser->name;
        // 3. Buat Rekam Medis Awal (Kode kamu sebelumnya, aku biarkan)
        $sudahAdaRM = RekamMedis::where('pasien_id', $pasien->id)
                            ->whereDate('tanggal_kunjungan', $request->tanggal_appointment)
                            ->exists();

        if (!$sudahAdaRM) {
            RekamMedis::create([
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokter_id,
                'dokter' => $namaDokter,
                'tanggal_kunjungan' => $request->tanggal_appointment, 
                'keluhan' => $request->keluhan, 
                'diagnosa' => null,
                'tindakan' => null,
                'resep_obat' => null,
                'status' => 'Menunggu Konfirmasi',
            ]);
        }

         
                   // 4. SIMPAN DATA APPOINTMENT
            Appointment::create([
                'pasien_id'    => $pasien->id,
                'dokter_id'    => $dokter_id,
                'user_id'      => auth()->id(),
                'dokter'       => $namaDokter, // Tambahkan ini
                // Data Pasien (Ambil langsung dari $request agar pasti terisi)
                'nik'          => $request->nik,                    
                'nama_lengkap' => $request->nama,                 
                'tgl_lahir'    => $request->tanggal_lahir,         
                'jenis_kelamin'=> $request->jenis_kelamin, 
                'no_telepon'   => $request->no_telepon,        // <--- PASTIKAN DARI $request
                'email'        => $request->email,
                'alamat'       => $request->alamat,
                'golongan_darah'=> $request->golongan_darah,
                'tekanan_darah' => $request->tekanan_darah,    // Ditambahkan dari dd()
                'alergi_obat'  => $request->riwayat_alergi,    
                'alergi_makanan' => $request->alergi_makanan,  // Ditambahkan dari dd()
                'obat_dikonsumsi' => $request->obat_dikonsumsi,// Ditambahkan dari dd()
                'riwayat_penyakit' => $request->riwayat_penyakit,
                
                // Kontak Darurat 
                'kontak_darurat_nama' => $request->kontak_nama,
                'kontak_darurat_hubungan' => $request->kontak_hubungan,
                'kontak_darurat_telepon' => $request->kontak_telepon,
                
                // Data Appointment
                'tanggal'      => $request->tanggal_appointment,
                'waktu'        => $request->waktu,
                'dokter'       => $namaDokter,
                'jenis_perawatan' => $request->jenis_perawatan,
                'keluhan'      => $request->keluhan,
                'status'       => 'Menunggu Konfirmasi',
            ]);

            // Kirim notifikasi ke semua user dengan role 'petugas'
        $petugasUsers = User::where('role', 'petugas')->get();
        foreach ($petugasUsers as $petugas) {
            $petugas->notify(new NewAppointmentNotification($request->nama, $request->tanggal_appointment));
        }

        return redirect()->route('petugas.input-data')->with('success', 'Data pasien berhasil disimpan!');
    
    } catch (\Exception $e) {
        dd("ERROR SIMPAN DATA: " . $e->getMessage());
    }
}
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('petugas.data-pasien')->with('success', 'Data pasien berhasil dihapus!');
    }

        // Fungsi untuk menampilkan halaman edit
    public function edit($id)
    {
        // Cari data pasien berdasarkan ID
        $pasien = Pasien::findOrFail($id);
        
        // Ambil rekam medis terakhir pasien ini (yang belum selesai)
        $rekamMedis = RekamMedis::where('pasien_id', $pasien->id)
                                ->where('status', '!=', 'Selesai')
                                ->latest()
                                ->first();

        // Kirim data ke view edit
        return view('petugas.editpasien', compact('pasien', 'rekamMedis'));
    }

    // Petugas melihat rekam medis yang sudah diisi Dokter
    public function lihatRekamMedis($id)
    {
        // Cari appointment berdasarkan ID
        $appointment = Appointment::findOrFail($id);

        // Cari rekam medis berdasarkan pasien dan tanggal appointment
        $rekamMedis = RekamMedis::where('pasien_id', $appointment->pasien_id)
            ->whereDate('tanggal_kunjungan', $appointment->tanggal)
            ->first();

       return view('petugas.lihat-rekam-medis', compact('appointment', 'rekamMedis'));
    }
    // Fungsi untuk menyimpan hasil edit
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'no_telepon' => 'nullable|string|max:13', // Sesuaikan dengan nama di form
            'golongan_darah' => 'nullable|string|max:10',
            'riwayat_alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'status_perawatan' => 'required|in:Menunggu Konfirmasi,Sedang Perawatan,Dalam Perawatan,Selesai',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
        ]);

        try {
            // 1. Update Data Pasien
            $pasien = Pasien::findOrFail($id);
            $pasien->nama = $request->nama;
            $pasien->nik = $request->nik;
            $pasien->no_telp = $request->no_telepon; // Tangkap dari name="no_telepon"
            $pasien->golongan_darah = $request->golongan_darah;
            $pasien->riwayat_alergi = $request->riwayat_alergi;
            $pasien->riwayat_penyakit = $request->riwayat_penyakit;
            $pasien->save();

            // 2. Update Data Rekam Medis (Jika ada)
            if ($request->filled('status_perawatan')) {
                $rekamMedis = RekamMedis::where('pasien_id', $pasien->id)
                                        ->where('status', '!=', 'Selesai')
                                        ->latest()
                                        ->first();

                if ($rekamMedis) {
                    $rekamMedis->dokter = $namaDokter;
                    $rekamMedis->status = $request->status_perawatan; // Dari form: status_perawatan
                    $rekamMedis->diagnosa = $request->diagnosa;
                    $rekamMedis->tindakan = $request->tindakan;
                    $rekamMedis->resep_obat = $request->resep_obat;
                    $rekamMedis->save();
                }
            }

            return redirect()->route('petugas.data-pasien')->with('success', 'Data pasien berhasil diperbarui!');

        } catch (\Exception $e) {
            dd("ERROR UPDATE: " . $e->getMessage());
        }
    }

    public function manajemenUser()
    {
        $users = User::whereIn('role', ['dokter', 'petugas'])->latest()->get();
        return view('petugas.manajemen-user', compact('users'));
    }

    public function approveUser(User $user)
    {
        $user->update(['status' => Status::Approved]);
        return redirect()->route('petugas.manajemen-user')->with('success', "User {$user->name} berhasil disetujui.");
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('petugas.manajemen-user')->with('success', "User {$user->name} berhasil dihapus.");
    }

    public function pengaturan()
    {
        return view('petugas.pengaturan');
    }
    // Fungsi untuk AJAX Polling Notifikasi
    public function getNotifications()
    {
        $user = auth()->user();
        
        // Ambil semua notifikasi yang belum dibaca
        $notifications = $user->unreadNotifications->map(function ($notif) {
        
            return [
                'id' => $notif->id,
                'pesan' => $notif->data['pesan'] ?? 'Notifikasi baru',
                'url' => $notif->data['url'] ?? '#',
                'waktu' => $notif->created_at->diffForHumans(), // Contoh: "5 menit yang lalu"
            ];
        });

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications
        ]);
    }

    // Fungsi untuk menandai notifikasi sudah dibaca (saat diklik)
    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    }
}