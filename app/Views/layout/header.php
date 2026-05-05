<?php
// Partial: Header — SIMIK-style header
$uri = service('uri');
$currentPage = $uri->getSegment(1);
$role = session()->get('user_role');

// Notifikasi
$notif_list  = [];
$notif_count = 0;
if (in_array($role, ['admin', 'superadmin', 'pemilik_startup', 'pemateri'])) {
    $m_notif     = new \App\Models\M_notifikasi();
    $notif_list  = $m_notif->semua_belum_dibaca($role);
    $notif_count = count($notif_list);
}

$role_label = [
    'superadmin'      => 'Super Admin',
    'admin'           => 'Admin',
    'pemateri'        => 'Pemateri',
    'pemilik_startup' => 'Pemilik Startup',
];
$label = $role_label[$role] ?? ucfirst($role ?? 'User');
if (session()->get('is_peserta_program') && $role !== 'pemilik_startup') $label = 'Peserta Program';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title><?= (isset($title) ? $title . ' | ' : '') ?>SIMIK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
    <meta content="Sistem Informasi Manajemen Inovasi dan Kewirausahaan" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('img/logo_itb.png') ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDI Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- Feather Icons (SIMIK uses fe- icons) -->
    <link href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css" rel="stylesheet">
    <!-- Font Awesome (for scroll arrows) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Flatpickr -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css" rel="stylesheet">
    <!-- Plyr -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Plyr JS -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    <style>
    /* =============================================
       SIMIK STYLE - Adapted for this project
       ============================================= */
    :root {
        --ct-bg-topbar-dark: #38414a;
        --ct-menu-item-color: #cedce4;
        --ct-menu-item-active-color: #ffffff;
        --ct-hori-menu-item-color: #6c757d;
        --ct-box-shadow: 0 0 35px 0 rgba(154,161,171,.15);
    }

    body {
        font-size: 0.8rem;
        font-family: 'Cerebri Sans', sans-serif;
        background-color: #fafbfe;
        color: #6c757d;
        margin: 0;
        padding: 0;
    }

    #wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* ===== NAVBAR (Dark Top Bar) ===== */
    .navbar-custom {
        background-color: #005aab;
        padding: 0 12px;
        min-height: 70px;
        display: flex;
        align-items: center;
        position: relative;
        z-index: 1002;
    }

    .navbar-custom .container-fluid {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .logo-box {
        height: 70px;
        display: flex;
        align-items: center;
    }

    .logo-box .logo {
        display: flex;
        align-items: center;
        height: 100%;
        text-decoration: none;
    }

    .logo-box .logo img {
        height: 30px;
        width: auto;
    }

    .logo-box .logo-dark { display: none; }
    .logo-box .logo-light { display: flex; }

    /* Topnav menu list */
    .topnav-menu {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .topnav-menu > li > a {
        color: rgba(255,255,255,0.7);
        padding: 0 15px;
        line-height: 70px;
        display: flex;
        align-items: center;
        text-decoration: none;
        font-size: 0.85rem;
        transition: color 0.2s;
    }

    .topnav-menu > li > a:hover {
        color: #fff;
    }

    .topnav-menu > li > a i {
        font-size: 18px;
    }

    .noti-icon {
        font-size: 20px;
        color: rgba(255,255,255,0.7);
    }

    .noti-icon-badge {
        position: absolute;
        top: 14px;
        right: 8px;
        font-size: 9px;
        padding: 2px 5px;
    }

    .topnav-menu-left {
        display: flex;
        align-items: center;
    }

    .topnav-menu-left .button-menu-mobile {
        background: none;
        border: none;
        color: rgba(255,255,255,0.7);
        font-size: 24px;
        cursor: pointer;
        padding: 0 10px;
        line-height: 70px;
    }

    /* Notification dropdown */
    .notification-list .dropdown-menu {
        min-width: 320px;
        border: none;
        box-shadow: 0 0 35px 0 rgba(154,161,171,.25);
        border-radius: 4px;
    }

    .noti-title {
        background-color: transparent;
        padding: 15px 20px;
    }

    .noti-scroll {
        max-height: 280px;
        overflow-y: auto;
    }

    .notify-item {
        padding: 10px 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .notify-item:hover {
        background-color: #f8f9fa;
    }

    .notify-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #fff;
        float: left;
        margin-right: 10px;
    }

    .notify-details {
        margin-bottom: 0;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .notify-details small {
        display: block;
    }

    /* Profile dropdown */
    .nav-user {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .nav-user img {
        width: 32px;
        height: 32px;
        object-fit: cover;
    }

    .pro-user-name {
        color: rgba(255,255,255,0.9);
        font-size: 0.8rem;
    }

    /* Role badge in topbar */
    .peran-label {
        display: flex;
        align-items: center;
        height: 70px;
    }

    .peran-label .form-control {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.7);
        font-size: 0.75rem;
        cursor: default;
        padding: 0.3rem 0.7rem;
        border-radius: 4px;
    }

    /* ===== CONTENT PAGE ===== */
    .content-page {
        flex: 1;
        margin-top: 0;
        padding: 0 0 60px 0;
    }

    .content {
        padding: 24px 12px 0;
    }

    .page-title-box {
        padding-bottom: 12px;
    }

    .page-title-box .page-title {
        font-size: 1rem;
        font-weight: 600;
        color: #343a40;
        margin: 0;
    }

    /* ===== CARD ===== */
    .card {
        border: none;
        box-shadow: var(--ct-box-shadow);
        border-radius: 4px;
        margin-bottom: 24px;
    }

    .header-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #343a40;
    }

    /* ===== TABLE ===== */
    .table > thead {
        vertical-align: bottom;
        background: #f5f5f5;
    }

    .table > :not(caption) > * > * {
        padding: 0.55rem 0.55rem;
        font-size: 0.8rem;
    }

    /* ===== FOOTER ===== */
    .footer {
        background-color: #fff;
        border-top: 1px solid #dee2e6;
        padding: 20px 24px;
        color: #98a6ad;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar { width: 7px; height: 7px; }
    ::-webkit-scrollbar-track { background: #d4d9dc; border-radius: 3px; }
    ::-webkit-scrollbar-thumb { background: #4397e6; border-radius: 3px; }

    /* ===== SELECT2 FIX ===== */
    .select2-container--open { z-index: 9999999; }

    /* ===== FORM CONTROL ===== */
    .form-control {
        font-size: .775rem;
        padding: .45rem .9rem;
        border-radius: .2rem;
    }

    .form-control:disabled, .form-control[readonly] {
        background-color: #f7f7f7;
        opacity: 1;
    }

    .btn { --ct-btn-font-size: 0.8rem; }

    /* ===== MISC ===== */
    .dropdown-menu { --ct-dropdown-font-size: 0.8rem; font-size: 0.8rem; }
    .h5, h5 { font-size: 0.8rem; }

    .waves-effect { position: relative; overflow: hidden; }
    </style>
</head>

<body data-layout-mode="horizontal" data-topbar-color="dark">
    <!-- Begin page -->
    <div id="wrapper">

        <!-- ===== Topbar Start ===== -->
        <div class="navbar-custom">
            <div class="container-fluid">

                <!-- LOGO -->
                <div class="logo-box" style="display:flex;align-items:center;gap:12px;">
                    <a href="<?= base_url('v_dashboard') ?>" class="logo logo-light text-center">
                        <span class="logo-lg">
                            <img src="<?= base_url('img/logo-simik.png') ?>" alt="SIMIK" height="30">
                        </span>
                    </a>
                    <span class="badge bg-primary d-none d-lg-inline-block" style="font-size:0.72rem;padding:4px 10px;">
                        <?= esc($label) ?>
                    </span>
                </div>

                <!-- Left items -->
                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile d-lg-none">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>

                <!-- Right items -->
                <ul class="list-unstyled topnav-menu mb-0 ms-auto">
                    <!-- Fullscreen -->
                    <li class="d-none d-lg-inline-block">
                        <a class="nav-link waves-effect waves-light" data-toggle="fullscreen" href="#" style="line-height:70px;padding:0 15px;">
                            <i class="mdi mdi-fullscreen noti-icon"></i>
                        </a>
                    </li>

                    <!-- Notification -->
                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="line-height:70px;padding:0 15px;position:relative;">
                            <i class="mdi mdi-bell-outline noti-icon"></i>
                            <?php if ($notif_count > 0): ?>
                            <span class="badge bg-danger rounded-circle noti-icon-badge"><?= $notif_count ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                    <span class="float-end">
                                        <a href="#" class="text-dark" onclick="tandaiSemuaDibaca()"><small>Tandai semua dibaca</small></a>
                                    </span>Notifikasi
                                </h5>
                            </div>
                            <div class="noti-scroll" id="notifList">
                                <?php if (empty($notif_list)): ?>
                                <div class="text-center text-muted py-4">
                                    <i class="mdi mdi-bell-off-outline d-block mb-2" style="font-size:28px;"></i>
                                    <small>Tidak ada notifikasi baru</small>
                                </div>
                                <?php else: ?>
                                <?php foreach ($notif_list as $n): ?>
                                <a href="javascript:" onclick="bukaNotif(<?= $n['id_notifikasi'] ?>, '<?= esc($n['url'] ?? '') ?>')" class="dropdown-item notify-item" id="notif-<?= $n['id_notifikasi'] ?>">
                                    <div class="notify-icon bg-primary">
                                        <i class="mdi mdi-message"></i>
                                    </div>
                                    <p class="notify-details">
                                        <b><?= esc($n['judul']) ?></b>
                                        <small class="text-muted"><?= esc($n['pesan']) ?></small>
                                        <small class="text-muted"><?= date('d M Y, H:i', strtotime($n['dibuat_pada'])) ?></small>
                                    </p>
                                </a>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <a href="#" class="dropdown-item text-center text-primary notify-item notify-all">Lihat Selengkapnya <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </li>

                    <!-- User Profile -->
                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="line-height:70px; padding:0 15px; display:flex; align-items:center; gap:8px;">
                            <img src="<?= base_url('img/logo_itb.png') ?>" alt="user" class="rounded-circle" style="width:32px;height:32px;object-fit:cover;flex-shrink:0;">
                            <span style="display:flex;flex-direction:column;line-height:1.3;max-width:160px;">
                                <span style="color:rgba(255,255,255,0.9);font-size:0.8rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    <?= esc(session()->get('user_name') ?? 'Admin') ?>
                                </span>
                                <span style="color:rgba(255,255,255,0.55);font-size:0.7rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    <?= esc(session()->get('user_email') ?? '') ?>
                                </span>
                            </span>
                            <i class="mdi mdi-chevron-down" style="color:rgba(255,255,255,0.6);flex-shrink:0;"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown" style="min-width:200px;">
                            <div class="px-3 py-2 border-bottom">
                                <div style="font-weight:600;font-size:0.82rem;color:#343a40;"><?= esc(session()->get('user_name') ?? 'Admin') ?></div>
                                <div style="font-size:0.75rem;color:#98a6ad;"><?= esc(session()->get('user_email') ?? '') ?></div>
                                <div style="font-size:0.72rem;margin-top:2px;"><span class="badge bg-primary"><?= esc($label) ?></span></div>
                            </div>
                            <a href="<?= base_url('logout') ?>" class="dropdown-item notify-item">
                                <i class="mdi mdi-logout me-1"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ===== Topbar End ===== -->
