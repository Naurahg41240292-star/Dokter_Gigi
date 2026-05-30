<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const notifBtn = document.getElementById('notif-btn');
        const notifDropdown = document.getElementById('notif-dropdown');
        const notifDot = document.getElementById('notif-dot');
        const notifList = document.getElementById('notif-list');

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

        function fetchNotifications() {
            // Ambil token dari meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route("petugas.notifikasi") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,      // <--- INI KUNCINYA AGAR TIDAK 403
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Kalau masih 403, lempar error biar ketangkap di catch
                    throw new Error('HTTP status ' + response.status);
                }
                return response.json();
            })
                        .then(data => {
                if(notifDot && notifList) {
                    if (data.count > 0) {
                        notifDot.classList.remove('hidden'); 
                        notifDot.style.display = 'flex';     
                        
                        // INI DIA KUNCINYA: Langsung pakai data.html dari controller!
                        notifList.innerHTML = data.html;

                    } else {
                        notifDot.classList.add('hidden'); 
                        notifDot.style.display = 'none';  
                        notifList.innerHTML = '<div class="px-5 py-6 text-center text-slate-400 text-xs"><i class="fas fa-bell-slash text-2xl mb-2 block"></i>Tidak ada notifikasi baru</div>';
                    }
                }
            })
            .catch(error => {
                console.warn('Gagal memuat notifikasi:', error.message);
            });
        }

        fetchNotifications();
        setInterval(fetchNotifications, 10000);

    });
</script>