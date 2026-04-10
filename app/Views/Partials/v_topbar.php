<?php
// Partial: Topbar — bagian atas halaman berisi profil user, notifikasi, dan modal timeout sesi
$uri = service('uri');
$currentPage = $uri->getSegment(1);
?>
<header class="topbar">
    
    <!-- SPACER -->
    <div class="flex-grow-1"></div>

    <!-- ICONS & PROFILE -->
    <div class="topbar-actions">
    <!-- Tombol notifikasi (ikon lonceng) -->
        <div class="d-none d-md-flex align-items-center gap-1">
            <button class="topbar-icon-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
        </div>

        <!-- Dropdown profil user: menampilkan nama, role, dan tombol logout -->
        <div class="position-relative ms-2" id="profileDropdownContainer">
            <button onclick="toggleProfilDropdown()" class="profile-trigger">
                <div class="profile-avatar">
                    <span><?= strtoupper(substr(session()->get('user_name') ?? 'A', 0, 1)) ?></span>
                </div>
                <div class="profile-info d-none d-sm-block text-start">
                    <div class="profile-name"><?= esc(session()->get('user_name') ?? 'Admin') ?></div>
                    <div class="profile-role"><?= esc(session()->get('user_role') ?? 'admin') ?></div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;color:var(--slate-400)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Logout Dropdown -->
            <div id="logoutDropdown" class="profile-dropdown">
                <div class="profile-dropdown-header">
                    <p class="label mb-1">Akun Anda</p>
                    <p class="email mb-0"><?= esc(session()->get('user_email') ?? '') ?></p>
                </div>
                <div class="p-2 border-top" style="border-color: var(--slate-50) !important">
                    <button onclick="window.location.href='<?= base_url('logout') ?>'" class="logout-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- MODAL SESSION TIMEOUT -->
<div id="sessionModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);align-items:center;justify-content:center">
    <div style="background:#fff;border-radius:20px;padding:2.5rem;max-width:400px;width:90%;text-align:center;box-shadow:0 25px 50px rgba(0,0,0,0.2)">
        <div style="width:64px;height:64px;background:#fff7ed;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;color:#f97316" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <h5 style="font-weight:900;text-transform:uppercase;letter-spacing:.05em;color:#0f172a;margin-bottom:.5rem">Sesi Hampir Berakhir</h5>
        <p style="color:#64748b;font-size:14px;margin-bottom:1.5rem">Anda tidak aktif. Sesi akan otomatis berakhir dalam</p>
        <div id="sessionCountdown" style="font-size:3rem;font-weight:900;color:#f97316;line-height:1;margin-bottom:1.5rem">05:00</div>
        <div style="display:flex;gap:.75rem;justify-content:center">
            <button onclick="doLogout()" style="padding:.6rem 1.5rem;border-radius:10px;border:1px solid #e2e8f0;background:#f8fafc;font-weight:700;font-size:13px;text-transform:uppercase;cursor:pointer;color:#64748b">Logout</button>
            <button onclick="keepAlive()" style="padding:.6rem 1.5rem;border-radius:10px;border:none;background:#0061FF;color:#fff;font-weight:900;font-size:13px;text-transform:uppercase;cursor:pointer">Tetap Masuk</button>
        </div>
    </div>
</div>

<script>
    // Konfigurasi batas waktu idle dan durasi countdown (dalam detik)
    const IDLE_LIMIT   = 25 * 60; // 25 menit tidak aktif → tampilkan modal peringatan
    const WARNING_SECS = 5  * 60; // 5 menit countdown sebelum otomatis logout

    let idleTimer, countdownTimer, secondsLeft;
    let lastActivity = Date.now();

    // Reset timer idle setiap kali ada aktivitas dari user (mouse, keyboard, scroll, dll)
    ['mousemove','keydown','click','scroll','touchstart'].forEach(e =>
        document.addEventListener(e, resetIdle)
    );

    function resetIdle() {
        lastActivity = Date.now();
        if (document.getElementById('sessionModal').style.display === 'none') {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(showModal, IDLE_LIMIT * 1000);
        }
    }

    // Tampilkan modal peringatan sesi hampir habis dan mulai countdown
    function showModal() {
        secondsLeft = WARNING_SECS;
        document.getElementById('sessionModal').style.display = 'flex';
        updateCountdown();
        countdownTimer = setInterval(() => {
            secondsLeft--;
            updateCountdown();
            if (secondsLeft <= 0) {
                clearInterval(countdownTimer);
                doLogout();
            }
        }, 1000);
    }

    // Perbarui tampilan countdown di modal (format MM:SS)
    function updateCountdown() {
        const m = String(Math.floor(secondsLeft / 60)).padStart(2, '0');
        const s = String(secondsLeft % 60).padStart(2, '0');
        document.getElementById('sessionCountdown').textContent = m + ':' + s;
    }

    // Perpanjang sesi: tutup modal, kirim request keep-alive ke server, reset timer idle
    function keepAlive() {
        clearInterval(countdownTimer);
        document.getElementById('sessionModal').style.display = 'none';
        fetch('<?= base_url('keep-alive') ?>', { method: 'POST', headers: { 'X-CSRF-TOKEN': '<?= csrf_hash() ?>' } });
        resetIdle();
    }

    // Arahkan user ke halaman logout
    function doLogout() {
        window.location.href = '<?= base_url('logout') ?>';
    }

    // Mulai timer idle pertama kali saat halaman selesai dimuat
    idleTimer = setTimeout(showModal, IDLE_LIMIT * 1000);

    // Toggle dropdown profil saat tombol avatar diklik
    function toggleProfilDropdown() {
        const d = document.getElementById('logoutDropdown');
        d.classList.toggle('show');
    }
    // Tutup dropdown profil jika user klik di luar area dropdown
    window.addEventListener('click', function(e) {
        const c = document.getElementById('profileDropdownContainer');
        const d = document.getElementById('logoutDropdown');
        if (!c.contains(e.target)) d.classList.remove('show');
    });
</script>
