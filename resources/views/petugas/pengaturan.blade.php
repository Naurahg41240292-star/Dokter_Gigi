<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - D'Smile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR KIRI (Warna Putih) -->
        <aside class="bg-white w-64 flex flex-col py-6 px-4 border-r border-gray-200 shadow-sm">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-4 mb-10">
                <!-- Ikon Gigi Sederhana (SVG) -->
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C9.24 2 7 4.24 7 7c0 1.63.78 3.09 2 4.01V22l3-3 3 3V11.01c1.22-.92 2-2.38 2-4.01 0-2.76-2.24-5-5-5z"/>
                </svg>
                <div>
                    <h1 class="text-xl font-bold leading-tight text-gray-800">D'Smile</h1>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Admin Panel</p>
                </div>
            </div>

            <!-- Menu Navigation -->
            <nav class="flex-1 space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    <span>Beranda</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    <span>Input Data Pasien</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    <span>Data Pasien</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    <span>Jadwal Kontrol</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    <span>Manajemen User</span>
                </a>
                
                <!-- Menu Pengaturan Aktif (Background Biru Muda & Teks Biru) -->
                <a href="{{ route('pengaturan.index') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 font-semibold rounded-lg transition">
                    <span>Pengaturan</span>
                </a>
            </nav>

            <!-- Menu Keluar -->
            <div class="mt-auto">
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-500 hover:bg-red-50 font-medium transition">
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header Atas -->
            <div class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800">Pengaturan</h2>
            </div>

            <!-- Layout 2 Kolom untuk Pengaturan (Sesuai Gambar 2) -->
            <div class="p-8 flex gap-8">
                
                <!-- Kolom Kiri: Menu Pengaturan -->
                <div class="w-1/4">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan</h3>
                        <ul class="space-y-1">
                            <li>
                                <a href="#" class="block px-4 py-3 rounded-lg bg-blue-50 text-blue-600 font-semibold transition">
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                                    Keamanan Akun
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                                    Privasi & Data
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                                    Bantuan & Dukungan
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Kolom Kanan: Kartu Pengaturan (Grid 2x2) -->
                <div class="w-3/4 grid grid-cols-2 gap-6">
                    
                    <!-- Kartu 1: Profil Saya -->
                    <a href="#" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Profil Saya</h4>
                            <p class="text-sm text-gray-500">Kelola informasi profil dan data pribadi Anda</p>
                        </div>
                        <div class="mt-4 text-right">
                            <span class="text-gray-400 group-hover:text-blue-600 transition">&rarr;</span>
                        </div>
                    </a>

                    <!-- Kartu 2: Keamanan Akun -->
                    <a href="#" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Keamanan Akun</h4>
                            <p class="text-sm text-gray-500">Atur kata sandi dan verifikasi dua langkah</p>
                        </div>
                        <div class="mt-4 text-right">
                            <span class="text-gray-400 group-hover:text-green-600 transition">&rarr;</span>
                        </div>
                    </a>

                    <!-- Kartu 3: Privasi & Data -->
                    <a href="#" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Privasi & Data</h4>
                            <p class="text-sm text-gray-500">Kelola data Anda dan preferensi privasi</p>
                        </div>
                        <div class="mt-4 text-right">
                            <span class="text-gray-400 group-hover:text-purple-600 transition">&rarr;</span>
                        </div>
                    </a>

                    <!-- Kartu 4: Bantuan & Dukungan -->
                    <a href="#" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Bantuan & Dukungan</h4>
                            <p class="text-sm text-gray-500">Dapatkan bantuan atau hubungi dukungan</p>
                        </div>
                        <div class="mt-4 text-right">
                            <span class="text-gray-400 group-hover:text-yellow-600 transition">&rarr;</span>
                        </div>
                    </a>

                </div>
            </div>
        </main>
    </div>

</body>
</html>