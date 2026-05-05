<?php
// Partial: Topbar — SIMIK-style horizontal scrollable menu
$uri = service('uri');
$currentPage = $uri->getSegment(1);
$role = session()->get('user_role');
$is_peserta = session()->get('is_peserta_program') && $role !== 'pemilik_startup';
?>

<style>
.scroll-container {
    position: relative;
    width: 100%;
    overflow-x: hidden;
    overflow-y: visible;
}

.scroll-menu {
    width: 100%;
    overflow-x: auto;
    white-space: nowrap;
    scroll-behavior: smooth;
    display: flex;
    flex-wrap: nowrap;
    background-color: #ffffff;
    margin: 0 auto;
    position: relative;
    scrollbar-width: none;
}

.scroll-menu::-webkit-scrollbar {
    display: none;
}

.navigator {
    position: fixed;
    transform: translateY(-50%);
    z-index: 1000;
    background: rgb(1 91 171);
    color: white;
    border: none;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    cursor: pointer;
    margin-left: 35px;
    margin-right: 35px;
}

#scroll-left {
    left: 0;
    transform: translateX(-50%);
    margin-top: 15px;
}

#scroll-right {
    right: 0;
    transform: translateX(50%);
    margin-top: 15px;
}

.topnav {
    width: 100%;
    flex-shrink: 0;
    position: relative;
    margin-top: 0;
}

.topnav .navbar-nav .nav-link {
    font-size: 0.875rem;
    position: relative;
    line-height: 21.5px;
    padding: calc(33px / 2) 1.4rem;
    color: #6c757d;
    font-family: "Cerebri Sans", sans-serif;
    background-color: #ffffff;
    white-space: nowrap;
}

.topnav .navbar-nav .nav-link:hover {
    background-color: #ffffff;
    color: #005aab;
}

.topnav .navbar-nav .no-dropdown.active,
.topnav .navbar-nav .nav-link.active {
    color: #005aab;
}

.topnav .dropdown-menu {
    position: fixed !important;
    z-index: 9999 !important;
    background: white;
    min-width: 200px;
    border: none;
    box-shadow: 0 0 35px 0 rgba(154,161,171,.25);
    border-radius: 4px;
    font-size: 0.8rem;
}

.topnav .dropdown-item {
    font-size: 0.8rem;
    padding: 6px 20px;
    color: #6c757d;
}

.topnav .dropdown-item:hover {
    color: #005aab;
    background-color: #f8f9fa;
}

@media (min-width: 992px) {
    .topnav .dropdown-item.active {
        background-color: transparent;
        color: #005aab;
    }
}

.arrow-down {
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 6px;
    vertical-align: middle;
    border-top: 4px solid;
    border-right: 4px solid transparent;
    border-left: 4px solid transparent;
}
</style>

<!-- Horizontal Navigation Menu -->
<div class="container-fluid position-sticky" style="top:0; max-width:100%; z-index:999; padding:0px 24px; background-color:#ffffff; box-shadow: 0 0 35px 0 rgba(154,161,171,.15);">
    <div id="scroll-container" class="scroll-menu">
        <button id="scroll-left" class="navigator"><i class="fas fa-chevron-left"></i></button>
        <div class="topnav">
            <div class="container-fluid" style="margin:0px">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu" style="width:100%;">
                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">

                        <?php if ($is_peserta): ?>
                            <!-- Peserta Program -->
                            <li class="nav-item">
                                <a class="nav-link no-dropdown <?= ($currentPage == 'program') ? 'active' : '' ?>" href="<?= base_url('program') ?>">
                                    <i class="mdi mdi-book-open-page-variant me-1"></i>Program
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle arrow-none <?= in_array($currentPage, ['v_perpustakaan', 'perpustakaan']) ? 'active' : '' ?>" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-library me-1"></i>Perpustakaan
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?= base_url('v_perpustakaan') ?>" class="dropdown-item"><i class="mdi mdi-book me-1"></i>Buku Digital</a>
                                    <a href="<?= base_url('perpustakaan/video') ?>" class="dropdown-item"><i class="mdi mdi-video me-1"></i>Video</a>
                                </div>
                            </li>

                        <?php elseif ($role === 'pemateri'): ?>
                            <!-- Pemateri -->
                            <li class="nav-item">
                                <a class="nav-link no-dropdown <?= ($currentPage == 'v_dashboard') ? 'active' : '' ?>" href="<?= base_url('v_dashboard') ?>">
                                    <i class="mdi mdi-view-dashboard me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link no-dropdown <?= ($currentPage == 'jadwal_kelas') ? 'active' : '' ?>" href="<?= base_url('jadwal_kelas') ?>">
                                    <i class="mdi mdi-calendar me-1"></i>Kalender
                                </a>
                            </li>

                        <?php elseif ($role === 'pemilik_startup'): ?>
                            <!-- Pemilik Startup -->
                            <li class="nav-item">
                                <a class="nav-link no-dropdown <?= in_array($currentPage, ['v_detail_startup', 'v_detail']) ? 'active' : '' ?>" href="<?= base_url('v_detail_startup/' . session()->get('user_startup_uuid')) ?>">
                                    <i class="mdi mdi-office-building me-1"></i>Startup Saya
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link no-dropdown <?= ($currentPage == 'v_edit_startup') ? 'active' : '' ?>" href="<?= base_url('v_edit_startup/' . session()->get('user_startup_uuid')) ?>">
                                    <i class="mdi mdi-pencil me-1"></i>Edit Startup
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle arrow-none <?= in_array($currentPage, ['v_perpustakaan', 'perpustakaan']) ? 'active' : '' ?>" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-library me-1"></i>Perpustakaan
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?= base_url('v_perpustakaan') ?>" class="dropdown-item"><i class="mdi mdi-book me-1"></i>Buku Digital</a>
                                    <a href="<?= base_url('perpustakaan/video') ?>" class="dropdown-item"><i class="mdi mdi-video me-1"></i>Video</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle arrow-none <?= in_array($currentPage, ['v_lokasi_startup_saya', 'v_globe']) ? 'active' : '' ?>" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-map-marker me-1"></i>Peta Lokasi
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?= base_url('v_lokasi_startup_saya') ?>" class="dropdown-item"><i class="mdi mdi-map me-1"></i>Peta Lokal</a>
                                    <a href="<?= base_url('v_globe') ?>" class="dropdown-item"><i class="mdi mdi-earth me-1"></i>Globe Global</a>
                                </div>
                            </li>

                        <?php else: ?>
                            <!-- Admin / Superadmin -->
                            <li class="nav-item">
                                <a class="nav-link no-dropdown <?= ($currentPage == 'v_dashboard') ? 'active' : '' ?>" href="<?= base_url('v_dashboard') ?>">
                                    <i class="mdi mdi-view-dashboard me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle arrow-none <?= in_array($currentPage, ['v_perpustakaan', 'perpustakaan']) ? 'active' : '' ?>" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-library me-1"></i>Perpustakaan
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?= base_url('v_perpustakaan') ?>" class="dropdown-item"><i class="mdi mdi-book me-1"></i>Buku Digital</a>
                                    <a href="<?= base_url('perpustakaan/video') ?>" class="dropdown-item"><i class="mdi mdi-video me-1"></i>Video</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle arrow-none <?= in_array($currentPage, ['v_lokasi_startup', 'v_globe']) ? 'active' : '' ?>" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-map-marker me-1"></i>Peta Lokasi
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?= base_url('v_lokasi_startup') ?>" class="dropdown-item"><i class="mdi mdi-map me-1"></i>Peta Lokal</a>
                                    <a href="<?= base_url('v_globe') ?>" class="dropdown-item"><i class="mdi mdi-earth me-1"></i>Globe Global</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link no-dropdown <?= ($currentPage == 'program') ? 'active' : '' ?>" href="<?= base_url('program') ?>">
                                    <i class="mdi mdi-school me-1"></i>Program Kelas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link no-dropdown <?= ($currentPage == 'jadwal_kelas') ? 'active' : '' ?>" href="<?= base_url('jadwal_kelas') ?>">
                                    <i class="mdi mdi-calendar me-1"></i>Agenda
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle arrow-none <?= ($currentPage === 'inkubasi_bisnis' || $currentPage === 'v_data_startup') ? 'active' : '' ?>" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-domain me-1"></i>Inkubasi Bisnis
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?= base_url('v_data_startup') ?>" class="dropdown-item"><i class="mdi mdi-rocket-launch me-1"></i>Startup</a>
                                    <a href="<?= base_url('inkubasi_bisnis/program_kewirausahaan') ?>" class="dropdown-item"><i class="mdi mdi-certificate me-1"></i>Program Kewirausahaan</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle arrow-none <?= in_array($currentPage, ['log_aktivitas', 'aktivitas_login', 'manajemen_user', 'v_riwayat_aktivitas']) ? 'active' : '' ?>" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-cog me-1"></i>Pengaturan
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?= base_url('aktivitas_login') ?>" class="dropdown-item"><i class="mdi mdi-login me-1"></i>Aktivitas Login</a>
                                    <a href="<?= base_url('log_aktivitas') ?>" class="dropdown-item"><i class="mdi mdi-file-document me-1"></i>Log Aktivitas</a>
                                    <a href="<?= base_url('manajemen_user') ?>" class="dropdown-item"><i class="mdi mdi-account-group me-1"></i>Manajemen User</a>
                                    <a href="<?= base_url('v_riwayat_aktivitas') ?>" class="dropdown-item"><i class="mdi mdi-history me-1"></i>Riwayat Ebook & Video</a>
                                </div>
                            </li>
                        <?php endif; ?>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <button id="scroll-right" class="navigator"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

<script>
$(document).ready(function () {
    const scrollContainer = $(".scroll-menu")[0];
    const scrollLeftBtn = $("#scroll-left");
    const scrollRightBtn = $("#scroll-right");
    let scrollInterval;

    function checkOverflow() {
        if (scrollContainer && scrollContainer.scrollWidth > scrollContainer.clientWidth) {
            $(".navigator").css('display', 'flex');
        } else {
            $(".navigator").fadeOut();
        }
    }

    checkOverflow();
    $(window).on("resize", checkOverflow);

    function startScroll(direction) {
        stopScroll();
        scrollInterval = setInterval(() => {
            scrollContainer.scrollLeft += direction === "left" ? -20 : 20;
        }, 2);
    }

    function stopScroll() {
        clearInterval(scrollInterval);
    }

    scrollLeftBtn.mousedown(() => startScroll("left"));
    scrollRightBtn.mousedown(() => startScroll("right"));
    $(document).mouseup(stopScroll);

    // Dropdown hover for horizontal menu
    document.querySelectorAll(".topnav .nav-item.dropdown").forEach(item => {
        let dropdown = item.querySelector(".dropdown-menu");

        item.addEventListener("mouseenter", function() {
            if (dropdown) {
                let rect = this.getBoundingClientRect();
                dropdown.style.left = rect.left + "px";
                dropdown.style.top  = rect.bottom + "px";
                dropdown.classList.add("show");
            }
        });

        item.addEventListener("mouseleave", function() {
            if (dropdown) dropdown.classList.remove("show");
        });
    });
});
</script>
