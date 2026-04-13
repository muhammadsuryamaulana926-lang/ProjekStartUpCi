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
                <div class="profile-dropdown-header py-3 px-4">
                    <div class="profile-name mb-1" style="font-size: 13px;"><?= esc(session()->get('user_name') ?? 'Admin') ?></div>
                    <div class="profile-email" style="font-size: 11px; opacity: 0.8;"><?= esc(session()->get('user_email') ?? 'admin@startup.id') ?></div>
                </div>
                <div class="p-2 border-top">
                    <button onclick="window.location.href='<?= base_url('logout') ?>'" class="logout-btn py-2">
                        <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- MODAL SESSION TIMEOUT -->
<div id="sessionModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(10px);align-items:center;justify-content:center;font-family:'Inter', sans-serif;">
    <div style="background:#fff;border-radius:24px;padding:3rem;max-width:440px;width:90%;text-align:center;box-shadow:0 30px 60px -12px rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.1);position:relative;overflow:hidden;">
        <!-- Background Subtle Pattern -->
        <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg, #6366f1, #a855f7);"></div>
        
        <div style="width:72px;height:72px;background:#fef2f2;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.75rem;transform:rotate(-5deg);">
            <i data-lucide="timer" style="width:36px;height:36px;color:#ef4444;"></i>
        </div>

        <h3 style="font-weight:800;color:#0f172a;margin-bottom:0.75rem;letter-spacing:-0.5px;font-size:24px;">Sesi Hampir Berakhir</h3>
        <p style="color:#64748b;font-size:15px;margin-bottom:2rem;line-height:1.6;">Anda telah tidak aktif cukup lama. Sesi Anda akan otomatis ditutup dalam waktu:</p>
        
        <div style="background:#f8fafc;padding:1.5rem;border-radius:20px;margin-bottom:2rem;border:1px solid #f1f5f9;">
            <div id="sessionCountdown" style="font-size:4rem;font-weight:900;color:#0f172a;line-height:1;font-variant-numeric: tabular-nums;letter-spacing:-2px;">05:00</div>
        </div>

        <div style="display:flex;flex-direction:column;gap:12px;">
            <button onclick="keepAlive()" style="width:100%;padding:1rem;border-radius:14px;border:none;background:#6366f1;color:#fff;font-weight:700;font-size:15px;cursor:pointer;transition:all 0.2s;box-shadow:0 10px 15px -3px rgba(99,102,241,0.3);" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">Tetap Masuk</button>
            <button onclick="doLogout()" style="width:100%;padding:1rem;border-radius:14px;border:1.5px solid #e2e8f0;background:transparent;font-weight:600;font-size:14px;cursor:pointer;color:#64748b;transition:all 0.2s;" onmouseover="this.style.background='#f8fafc';this.style.color='#0f172a'" onmouseout="this.style.background='transparent';this.style.color='#64748b'">Logout Sekarang</button>
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
        if(d.classList.contains('show')) lucide.createIcons();
    }
    // Tutup dropdown profil jika user klik di luar area dropdown
    window.addEventListener('click', function(e) {
        const c = document.getElementById('profileDropdownContainer');
        const d = document.getElementById('logoutDropdown');
        if (!c.contains(e.target)) d.classList.remove('show');
    });
</script>
