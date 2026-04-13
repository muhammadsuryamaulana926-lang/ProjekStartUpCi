<?php
// Partial: Topbar — bagian atas halaman berisi profil user, notifikasi, dan modal timeout sesi
$uri = service('uri');
$currentPage = $uri->getSegment(1);
$role = session()->get('user_role');
?>
<style>
.topbar {
    padding: 0 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    height: 80px;
    border-bottom: 1px solid var(--slate-50);
    position: relative;
}
.topbar-nav {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 12px;
}
.topbar-nav .top-nav-link-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    color: var(--slate-500);
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
    border-radius: 12px;
    transition: all 0.3s ease;
}
.topbar-nav .top-nav-link-item:hover {
    background: var(--slate-50);
    color: var(--primary);
    transform: translateY(-2px);
}
.topbar-nav .top-nav-link-item.top-nav-active {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 4px 12px rgba(0, 97, 255, 0.2);
}
.topbar-nav .top-nav-link-item.top-nav-active .nav-icon {
    color: #fff;
}
.topbar-nav .nav-icon {
    width: 18px;
    height: 18px;
}
.topbar-nav .perpus-dropdown button.top-nav-link-item {
    border: none;
    background: transparent;
    cursor: pointer;
}
.topbar-nav .perpus-dropdown button.top-nav-link-item.top-nav-active {
    background: var(--primary);
    color: #fff;
}
.topbar-nav .perpus-dropdown {
    position: relative;
}
.topbar-nav .perpus-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    border: 1px solid var(--slate-100);
    min-width: 160px;
    overflow: hidden;
    z-index: 999;
}
.topbar-nav .perpus-dropdown-menu.show {
    display: block;
}
.topbar-nav .perpus-dropdown-menu a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    font-size: 13px;
    font-weight: 600;
    color: var(--slate-600);
    text-decoration: none;
    transition: all 0.2s;
}
.topbar-nav .perpus-dropdown-menu a:hover {
    background: var(--slate-50);
    color: var(--primary);
}
.topbar-nav .perpus-dropdown-menu a svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}
</style>

<header class="topbar">
    <!-- Brand / Logo -->
    <div class="topbar-brand">
        <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK" style="height: 48px; width: auto;">
    </div>

    <!-- Navigation Menu (Centered) -->
    <nav class="topbar-nav">
        <?php if ($role === 'pemilik_startup'): ?>
            <a href="<?= base_url('v_detail/' . session()->get('user_startup_uuid')) ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_detail') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Startup Saya</span>
            </a>
            <a href="<?= base_url('v_edit_startup/' . session()->get('user_startup_uuid')) ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_edit_startup') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Edit Startup</span>
            </a>
            <div class="perpus-dropdown">
                <button onclick="togglePerpusDropdown(event)" class="top-nav-link-item <?= in_array($currentPage, ['v_perpustakaan', 'v_video', 'v_buku']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                    <span>Perpustakaan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu" id="perpusDropdownMenu1">
                    <a href="<?= base_url('v_perpustakaan') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Ebook
                    </a>
                    <a href="<?= base_url('v_perpustakaan') ?>?tab=video">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        Video
                    </a>
                </div>
            </div>
            <a href="<?= base_url('v_lokasi_startup_saya') ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_lokasi_startup_saya') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7"/>
                </svg>
                <span>Peta Lokasi</span>
            </a>
        <?php else: ?>
            <a href="<?= base_url('v_dashboard') ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_dashboard') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="<?= base_url('v_data_startup') ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_data_startup') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Data Startup</span>
            </a>
            <div class="perpus-dropdown">
                <button onclick="togglePerpusDropdown(event)" class="top-nav-link-item <?= in_array($currentPage, ['v_perpustakaan', 'v_video', 'v_buku']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                    <span>Perpustakaan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu" id="perpusDropdownMenu">
                    <a href="<?= base_url('v_perpustakaan') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Ebook
                    </a>
                    <a href="<?= base_url('v_perpustakaan') ?>?tab=video">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        Video
                    </a>
                </div>
            </div>
            <a href="<?= base_url('v_history') ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_history') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Riwayat</span>
            </a>
            <a href="<?= base_url('v_detail_lokasi_startup') ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_detail_lokasi_startup') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7"/>
                </svg>
                <span>Peta Lokasi</span>
            </a>
        <?php endif; ?>
    </nav>

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

    // Toggle dropdown perpustakaan
    function togglePerpusDropdown(e) {
        e.stopPropagation();
        var m = document.getElementById('perpusDropdownMenu') || document.getElementById('perpusDropdownMenu1');
        if (m) m.classList.toggle('show');
    }
    window.addEventListener('click', function() {
        ['perpusDropdownMenu','perpusDropdownMenu1'].forEach(function(id) {
            var m = document.getElementById(id);
            if (m) m.classList.remove('show');
        });
    });

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
