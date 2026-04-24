<?php
// Partial: Topbar — bagian atas halaman berisi profil user, notifikasi, dan modal timeout sesi
$uri = service('uri');
$currentPage = $uri->getSegment(1);
$role = session()->get('user_role');

$notif_list  = [];
$notif_count = 0;
if (in_array($role, ['admin', 'pemilik_startup'])) {
    $m_notif     = new \App\Models\M_notifikasi();
    $notif_list  = $m_notif->semua_belum_dibaca($role);
    $notif_count = count($notif_list);
}
?>
<style>
.topbar {
    padding: 0 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f6f7f9; /* Soft light background matching the image */
    height: 80px;
    border-bottom: none;
    position: relative;
    z-index: 1000;
}
.topbar-nav {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 4px; /* Small gap between items */
    background: #ffffff;
    padding: 6px;
    border-radius: 9999px; /* Pill shape */
    box-shadow: 0 2px 10px rgba(0,0,0,0.015); /* Very subtle shadow */
}
.topbar-nav .top-nav-link-item {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    color: #64748b; /* Neutral greyish text */
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    border-radius: 9999px;
    transition: all 0.2s ease;
}
.topbar-nav .top-nav-link-item:hover {
    color: #3b82f6;
    background: #f8fafc;
}
.topbar-nav .top-nav-link-item.top-nav-active {
    background: #448aff; /* Bright blue for active */
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(68, 138, 255, 0.25);
}
.topbar-nav .top-nav-link-item.top-nav-active .nav-icon,
.topbar-nav .top-nav-link-item.top-nav-active svg {
    color: #ffffff;
}
.topbar-nav .nav-icon {
    width: 18px;
    height: 18px;
}
.topbar-nav .perpus-dropdown {
    position: relative;
    display: flex;
}
.topbar-nav .perpus-dropdown button.top-nav-link-item {
    border: none;
    background: transparent;
    cursor: pointer;
    font-family: inherit;
    outline: none;
}
.topbar-nav .perpus-dropdown button.top-nav-link-item.top-nav-active {
    background: #448aff;
    color: #ffffff;
}
.topbar-nav .perpus-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 12px);
    left: 50%;
    transform: translateX(-50%);
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    border: 1px solid #f1f5f9;
    min-width: 160px;
    overflow: hidden;
    z-index: 10001;
    padding: 8px;
}
.topbar-nav .perpus-dropdown-menu.show {
    display: block;
    animation: fadeInDropdown 0.2s ease-out forwards;
}
@keyframes fadeInDropdown {
    from { opacity: 0; transform: translate(-50%, -8px); }
    to { opacity: 1; transform: translate(-50%, 0); }
}
.topbar-nav .perpus-dropdown-menu a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.2s;
}
.topbar-nav .perpus-dropdown-menu a:hover {
    background: #eff6ff;
    color: #3b82f6;
}
.topbar-nav .perpus-dropdown-menu a svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

/* User Profile & Right Icons */
.topbar-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}
.topbar-icon-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    position: relative;
    color: #64748b;
    transition: all 0.2s ease;
}
.topbar-icon-btn:hover {
    color: #3b82f6;
    transform: translateY(-1px);
}
.topbar-icon-btn svg {
    width: 20px;
    height: 20px;
}
.topbar-icon-btn .notif-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 6px;
    height: 6px;
    background: #ef4444;
    border-radius: 50%;
    border: 1px solid #fff;
}
.profile-trigger {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    position: relative;
}
.profile-trigger .profile-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #475569;
    overflow: hidden;
}
.profile-trigger .profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

<header class="topbar">
    <!-- Brand / Logo -->
    <div class="topbar-brand" style="cursor:pointer;" onclick="window.location.href='<?= $role === 'pemilik_startup' ? base_url('v_detail_startup/' . session()->get('user_startup_uuid')) : base_url('v_dashboard') ?>'">
        <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK" style="height: 48px; width: auto;">
    </div>

    <!-- Navigation Menu (Centered) -->
    <nav class="topbar-nav">
        <?php if ($role === 'pemilik_startup'): ?>
            <a href="<?= base_url('v_detail_startup/' . session()->get('user_startup_uuid')) ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_detail_startup' || $currentPage == 'v_detail') ? 'top-nav-active' : '' ?>">
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
                <button onclick="togglePerpusDropdown(event)" class="top-nav-link-item <?= in_array($currentPage, ['v_perpustakaan', 'perpustakaan']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                    <span>Perpustakaan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu" id="perpusDropdownMenu1">
                    <a href="<?= base_url('v_perpustakaan') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Buku Digital
                    </a>
                    <a href="<?= base_url('perpustakaan/video') ?>">
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
            <!-- Link Program Kelas untuk Pemilik Startup -->
            <a href="<?= base_url('program') ?>"
               class="top-nav-link-item <?= ($currentPage == 'program') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Program</span>
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
                <button onclick="togglePerpusDropdown(event)" class="top-nav-link-item <?= in_array($currentPage, ['v_perpustakaan', 'perpustakaan']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                    <span>Perpustakaan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu" id="perpusDropdownMenu">
                    <a href="<?= base_url('v_perpustakaan') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Buku Digital
                    </a>
                    <a href="<?= base_url('perpustakaan/video') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        Video
                    </a>
                </div>
            </div>
            <a href="<?= base_url('v_riwayat_aktivitas') ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_riwayat_aktivitas') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Riwayat</span>
            </a>
            <a href="<?= base_url('v_lokasi_startup') ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_lokasi_startup') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7"/>
                </svg>
                <span>Peta Lokasi</span>
            </a>
            <!-- Link Program Kelas untuk Admin -->
            <a href="<?= base_url('program') ?>"
               class="top-nav-link-item <?= ($currentPage == 'program') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Program Kelas</span>
            </a>

        <?php endif; ?>
    </nav>

    <!-- ICONS & PROFILE -->
    <div class="topbar-actions">
        <!-- Search Button -->
        <!-- <button class="topbar-icon-btn d-none d-md-flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button> -->

        <!-- Notification Button -->
        <div class="dropdown" id="notifDropdownContainer">
            <button class="topbar-icon-btn" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <?php if ($notif_count > 0): ?>
                <div class="notif-badge"></div>
                <?php endif; ?>
                <i class="mdi mdi-bell-outline" style="font-size:20px;"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow-sm border" style="min-width:320px; padding:0; border-radius:4px;" id="notifDropdown">
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                    <span class="fw-semibold">Notifikasi</span>
                    <?php if ($notif_count > 0): ?>
                    <button onclick="tandaiSemuaDibaca()" class="btn btn-link btn-sm p-0 text-decoration-none">Tandai semua dibaca</button>
                    <?php endif; ?>
                </div>
                <div style="max-height:320px; overflow-y:auto;" id="notifList">
                    <?php if (empty($notif_list)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="mdi mdi-bell-off-outline d-block mb-2" style="font-size:28px;"></i>
                        <small>Tidak ada notifikasi baru</small>
                    </div>
                    <?php else: ?>
                    <?php foreach ($notif_list as $n): ?>
                    <div class="notif-item dropdown-item px-3 py-2 border-bottom cursor-pointer" id="notif-<?= $n['id_notifikasi'] ?>" onclick="bukaNotif(<?= $n['id_notifikasi'] ?>, '<?= esc($n['url'] ?? '') ?>')" style="cursor:pointer; white-space:normal;">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="mdi mdi-account-plus-outline text-primary mt-1" style="font-size:18px; flex-shrink:0;"></i>
                            <div>
                                <div class="fw-semibold small"><?= esc($n['judul']) ?></div>
                                <div class="text-muted small"><?= esc($n['pesan']) ?></div>
                                <div class="text-muted" style="font-size:11px;"><?= date('d M Y, H:i', strtotime($n['dibuat_pada'])) ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="position-relative ms-2" id="profileDropdownContainer">
            <button class="dropdown-toggle profile-trigger" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <div class="profile-avatar">
                    <span><?= strtoupper(substr(session()->get('user_name') ?? 'A', 0, 1)) ?></span>
                </div>
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow-sm border" style="min-width:320px; border-radius:4px; padding:0;">
                <div class="px-3 py-2 border-bottom">
                    <div class="fw-semibold small"><?= esc(session()->get('user_name') ?? 'Admin') ?></div>
                    <div class="text-muted" style="font-size:11px;"><?= esc(session()->get('user_email') ?? 'admin@startup.id') ?></div>
                </div>
                <div class="p-1">
                    <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger d-flex align-items-center gap-2 rounded">
                        <i class="mdi mdi-logout" style="font-size:16px;"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Wrapper konten utama -->
<div class="app-main" style="border-radius: 0;">

<!-- MODAL SESSION TIMEOUT -->
<div class="modal fade" id="sessionModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center" style="border-radius:8px;border:1px solid #e0e0e0;">
            <div class="modal-body p-4">
                <div class="mb-3">
                    <i class="mdi mdi-timer-outline text-danger" style="font-size:48px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Sesi Hampir Berakhir</h5>
                <p class="text-muted mb-3">Anda telah tidak aktif cukup lama. Sesi akan otomatis ditutup dalam:</p>
                <div class="bg-light rounded p-3 mb-4">
                    <div id="sessionCountdown" class="fw-bold" style="font-size:3rem;letter-spacing:2px;">05:00</div>
                </div>
                <div class="d-grid gap-2">
                    <button onclick="keepAlive()" class="btn btn-primary btn-modern">Tetap Masuk</button>
                    <button onclick="doLogout()" class="btn btn-light btn-modern border">Logout Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const IDLE_LIMIT   = 10 * 60;
    const WARNING_SECS = 2  * 60;

    let idleTimer, countdownTimer, secondsLeft;
    let lastActivity = Date.now();

    ['mousemove','keydown','click','scroll','touchstart'].forEach(e =>
        document.addEventListener(e, resetIdle)
    );

    function resetIdle() {
        lastActivity = Date.now();
        var modalEl = document.getElementById('sessionModal');
        if (!modalEl.classList.contains('show')) {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(showModal, IDLE_LIMIT * 1000);
        }
    }

    function showModal() {
        secondsLeft = WARNING_SECS;
        var modal = new bootstrap.Modal(document.getElementById('sessionModal'));
        modal.show();
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

    function updateCountdown() {
        const m = String(Math.floor(secondsLeft / 60)).padStart(2, '0');
        const s = String(secondsLeft % 60).padStart(2, '0');
        document.getElementById('sessionCountdown').textContent = m + ':' + s;
    }

    function keepAlive() {
        clearInterval(countdownTimer);
        bootstrap.Modal.getInstance(document.getElementById('sessionModal')).hide();
        fetch('<?= base_url('keep-alive') ?>', { method: 'POST', headers: { 'X-CSRF-TOKEN': '<?= csrf_hash() ?>' } });
        resetIdle();
    }

    function doLogout() {
        window.location.href = '<?= base_url('logout') ?>';
    }

    idleTimer = setTimeout(showModal, IDLE_LIMIT * 1000);

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

    function toggleProfilDropdown() {}
    window.addEventListener('click', function(e) {
        const c = document.getElementById('profileDropdownContainer');
        if (c && !c.contains(e.target)) {}
    });

    function toggleNotifDropdown() {}
    window.addEventListener('click', function(e) {
        const c = document.getElementById('notifDropdownContainer');
        const d = document.getElementById('notifDropdown');
        if (c && d && !c.contains(e.target)) d.classList.remove('show');
    });

    const NOTIF_CSRF = '<?= csrf_hash() ?>';
    const NOTIF_CSRF_NAME = '<?= csrf_token() ?>';

    function bukaNotif(id, url) {
        fetch('<?= base_url('notifikasi/tandai_dibaca') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id_notifikasi=' + id + '&' + NOTIF_CSRF_NAME + '=' + NOTIF_CSRF
        }).then(function() {
            var el = document.getElementById('notif-' + id);
            if (el) el.remove();
            var badge = document.querySelector('.notif-badge');
            var remaining = document.querySelectorAll('.notif-item').length;
            if (remaining === 0) {
                if (badge) badge.remove();
                document.getElementById('notifList').innerHTML = '<div class="text-center text-muted py-4"><i class="mdi mdi-bell-off-outline d-block mb-2" style="font-size:28px;"></i><small>Tidak ada notifikasi baru</small></div>';
            }
            if (url) window.location.href = url;
        });
    }

    function tandaiSemuaDibaca() {
        fetch('<?= base_url('notifikasi/tandai_semua') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: NOTIF_CSRF_NAME + '=' + NOTIF_CSRF
        }).then(function() {
            var badge = document.querySelector('.notif-badge');
            if (badge) badge.remove();
            document.getElementById('notifList').innerHTML = '<div class="text-center text-muted py-4"><i class="mdi mdi-bell-off-outline d-block mb-2" style="font-size:28px;"></i><small>Tidak ada notifikasi baru</small></div>';
            var dd = bootstrap.Dropdown.getInstance(document.querySelector('#notifDropdownContainer [data-bs-toggle="dropdown"]'));
            if (dd) dd.hide();
        });
    }
</script>
