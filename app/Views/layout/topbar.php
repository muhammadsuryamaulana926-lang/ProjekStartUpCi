<?php
// Partial: Topbar — bagian atas halaman berisi profil user, notifikasi, dan modal timeout sesi
$uri = service('uri');
$currentPage = $uri->getSegment(1);
$role = session()->get('user_role');

$notif_list  = [];
$notif_count = 0;
if (in_array($role, ['admin', 'pemilik_startup', 'pemateri'])) {
    $m_notif     = new \App\Models\M_notifikasi();
    $notif_list  = $m_notif->semua_belum_dibaca($role);
    $notif_count = count($notif_list);
}
?>
<style>
.topbar {
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f6f7f9;
    height: 56px;
    border-bottom: none;
    position: relative;
    z-index: 1000;
}
.topbar-inner {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 0.75rem;
}
@media (min-width: 1200px) {
    .topbar-inner {
        width: 91.6667%;
        margin: 0 auto;
        padding: 0;
    }
}
.topbar-nav {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 2px;
    background: #ffffff;
    padding: 4px;
    border-radius: 9999px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    white-space: nowrap;
}
.topbar-nav .top-nav-link-item {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    color: #64748b;
    text-decoration: none;
    font-weight: 600;
    font-size: 12.5px;
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
.topbar-nav .perpus-dropdown:hover .perpus-dropdown-menu {
    display: block;
    animation: fadeInDropdown 0.2s ease-out forwards;
}
.topbar-nav .perpus-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 4px);
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
/* Jembatan hover antara button dan dropdown agar tidak hilang saat cursor bergerak */
.topbar-nav .perpus-dropdown::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    height: 12px;
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
/* Role badge */
.role-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 9999px;
    background: #e2e8f0;
    border: 1.5px solid #cbd5e1;
    font-size: 11.5px;
    font-weight: 600;
    color: #475569;
    letter-spacing: 0.3px;
    white-space: nowrap;
}
</style>

<header class="topbar">
<div class="topbar-inner">
    <!-- Brand / Logo -->
    <div class="d-flex align-items-center gap-3">
        <div class="topbar-brand" style="cursor:pointer;" onclick="window.location.href='<?= ($role === 'pemilik_startup' && !session()->get('is_peserta_program')) ? base_url('v_detail_startup/' . session()->get('user_startup_uuid')) : ($role === 'pemilik_startup' ? base_url('program') : base_url('v_dashboard')) ?>'">
            <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK" style="height: 48px; width: auto;">
        </div>
        <?php
            $role_label = [
                'superadmin'     => 'Super Admin',
                'admin'          => 'Admin',
                'pemateri'       => 'Pemateri',
                'pemilik_startup'=> 'Pemilik Startup',
            ];
            $label = $role_label[$role] ?? ucfirst($role ?? 'User');
            if (session()->get('is_peserta_program') && $role !== 'pemilik_startup') $label = 'Peserta Program';
        ?>
        <span class="role-badge"><?= esc($label) ?></span>
    </div>

    <!-- Navigation Menu (Centered) -->
    <nav class="topbar-nav">
        <?php
        $is_peserta = session()->get('is_peserta_program') && $role !== 'pemilik_startup';
        ?>
        <?php if ($is_peserta): ?>
            <!-- Peserta Program: hanya Program dan Perpustakaan -->
            <a href="<?= base_url('program') ?>"
               class="top-nav-link-item <?= ($currentPage == 'program') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Program</span>
            </a>
            <div class="perpus-dropdown">
                <button class="top-nav-link-item <?= in_array($currentPage, ['v_perpustakaan', 'perpustakaan']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                    <span>Perpustakaan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu">
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

        <?php elseif ($role === 'pemateri'): ?>
            <!-- Pemateri: hanya Dashboard dan Kalender -->
            <a href="<?= base_url('v_dashboard') ?>"
               class="top-nav-link-item <?= ($currentPage == 'v_dashboard') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="<?= base_url('jadwal_kelas') ?>"
               class="top-nav-link-item <?= ($currentPage == 'jadwal_kelas') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Kalender</span>
            </a>

        <?php elseif ($role === 'pemilik_startup'): ?>
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
                <button class="top-nav-link-item <?= in_array($currentPage, ['v_perpustakaan', 'perpustakaan']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                    <span>Perpustakaan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu">
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
            <div class="perpus-dropdown">
                <button class="top-nav-link-item <?= in_array($currentPage, ['v_lokasi_startup_saya', 'v_globe']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7"/>
                    </svg>
                    <span>Peta Lokasi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu">
                    <a href="<?= base_url('v_lokasi_startup_saya') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Peta Lokal
                    </a>
                    <a href="<?= base_url('v_globe') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Globe Global
                    </a>
                </div>
            </div>
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
                <button class="top-nav-link-item <?= in_array($currentPage, ['v_perpustakaan', 'perpustakaan']) ? 'top-nav-active' : '' ?>">
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
            <div class="perpus-dropdown">
                <button class="top-nav-link-item <?= in_array($currentPage, ['v_lokasi_startup', 'v_globe']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7"/>
                    </svg>
                    <span>Peta Lokasi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu" id="petaDropdownAdmin">
                    <a href="<?= base_url('v_lokasi_startup') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Peta Lokal
                    </a>
                    <a href="<?= base_url('v_globe') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Globe Global
                    </a>
                </div>
            </div>
            <a href="<?= base_url('program') ?>"
               class="top-nav-link-item <?= ($currentPage == 'program') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Program Kelas</span>
            </a>
            <a href="<?= base_url('jadwal_kelas') ?>"
               class="top-nav-link-item <?= ($currentPage == 'jadwal_kelas') ? 'top-nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Kalender</span>
            </a>
            <div class="perpus-dropdown">
                <button class="top-nav-link-item <?= in_array($currentPage, ['log_aktivitas', 'aktivitas_login', 'manajemen_user']) ? 'top-nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Pengaturan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="perpus-dropdown-menu" id="pengaturanDropdown">
                    <a href="<?= base_url('aktivitas_login') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Aktivitas Login
                    </a>
                    <a href="<?= base_url('log_aktivitas') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Log Aktivitas
                    </a>
                    <a href="<?= base_url('manajemen_user') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Manajemen User
                    </a>
                </div>
            </div>

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

        <!-- Log Aktivitas & Manajemen (khusus admin/superadmin) -->
        <?php if (in_array($role, ['admin', 'superadmin'])): ?>
        <?php endif; ?>

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
    var IDLE_LIMIT   = 10 * 60;
    var WARNING_SECS = 2  * 60;

    var idleTimer, countdownTimer, secondsLeft;
    var lastActivity = Date.now();

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

    function togglePerpusDropdown(e, id) {
        e.stopPropagation();
        var targetId = id || 'perpusDropdownMenu';
        var allMenus = ['perpusDropdownMenu', 'perpusDropdownMenu1', 'petaDropdownAdmin', 'petaDropdownPemilik', 'pengaturanDropdown'];
        allMenus.forEach(function(menuId) {
            if (menuId !== targetId) {
                var m = document.getElementById(menuId);
                if (m) m.classList.remove('show');
            }
        });
        var m = document.getElementById(targetId);
        if (m) m.classList.toggle('show');
    }
    window.addEventListener('click', function() {
        ['perpusDropdownMenu','perpusDropdownMenu1','petaDropdownAdmin','petaDropdownPemilik','pengaturanDropdown'].forEach(function(id) {
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
