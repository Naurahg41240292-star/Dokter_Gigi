<script>
    // Logika Buka/Tutup Dropdown
    const notifBtn = document.getElementById('notif-btn');
    const notifDropdown = document.getElementById('notif-dropdown');
    
    if(notifBtn) {
        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notifDropdown.classList.toggle('show');
        });
        document.addEventListener('click', (e) => {
            if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
                notifDropdown.classList.remove('show');
            }
        });
    }

    // Logika Polling AJAX (Cek notif tiap 10 detik)
    function fetchNotifications() {
        fetch('{{ route("petugas.notifikasi") }}')
            .then(response => response.json())
            .then(data => {
                const dot = document.getElementById('notif-dot');
                const list = document.getElementById('notif-list');
                
                // Cek dulu ada tidak elemennya di halaman ini
                if (dot && list) {
                    if (data.count > 0) {
                        dot.classList.remove('hidden');
                        list.innerHTML = data.html;
                    } else {
                        dot.classList.add('hidden');
                        list.innerHTML = '<div class="px-5 py-6 text-center text-slate-400 text-xs">Tidak ada notifikasi baru</div>';
                    }
                }
            });
    }

    // Panggil saat pertama kali load
    fetchNotifications();
    // Ulangi setiap 10 detik (10000ms)
    setInterval(fetchNotifications, 10000);
</script>