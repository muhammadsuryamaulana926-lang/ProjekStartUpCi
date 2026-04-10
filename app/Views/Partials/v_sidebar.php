<?php
// Partial: Sidebar — navigasi utama aplikasi, dimuat di setiap halaman
// Mendeteksi halaman aktif berdasarkan segmen URL pertama dan role user
$uri         = service('uri');
$currentPage = $uri->getSegment(1);
$role        = session()->get('user_role');
?>

<aside id="mainSidebar" class="sidebar">

    <!-- Logo aplikasi di bagian atas sidebar -->
    <div class="sidebar-brand">
        <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK">
    </div>

    <div class="sidebar-body">
        <nav class="sidebar-nav">

            <?php if ($role === 'pemilik_startup'): ?>

                <!-- Menu Startup Saya: menuju halaman detail startup milik user yang login -->
                <a href="<?= base_url('v_detail/' . session()->get('user_startup_uuid')) ?>"
                   class="nav-link-item <?= ($currentPage == 'v_detail') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="nav-label">Startup Saya</span>
                </a>

                <!-- Menu Edit Startup: menuju halaman edit data startup miliknya -->
                <a href="<?= base_url('v_edit_startup/' . session()->get('user_startup_uuid')) ?>"
                   class="nav-link-item <?= ($currentPage == 'v_edit_startup') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span class="nav-label">Edit Startup</span>
                </a>

                <!-- Menu Video: halaman konten video pembelajaran -->
                <a href="<?= base_url('v_video') ?>"
                   class="nav-link-item <?= ($currentPage == 'v_video') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    </svg>
                    <span class="nav-label">Video</span>
                </a>

                <!-- Menu Buku: halaman referensi buku -->
                <a href="<?= base_url('v_buku') ?>"
                   class="nav-link-item <?= ($currentPage == 'v_buku') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="nav-label">Buku</span>
                </a>

                <!-- Menu Peta: halaman peta lokasi startup milik sendiri -->
                <a href="<?= base_url('v_lokasi_startup_saya') ?>"
                   class="nav-link-item <?= ($currentPage == 'v_lokasi_startup_saya') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7"/>
                    </svg>
                    <span class="nav-label">Peta</span>
                </a>

                <!-- Tambahkan menu baru untuk pemilik_startup di sini -->

            <?php else: ?>

                <!-- Menu Dashboard: aktif jika URL segment pertama adalah 'v_dashboard' -->
                <a href="<?= base_url('v_dashboard') ?>"
                   class="nav-link-item <?= ($currentPage == 'v_dashboard') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="nav-label">Dashboard</span>
                </a>

                <!-- Menu Data Startup: aktif jika URL segment pertama adalah 'v_data_startup' -->
                <a href="<?= base_url('v_data_startup') ?>"
                   class="nav-link-item <?= ($currentPage == 'v_data_startup') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="nav-label">Data Startup</span>
                </a>

                <!-- Menu Video: halaman konten video pembelajaran -->
                <a href="<?= base_url('v_video') ?>"
                   class="nav-link-item <?= ($currentPage == 'v_video') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    </svg>
                    <span class="nav-label">Video</span>
                </a>

                <!-- Menu Buku: halaman referensi buku -->
                <a href="<?= base_url('v_buku') ?>"
                   class="nav-link-item <?= ($currentPage == 'v_buku') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="nav-label">Buku</span>
                </a>

                <!-- Menu Peta: halaman peta lokasi semua startup -->
                <a href="<?= base_url('v_detail_lokasi_startup') ?>"
                   class="nav-link-item <?= ($currentPage == 'v_detail_lokasi_startup') ? 'nav-active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7"/>
                    </svg>
                    <span class="nav-label">Peta</span>
                </a>

                <!-- Tambahkan menu baru untuk admin di sini -->

            <?php endif; ?>

        </nav>

        <!-- Teks keterangan di bagian bawah sidebar -->
        <div class="sidebar-footer">
            SIMIK Integrated System
        </div>
    </div>
</aside>

<script>
    // Tambahkan animasi masuk sidebar hanya saat pertama kali login
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (session()->getFlashdata('first_login')): ?>
        document.getElementById('mainSidebar').classList.add('sidebar-entrance');
        <?php endif; ?>
    });
</script>
<!-- Wrapper konten utama di sebelah kanan sidebar -->
<div class="app-main">
