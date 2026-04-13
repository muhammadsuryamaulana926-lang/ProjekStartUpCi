<?php /* View: Detail Startup — menampilkan semua informasi startup dalam tab: info, tim, produk, pendanaan, prestasi, mentor, aktivitas, lokasi */ ?>
<!-- Import Font Inter & Lucide Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    /* Global Typography & Background */
    .app-content {
        font-family: 'Inter', sans-serif !important;
        background-color: #f8fafc !important;
        padding: 32px 28px;
        min-height: 100vh;
    }
    .section-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    /* Cards */
    .card-premium {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        overflow: hidden;
        margin-bottom: 24px;
    }

    /* Attributes Styling */
    .label-text {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        margin-bottom: 4px;
    }
    .value-text {
        font-size: 14px;
        font-weight: 500;
        color: #334155;
    }

    /* Timeline */
    .timeline-sm { padding-left: 20px; }
    .timeline-sm .timeline-sm-item {
        position: relative;
        padding-bottom: 24px;
        padding-left: 24px;
        border-left: 2px solid #e2e8f0;
    }
    .timeline-sm .timeline-sm-item:before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #6366f1;
        border: 2px solid #fff;
    }
    .timeline-sm .timeline-sm-item .timeline-sm-date {
        font-size: 12px;
        color: #64748b;
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
    }
    .timeline-sm .timeline-sm-item h5 {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .timeline-sm .timeline-sm-item p {
        font-size: 13px;
        color: #475569;
        margin: 0;
    }

    .select2-container--open { z-index: 9999999; }
    
    /* Custom Headers override for legacy `.bg-light.p-2` */
    h5.bg-light.p-2 {
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #334155 !important;
        background: #f1f5f9 !important;
        border-radius: 10px !important;
        padding: 14px 18px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        margin-bottom: 20px !important;
        letter-spacing: 0.03em !important;
        text-transform: uppercase !important;
    }
    
    /* Tab Overrides */
    .nav-tabs.nav-bordered {
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 0px;
        gap: 16px;
    }
    .nav-tabs.nav-bordered .nav-link {
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 12px 4px;
        margin-bottom: -2px;
        background: transparent !important;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .nav-tabs.nav-bordered .nav-link i { font-size: 16px; }
    .nav-tabs.nav-bordered .nav-link.active {
        color: #6366f1;
        border-bottom: 2px solid #6366f1;
    }
    .nav-tabs.nav-bordered .nav-link:hover:not(.active) { color: #0f172a; }

    /* Button Primary */
    .btn-action-primary {
        background: #6366f1;
        border: none;
        color: #ffffff;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-action-primary:hover {
        background: #4f46e5;
        transform: translateY(-1px);
        color: #fff;
    }
    
    /* Table Styling Minimalist override for `.table-sm` */
    .table-sm th {
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        color: #94a3b8 !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 12px 8px !important;
        background: transparent !important;
    }
    .table-sm td {
        font-size: 13px !important;
        color: #334155 !important;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle !important;
    }

    /* Modal Styling */
    .modal-content { border: none; border-radius: 20px; box-shadow: 0 24px 48px rgba(0,0,0,0.12); font-family: 'Inter', sans-serif; }
    .modal-header { background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 24px 32px; flex-direction: column; align-items: flex-start; position: relative; }
    .modal-header .btn-close { position: absolute; top: 24px; right: 32px; opacity: 0.5; margin: 0; padding: 0; }
    .modal-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 0px; letter-spacing: -0.5px; display: flex; align-items: center; gap: 8px; }
    .modal-body { padding: 32px; background: #ffffff; }
    .modal-footer { padding: 24px 32px; background: #f8fafc; border-top: 1px solid #f1f5f9; }
</style>

<div class="app-content">
    <div class="container-fluid px-0">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <p class="section-title mb-0">Detail Startup</p>
            </div>
        </div>

        <!-- Notifikasi flashdata dari session (sukses/gagal operasi sebelumnya) -->
        <?php if (session()->getFlashdata('msg') !== NULL) { ?>
            <div class="alert <?php echo (session()->getFlashdata('msg')[0] == "success") ? "alert-success" : "alert-danger"; ?> alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php echo session()->getFlashdata('msg')[1]; ?>
            </div>
        <?php } ?>

        <div class="row g-4">
            <!-- Sidebar profil utama startup -->
            <div class="col-lg-3">
                <div class="card-premium profile-hero" style="position:relative; overflow:hidden; border:none; box-shadow:0 12px 32px rgba(0,0,0,0.05);">
                    <!-- Menu Tindakan Cepat (Dropdown di pojok atas) -->
                    <div style="position:absolute; top:12px; right:12px; z-index:10;">
                        <div class="dropdown">
                            <button class="btn-action" style="background:rgba(0,0,0,0.05); backdrop-filter:blur(4px); border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; border:none; transition:background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.1)'" onmouseout="this.style.background='rgba(0,0,0,0.05)'" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-lucide="more-horizontal" style="width:18px; height:18px; color:#475569;"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="border:none;box-shadow:0 10px 25px rgba(0,0,0,0.1);border-radius:12px;overflow:hidden;padding:0;">
                                <?php if ($data[0]['status_ajuan'] == "ajuan") { ?>
                                <a type="button" class="dropdown-item py-2" onclick="verifikasi_startup(<?php echo $data[0]['id_startup']; ?>, <?php echo $_SESSION['id_pengguna']; ?>)"><i data-lucide="check-circle" class="me-2" style="width:16px;color:#10b981;"></i> Verifikasi</a>
                                <a type="button" class="dropdown-item py-2" onclick="tolak_startup(<?php echo $data[0]['id_startup']; ?>, <?php echo $_SESSION['id_pengguna']; ?>)"><i data-lucide="x-circle" class="me-2" style="width:16px;color:#ef4444;"></i> Tolak</a>
                                <div class="dropdown-divider my-0"></div>
                                <?php } ?>
                                <a href="<?php echo base_url('v_data_startup'); ?>" class="dropdown-item py-2"><i data-lucide="arrow-left" class="me-2" style="width:16px;color:#64748b;"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Banner Logo Ruang Tengah -->
                    <div style="width:100%; height:160px; padding:24px; background:#ffffff; border-bottom:1px dashed #e2e8f0; display:flex; align-items:center; justify-content:center;">
                        <?php
                            $logo = $data[0]['logo_perusahaan'] ?? '';
                            if ($logo && file_exists(FCPATH . 'uploads/file_startup/logo_startup/' . $logo)) {
                                $logo_url = base_url('uploads/file_startup/logo_startup/' . $logo);
                            } elseif ($logo && file_exists(FCPATH . 'uploads/logos/' . $logo)) {
                                $logo_url = base_url('uploads/logos/' . $logo);
                            } else {
                                $logo_url = base_url('img/logo-dkst.png');
                            }
                        ?>
                        <img src="<?php echo $logo_url; ?>" style="max-width:100%; height:100px; object-fit:contain;">
                    </div>

                    <div class="px-4 pt-4 pb-4">
                        <!-- Data Utama Perusahaan -->
                        <div class="text-center mb-4">
                            <h4 style="font-size:18px; font-weight:700; color:#0f172a; margin-bottom:4px; letter-spacing:-0.5px; text-transform: capitalize;"><?php echo strtolower($data[0]['nama_perusahaan']); ?></h4>
                            <p style="font-size:12px; color:#64748b; font-weight:500; margin-bottom:12px; line-height:1.4; text-transform: capitalize;"><?php echo is_array($data[0]['klasters']) ? strtolower(implode(", ", $data[0]['klasters'])) : strtolower($data[0]['klasters']); ?></p>
                            
                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                <span style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.05em; padding:4px 10px; border-radius:6px; background: <?php echo ($data[0]['status_startup'] == 'aktif') ? '#ecfdf5' : '#fef2f2'; ?>; color: <?php echo ($data[0]['status_startup'] == 'aktif') ? '#059669' : '#dc2626'; ?>; border:1px solid <?php echo ($data[0]['status_startup'] == 'aktif') ? '#a7f3d0' : '#fecaca'; ?>;">
                                    <?php echo ucfirst($data[0]['status_startup']); ?>
                                </span>
                                <span style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.05em; padding:4px 10px; border-radius:6px; background: <?php echo ($data[0]['status_ajuan'] == 'verifikasi') ? '#eff6ff' : ($data[0]['status_ajuan'] == 'tolak' ? '#fef2f2' : '#fffbeb'); ?>; color: <?php echo ($data[0]['status_ajuan'] == 'verifikasi') ? '#2563eb' : ($data[0]['status_ajuan'] == 'tolak' ? '#dc2626' : '#d97706'); ?>; border:1px solid <?php echo ($data[0]['status_ajuan'] == 'verifikasi') ? '#bfdbfe' : ($data[0]['status_ajuan'] == 'tolak' ? '#fecaca' : '#fde68a'); ?>;">
                                    <?php echo ucfirst($data[0]['status_ajuan']); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Panel Detail Berjenjang -->
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div style="background:#f8fafc; border:1px solid #f1f5f9; border-radius:12px; padding:14px;">
                                <span style="display:block; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Deskripsi Singkat</span>
                                <p style="font-size:12px; color:#334155; line-height:1.5; margin:0;"><?php echo $data[0]['deskripsi_bidang_usaha'] ?: '-'; ?></p>
                            </div>

                            <div style="background:#f8fafc; border:1px solid #f1f5f9; border-radius:12px; padding:14px; display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                                <div>
                                    <span style="display:flex; align-items:center; gap:4px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; margin-bottom:4px;">
                                        <i data-lucide="calendar" style="width:12px;"></i> Berdiri
                                    </span>
                                    <span style="font-size:13px; font-weight:700; color:#0f172a;"><?php echo $data[0]['tahun_berdiri']; ?></span>
                                </div>
                                <div>
                                    <span style="display:flex; align-items:center; gap:4px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; margin-bottom:4px;">
                                        <i data-lucide="file-check-2" style="width:12px;"></i> Daftar
                                    </span>
                                    <span style="font-size:13px; font-weight:700; color:#0f172a;"><?php echo $data[0]['tahun_daftar']; ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Kontak Cepat Berderet -->
                        <div class="mt-4 pt-4 pb-2" style="border-top:1px dashed #e2e8f0; display:flex; justify-content:center; gap:12px;">
                            <?php if($data[0]['nomor_whatsapp']) { ?>
                                <a href="https://wa.me/<?php echo $data[0]['nomor_whatsapp']; ?>" target="_blank" style="width:36px; height:36px; border-radius:10px; background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; display:flex; align-items:center; justify-content:center; transition:transform 0.2s; text-decoration:none;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'" title="WhatsApp">
                                    <i class="mdi mdi-whatsapp" style="font-size:18px;"></i>
                                </a>
                            <?php } ?>
                            <?php if($data[0]['email_perusahaan']) { ?>
                                <a href="mailto:<?php echo $data[0]['email_perusahaan']; ?>" style="width:36px; height:36px; border-radius:10px; background:#fef2f2; color:#ef4444; border:1px solid #fecaca; display:flex; align-items:center; justify-content:center; transition:transform 0.2s; text-decoration:none;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'" title="Kirim Email">
                                    <i class="mdi mdi-email-outline" style="font-size:18px;"></i>
                                </a>
                            <?php } ?>
                            <?php if($data[0]['website_perusahaan']) { ?>
                                <a href="<?php echo $data[0]['website_perusahaan']; ?>" target="_blank" style="width:36px; height:36px; border-radius:10px; background:#eff6ff; color:#3b82f6; border:1px solid #bfdbfe; display:flex; align-items:center; justify-content:center; transition:transform 0.2s; text-decoration:none;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'" title="Website Resmi">
                                    <i class="mdi mdi-web" style="font-size:18px;"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Konten tab kanan: detail lengkap startup -->
            <div class="col-lg-9">
                <div class="card-premium">
                    <div class="p-3">
                            <ul class="nav nav-tabs nav-bordered mb-3">
                                <li class="nav-item"><a href="#startup" data-bs-toggle="tab" class="nav-link active"><i class="mdi mdi-home"></i>Starup</a></li>
                                <!-- <li class="nav-item"><a href="#produk" data-bs-toggle="tab" class="nav-link"><i class="mdi mdi-package-variant"></i> Produk</a></li> -->
                                <!-- <li class="nav-item"><a href="#pendanaan" data-bs-toggle="tab" class="nav-link"><i class="mdi mdi-cash-multiple"></i> Pendanaan</a></li> -->
                                <!-- <li class="nav-item"><a href="#prestasi" data-bs-toggle="tab" class="nav-link"><i class="mdi mdi-trophy"></i> Prestasi</a></li> -->
                                <!-- <li class="nav-item"><a href="#mentor" data-bs-toggle="tab" class="nav-link"><i class="mdi mdi-account-star"></i> Mentor</a></li> -->
                                <!-- <li class="nav-item"><a href="#aktifitas" data-bs-toggle="tab" class="nav-link"><i class="mdi mdi-history"></i> Aktifitas</a></li> -->
                                <li class="nav-item"><a href="#lokasi" data-bs-toggle="tab" class="nav-link"><i class="mdi mdi-map-marker"></i> Lokasi</a></li>
                            </ul>

                            <div class="tab-content">
                                <!-- Tab Informasi Startup & Tim -->
                                <div class="tab-pane show active" id="startup">
                                    <h5 class="mb-3 bg-light p-2 d-flex align-items-center justify-content-between">
                                        <span><i class="mdi mdi-information-outline me-1"></i> INFORMASI STARTUP</span>
                                        <a href="<?= base_url('v_edit_startup/' . $data[0]['uuid_startup']) ?>" class="btn btn-primary btn-sm" style="border-radius:8px;padding:5px 10px;">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    </h5>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <p class="label-text">Target Pemasaran</p>
                                            <p class="value-text" style="text-transform: capitalize;"><?php echo strtolower($data[0]['target_pemasaran'] ?: '-'); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="label-text">Fokus Pelanggan</p>
                                            <p class="value-text" style="text-transform: capitalize;"><?php echo strtolower($data[0]['fokus_pelanggan'] ?: '-'); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="label-text">Dosen Pembina</p>
                                            <p class="value-text" style="text-transform: capitalize;"><?php echo strtolower($data[0]['nama_dosen'] ?: '-'); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="label-text">Alamat</p>
                                            <p class="value-text" style="text-transform: capitalize;"><?php echo strtolower($data[0]['alamat'] ?: '-'); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="label-text">Program Yang Diikuti</p>
                                            <p class="value-text" style="text-transform: capitalize;"><?php echo strtolower($data[0]['nama_program'] ?: '-'); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="label-text">LinkedIn</p>
                                            <p class="value-text" style="text-transform: lowercase;"><?php echo $data[0]['linkedin_perusahaan'] ?: '-'; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="label-text">Instagram</p>
                                            <p class="value-text" style="text-transform: lowercase;"><?php echo $data[0]['instagram_perusahaan'] ?: '-'; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="label-text">Lokasi</p>
                                            <p class="value-text">
                                                <?php if (!empty($data[0]['latitude']) && !empty($data[0]['longitude'])): ?>
                                                    <?php
                                                        // Pemilik startup → ke halaman peta khusus miliknya
                                                        // Admin → ke halaman peta semua startup dengan fokus koordinat
                                                        $url_peta = session()->get('user_role') === 'pemilik_startup'
                                                            ? base_url('v_lokasi_startup_saya') . '?lat=' . $data[0]['latitude'] . '&lng=' . $data[0]['longitude']
                                                            : base_url('v_detail_lokasi_startup') . '?lat=' . $data[0]['latitude'] . '&lng=' . $data[0]['longitude'];
                                                    ?>
                                                    <a href="<?= $url_peta ?>" style="color:var(--primary);font-weight:600;text-decoration:none;">
                                                        <i class="mdi mdi-map-marker"></i> Lihat di Peta
                                                    </a>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <h5 class="mb-3 bg-light p-2">
                                        <div class="float-end" style="margin-top: -5px;">
                                            <a type="button" onclick="tambah_informasi_tim()" class="btn btn-primary btn-xs"><i class="mdi mdi-plus"></i></a>
                                        </div>
                                        <i class="mdi mdi-account-group me-1"></i> INFORMASI TIM
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-centered mb-0">
                                            <thead><tr><th>Nama</th><th>Jabatan</th><th>Kontak</th><th>Univ</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <?php if(!empty($data_tim)){ foreach ($data_tim as $row) { ?>
                                                <tr>
                                                    <td><?php echo $row->nama_lengkap; ?></td>
                                                    <td><?php echo $row->jabatan_tim; ?></td>
                                                    <td><small><?php echo $row->email; ?><br><?php echo $row->no_whatsapp; ?></small></td>
                                                    <td><?php echo $row->nama_perguruan_tinggi; ?></td>
                                                    <td>
                                                        <button onclick="ubah_informasi_tim(<?php echo $row->id_startup_tim; ?>)" class="btn btn-info btn-xs"><i class="mdi mdi-pencil"></i></button>
                                                        <button onclick="hapus_informasi_tim(<?php echo $row->id_startup_tim; ?>)" class="btn btn-danger btn-xs"><i class="mdi mdi-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <?php } } else { ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="empty-state" style="padding: 32px 14px;">
                                                            <i data-lucide="users" class="empty-state-icon" style="width:36px;height:36px;stroke-width:1.5"></i>
                                                            <div class="empty-state-text">Belum ada data struktur tim ditambahkan</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab daftar produk startup -->
                                <div class="tab-pane" id="produk">
                                    <h5 class="mb-3 bg-light p-2">
                                        <a type="button" onclick="tambah_informasi_produk()" class="btn btn-primary btn-xs float-end" style="margin-top:-5px;"><i class="mdi mdi-plus"></i></a>
                                        <i class="mdi mdi-package-variant me-1"></i> PRODUK
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-centered mb-0">
                                            <thead><tr><th>Produk</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <?php if(!empty($data_produk)){ foreach ($data_produk as $row) { ?>
                                                <tr>
                                                    <td><strong><?php echo $row->nama_produk; ?></strong></td>
                                                    <td><small><?php echo $row->deskripsi_produk; ?></small></td>
                                                    <td>
                                                        <button onclick="ubah_informasi_produk(<?php echo $row->id_startup_produk; ?>)" class="btn btn-info btn-xs"><i class="mdi mdi-pencil"></i></button>
                                                        <button onclick="hapus_informasi_produk(<?php echo $row->id_startup_produk; ?>)" class="btn btn-danger btn-xs"><i class="mdi mdi-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <?php } } else { echo "<tr><td colspan='3'><div class='empty-state' style='padding:32px 14px;'><i data-lucide='package-open' class='empty-state-icon' style='width:36px;height:36px;stroke-width:1.5'></i><div class='empty-state-text'>Belum ada portfolio produk didaftarkan</div></div></td></tr>"; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab pendanaan: internal ITB dan eksternal -->
                                <div class="tab-pane" id="pendanaan">
                                    <h5 class="mb-2 bg-light p-2">INTERNAL ITB 
                                        <a type="button" onclick="tambah_informasi_pendanaan_itb()" class="btn btn-primary btn-xs float-end" style="margin-top:-5px;"><i class="mdi mdi-plus"></i></a>
                                    </h5>
                                    <table class="table table-sm mb-3">
                                        <thead><tr><th>Program</th><th>Tahun</th><th>Jumlah</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <?php if(!empty($data_pendanaan_itb)){ foreach ($data_pendanaan_itb as $row) { ?>
                                            <tr><td><?php echo $row->program_kegiatan; ?></td><td><?php echo $row->tahun; ?></td><td>Rp <?php echo number_format($row->jumlah_pendanaan,0,',','.'); ?></td>
                                            <td><button onclick="ubah_informasi_pendanaan_itb(<?php echo $row->id_startup_pendanaan_itb; ?>)" class="btn btn-info btn-xs"><i class="mdi mdi-pencil"></i></button></td></tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                    <h5 class="mb-2 bg-light p-2">EKSTERNAL
                                        <a type="button" onclick="tambah_informasi_pendanaan_non_itb()" class="btn btn-primary btn-xs float-end" style="margin-top:-5px;"><i class="mdi mdi-plus"></i></a>
                                    </h5>
                                    <table class="table table-sm">
                                        <thead><tr><th>Investor</th><th>Tahun</th><th>Jumlah</th><th>Aksi</th></tr></thead>
                                        <tbody>
                                            <?php if(!empty($data_pendanaan_non_itb)){ foreach($data_pendanaan_non_itb as $row){ ?>
                                            <tr><td><?php echo $row->nama_investor; ?></td><td><?php echo $row->tahun; ?></td><td>Rp <?php echo number_format($row->jumlah_pendanaan,0,',','.'); ?></td>
                                            <td><button onclick="ubah_informasi_pendanaan_non_itb(<?php echo $row->id_startup_pendanaan_non_itb; ?>)" class="btn btn-info btn-xs"><i class="mdi mdi-pencil"></i></button></td></tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tab daftar prestasi/penghargaan startup -->
                                <div class="tab-pane" id="prestasi">
                                    <h5 class="mb-3 bg-light p-2">
                                        <a type="button" onclick="tambah_informasi_prestasi()" class="btn btn-primary btn-xs float-end" style="margin-top:-5px;"><i class="mdi mdi-plus"></i></a>
                                        <i class="mdi mdi-trophy me-1"></i> PRESTASI
                                    </h5>
                                    <div class="row">
                                        <?php if(!empty($data_prestasi)){ foreach($data_prestasi as $row){ ?>
                                            <div class="col-md-6 mb-2 border-bottom pb-2">
                                                <strong><?php echo $row->nama_kegiatan; ?></strong> (<?php echo $row->tahun; ?>)<br>
                                                <small><?php echo $row->deskripsi_prestasi; ?></small><br>
                                                <button onclick="ubah_informasi_prestasi(<?php echo $row->id_startup_prestasi; ?>)" class="btn btn-link btn-sm p-0">Edit</button>
                                            </div>
                                        <?php } } ?>
                                    </div>
                                </div>

                                <!-- Tab daftar mentor yang membimbing startup -->
                                <div class="tab-pane" id="mentor">
                                    <h5 class="mb-3 bg-light p-2">
                                        <a type="button" onclick="tambah_informasi_mentor()" class="btn btn-primary btn-xs float-end" style="margin-top:-5px;"><i class="mdi mdi-plus"></i></a>
                                        <i class="mdi mdi-account-star me-1"></i> MENTOR
                                    </h5>
                                    <ul class="list-group list-group-flush">
                                        <?php if(!empty($data_mentor)){ foreach($data_mentor as $row){ ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?php echo $row->nama_lengkap; ?>
                                                <button onclick="hapus_informasi_mentor(<?php echo $row->id_startup_mentor; ?>)" class="btn btn-danger btn-xs"><i class="mdi mdi-close"></i></button>
                                            </li>
                                        <?php } } ?>
                                    </ul>
                                </div>

                                <!-- Tab riwayat perubahan status startup -->
                                <div class="tab-pane" id="aktifitas">
                                    <ul class="list-unstyled timeline-sm">
                                        <?php if(!empty($data_histori)){ foreach($data_histori as $row){ ?>
                                            <li class="timeline-sm-item">
                                                <span class="timeline-sm-date"><?php echo date("d-m-Y H:i", strtotime($row->tgl_buat)); ?></span>
                                                <h5 class="mt-0 text-uppercase"><?php echo $row->status_startup; ?></h5>
                                                <p><small>Oleh: <?php echo $row->nama_lengkap; ?></small><br><?php echo $row->catatan; ?></p>
                                            </li>
                                        <?php } } ?>
                                    </ul>
                                </div>

                                <!-- Tab peta lokasi startup (Leaflet, dimuat saat tab aktif) -->
                                <div class="tab-pane" id="lokasi">
                                    <h5 class="mb-3 bg-light p-2"><i class="mdi mdi-map-marker me-1"></i> LOKASI PERUSAHAAN</h5>
                                    <?php if (!empty($data[0]['latitude']) && !empty($data[0]['longitude'])): ?>
                                        <div id="map-detail" style="height:400px;border-radius:10px;border:1px solid var(--slate-200);z-index:0;"></div>
                                        <p class="mt-2" style="font-size:12px;color:var(--slate-400);">
                                            <i class="mdi mdi-map-marker"></i> Lat: <?= $data[0]['latitude'] ?>, Lng: <?= $data[0]['longitude'] ?>
                                        </p>
                                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
                                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                                        <script>
                                            document.querySelector('a[href="#lokasi"]').addEventListener('shown.bs.tab', function() {
                                                if (window.mapDetail) return;
                                                window.mapDetail = L.map('map-detail').setView(
                                                    [<?= $data[0]['latitude'] ?>, <?= $data[0]['longitude'] ?>], 15
                                                );
                                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                    attribution: '&copy; OpenStreetMap'
                                                }).addTo(window.mapDetail);
                                                L.marker([<?= $data[0]['latitude'] ?>, <?= $data[0]['longitude'] ?>])
                                                    .addTo(window.mapDetail)
                                                    .bindPopup('<b><?= esc($data[0]['nama_perusahaan']) ?></b><br><?= esc($data[0]['alamat'] ?? '') ?>')
                                                    .openPopup();
                                            });
                                        </script>
                                    <?php else: ?>
                                        <div class="empty-state" style="padding: 64px 24px;">
                                            <i data-lucide="map-pin-off" class="empty-state-icon" style="width:48px;height:48px;stroke-width:1.5"></i>
                                            <div class="empty-state-text">Titik kordinat lokasi startup belum ditentukan</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- All Modals -->

<!-- Modal form tambah/edit anggota tim startup -->
<div id="modal_tim" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_tim">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="mdi mdi-account-group me-1"></i> Data Anggota Tim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_startup" value="<?php echo $data[0]['id_startup']; ?>">
                    <input type="hidden" name="id_startup_tim" id="id_startup_tim">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan_tim" id="jabatan_tim" class="form-control" placeholder="Contoh: CEO, CTO, dll" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. WhatsApp</label>
                            <input type="text" name="no_whatsapp" id="no_whatsapp" class="form-control" placeholder="628xxxxxxxxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="email@contoh.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Perguruan Tinggi</label>
                            <input type="text" name="nama_perguruan_tinggi" id="nama_perguruan_tinggi" class="form-control" placeholder="Nama universitas">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-simpan-tim"><i class="mdi mdi-content-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal form tambah/edit produk startup -->
<div id="modal_produk" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_produk">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="mdi mdi-package-variant me-1"></i> Data Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_startup" value="<?php echo $data[0]['id_startup']; ?>">
                    <input type="hidden" name="id_startup_produk" id="id_startup_produk">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama_produk" id="nama_produk_f" class="form-control" placeholder="Nama produk" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi_produk" id="desk_produk_f" class="form-control" rows="4" placeholder="Deskripsi produk..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal form alasan penolakan startup -->
<div id="modal_tolak" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_tolak">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="mdi mdi-close-circle me-1 text-danger"></i> Tolak Startup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_startup" id="tolak_id_s">
                    <input type="hidden" name="id_pengguna" id="tolak_id_p">
                    <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea name="catatan_tolak" class="form-control" rows="5" required placeholder="Tuliskan alasan penolakan..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="mdi mdi-close me-1"></i> Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal form tambah mentor ke startup -->
<div id="modal_mentor" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_mentor">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="mdi mdi-account-star me-1"></i> Tambah Mentor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_startup" value="<?php echo $data[0]['id_startup']; ?>">
                    <label class="form-label fw-semibold">Pilih Mentor <span class="text-danger">*</span></label>
                    <select name="id_mentor" class="form-select select2" required>
                        <option value="">-- Pilih Mentor --</option>
                        <?php foreach($all_mentor as $m){ ?>
                        <option value="<?php echo $m->id_pengguna; ?>"><?php echo $m->nama_lengkap; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-plus me-1"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    $(document).ready(function() {
        lucide.createIcons();
        // Fungsi verifikasi startup: ubah status ajuan menjadi 'Verified'
        function verifikasi_startup(id, idp){
            if(confirm('Verifikasi?')){
                $.ajax({ url: "<?php echo base_url('startup/proses_verifikasi_startup'); ?>", type:'post', data:{id_startup:id,id_pengguna:idp}, success: function(){ location.reload(); } });
            }
        }

        // Fungsi tolak startup: buka modal isian alasan penolakan
        function tolak_startup(id, idp){ $('#tolak_id_s').val(id); $('#tolak_id_p').val(idp); $('#modal_tolak').modal('show'); }

        $('#form_tolak').submit(function(){
            var forms = $('#form_tolak');
            var formData = new FormData($('#form_tolak')[0]);
            $('.submit_tolak').prop('disabled', true);
            if(forms[0].checkValidity()){
                $.ajax({ url:"<?php echo base_url('startup/proses_tolak_startup'); ?>", type:'post', data:formData, cache:false, contentType:false, processData:false,
                    success: function(msg){ var d=jQuery.parseJSON(msg); if(d.status){ $('#modal_tolak').modal('hide'); setTimeout(()=>location.reload(),1000); } }
                });
            } else { forms.addClass('was-validated'); $('.submit_tolak').prop('disabled',false); }
            return false;
        });

        // Buka modal tim dalam mode tambah (reset form, kosongkan ID)
        function tambah_informasi_tim(){ $('#form_tim')[0].reset(); $('#id_startup_tim').val(''); $('#modal_tim .modal-title').html('<i class="mdi mdi-account-plus me-1"></i> Tambah Anggota Tim'); $('#modal_tim').modal('show'); }

        // Buka modal tim dalam mode edit: ambil data tim via AJAX lalu isi ke form
        function ubah_informasi_tim(id){
            $('#modal_tim .modal-title').html('<i class="mdi mdi-account-edit me-1"></i> Edit Anggota Tim');
            $('#modal_tim').modal('show');
            $.ajax({ url:"<?php echo base_url('startup/get_startup_tim'); ?>", type:'post', data:{id_startup_tim:id},
                success: function(msg){ var d=jQuery.parseJSON(msg);
                    $('#id_startup_tim').val(d[0].id_startup_tim); $('#nama_lengkap').val(d[0].nama_lengkap);
                    $('#jabatan_tim').val(d[0].jabatan_tim); $('#jenis_kelamin').val(d[0].jenis_kelamin);
                    $('#no_whatsapp').val(d[0].no_whatsapp); $('#email').val(d[0].email);
                    $('#nama_perguruan_tinggi').val(d[0].nama_perguruan_tinggi);
                    $('#modal_tim .modal-title').html('<i class="mdi mdi-account-edit me-1"></i> Edit: '+d[0].nama_lengkap);
                }
            });
        }

        // Submit form tim: tambah atau ubah tergantung apakah id_startup_tim terisi
        $('#form_tim').submit(function(){
            var forms = $('#form_tim');
            var formData = new FormData($('#form_tim')[0]);
            $('.btn-simpan-tim').prop('disabled',true).html('<i class="mdi mdi-spin mdi-loading"></i> Loading...');
            var url = $('#id_startup_tim').val()=='' ? "<?php echo base_url('startup/proses_tambah_informasi_tim'); ?>" : "<?php echo base_url('startup/proses_ubah_informasi_tim'); ?>";
            if(forms[0].checkValidity()){
                $.ajax({ url:url, type:'post', data:formData, cache:false, contentType:false, processData:false,
                    success: function(msg){ var d=jQuery.parseJSON(msg);
                        if(d.status){ $('#modal_tim').modal('hide'); Swal.fire({icon:'success',title:'Berhasil!',text:'Data tim berhasil disimpan',showConfirmButton:false,timer:1500}).then(()=>location.reload()); }
                        else { forms.addClass('was-validated'); $('.btn-simpan-tim').prop('disabled',false).html('<i class="mdi mdi-content-save me-1"></i> Simpan'); }
                    }
                });
            } else { forms.addClass('was-validated'); $('.btn-simpan-tim').prop('disabled',false).html('<i class="mdi mdi-content-save me-1"></i> Simpan'); }
            return false;
        });

        // Konfirmasi dan hapus anggota tim via AJAX
        function hapus_informasi_tim(id){
            Swal.fire({title:'Hapus Anggota Tim?',text:'Data tidak dapat dikembalikan.',icon:'warning',showCancelButton:true,confirmButtonColor:'#d33',cancelButtonColor:'#6c757d',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'})
            .then((r)=>{ if(r.isConfirmed){
                $.ajax({ url:"<?php echo base_url('startup/proses_hapus_informasi_tim'); ?>", type:'post', data:{id_startup_tim:id},
                    success: function(msg){ var d=jQuery.parseJSON(msg);
                        Swal.fire({icon:d.status?'success':'error',title:d.status?'Berhasil!':'Gagal!',text:d.status?'Anggota tim berhasil dihapus':'Terjadi kesalahan',showConfirmButton:false,timer:1500}).then(()=>{ if(d.status) location.reload(); });
                    }
                });
            }});
        }

        // Buka modal produk dalam mode tambah
        function tambah_informasi_produk(){ $('#form_produk')[0].reset(); $('#id_startup_produk').val(''); $('#modal_produk').modal('show'); }

        // Buka modal produk dalam mode edit: ambil data produk via AJAX
        function ubah_informasi_produk(id){
            $('#modal_produk').modal('show');
            $.ajax({ url:"<?php echo base_url('startup/get_startup_produk'); ?>", type:'post', data:{id_startup_produk:id},
                success: function(msg){ var d=jQuery.parseJSON(msg);
                    $('#id_startup_produk').val(d[0].id_startup_produk); $('#nama_produk_f').val(d[0].nama_produk); $('#desk_produk_f').val(d[0].deskripsi_produk);
                }
            });
        }

        $('#form_produk').submit(function(){
            var forms = $('#form_produk');
            var formData = new FormData($('#form_produk')[0]);
            var url = $('#id_startup_produk').val()=='' ? "<?php echo base_url('startup/proses_tambah_informasi_produk'); ?>" : "<?php echo base_url('startup/proses_ubah_informasi_produk'); ?>";
            if(forms[0].checkValidity()){
                $.ajax({ url:url, type:'post', data:formData, cache:false, contentType:false, processData:false,
                    success: function(msg){ var d=jQuery.parseJSON(msg); if(d.status){ $('#modal_produk').modal('hide'); setTimeout(()=>location.reload(),1000); } }
                });
            } else { forms.addClass('was-validated'); }
            return false;
        });

        // Konfirmasi dan hapus produk via AJAX
        function hapus_informasi_produk(id){
            Swal.fire({title:'Hapus Produk?',text:'Data tidak dapat dikembalikan.',icon:'warning',showCancelButton:true,confirmButtonColor:'#d33',cancelButtonColor:'#6c757d',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'})
            .then((r)=>{ if(r.isConfirmed){
                $.ajax({ url:"<?php echo base_url('startup/proses_hapus_informasi_produk'); ?>", type:'post', data:{id_startup_produk:id},
                    success: function(msg){ var d=jQuery.parseJSON(msg);
                        Swal.fire({icon:d.status?'success':'error',title:d.status?'Berhasil!':'Gagal!',text:d.status?'Produk berhasil dihapus':'Terjadi kesalahan',showConfirmButton:false,timer:1500}).then(()=>{ if(d.status) location.reload(); });
                    }
                });
            }});
        }

        // Buka modal pendanaan ITB dalam mode tambah
        function tambah_informasi_pendanaan_itb(){ $('#modal_pendanaan_itb').modal('show'); }
        // Buka modal pendanaan ITB dalam mode edit: ambil data via AJAX
        function ubah_informasi_pendanaan_itb(id){
            $('#modal_pendanaan_itb').modal('show');
            $.ajax({ url:"<?php echo base_url('startup/get_startup_pendanaan_itb'); ?>", type:'post', data:{id_startup_pendanaan_itb:id},
                success: function(msg){ var d=jQuery.parseJSON(msg);
                    $('#id_startup_pendanaan_itb').val(d[0].id_startup_pendanaan_itb); $('#program_kegiatan_itb').val(d[0].program_kegiatan);
                    $('#tahun_itb').val(d[0].tahun); $('#jumlah_pendanaan_itb').val(d[0].jumlah_pendanaan);
                }
            });
        }
        $('#form_pendanaan_itb').submit(function(){
            var formData = new FormData($('#form_pendanaan_itb')[0]);
            var url = $('#id_startup_pendanaan_itb').val()=='' ? "<?php echo base_url('startup/proses_tambah_informasi_pendanaan_itb'); ?>" : "<?php echo base_url('startup/proses_ubah_informasi_pendanaan_itb'); ?>";
            $.ajax({ url:url, type:'post', data:formData, cache:false, contentType:false, processData:false,
                success: function(msg){ var d=jQuery.parseJSON(msg); if(d.status){ $('#modal_pendanaan_itb').modal('hide'); setTimeout(()=>location.reload(),1000); } }
            }); return false;
        });

        // Buka modal pendanaan non-ITB dalam mode tambah
        function tambah_informasi_pendanaan_non_itb(){ $('#modal_pendanaan_non_itb').modal('show'); }
        // Buka modal pendanaan non-ITB dalam mode edit: ambil data via AJAX
        function ubah_informasi_pendanaan_non_itb(id){
            $('#modal_pendanaan_non_itb').modal('show');
            $.ajax({ url:"<?php echo base_url('startup/get_startup_pendanaan_non_itb'); ?>", type:'post', data:{id_startup_pendanaan_non_itb:id},
                success: function(msg){ var d=jQuery.parseJSON(msg);
                    $('#id_startup_pendanaan_non_itb').val(d[0].id_startup_pendanaan_non_itb); $('#program_kegiatan_non_itb').val(d[0].program_kegiatan);
                    $('#nama_investor').val(d[0].nama_investor); $('#tahun_non_itb').val(d[0].tahun); $('#jumlah_pendanaan_non_itb').val(d[0].jumlah_pendanaan);
                }
            });
        }
        $('#form_pendanaan_non_itb').submit(function(){
            var formData = new FormData($('#form_pendanaan_non_itb')[0]);
            var url = $('#id_startup_pendanaan_non_itb').val()=='' ? "<?php echo base_url('startup/proses_tambah_informasi_pendanaan_non_itb'); ?>" : "<?php echo base_url('startup/proses_ubah_informasi_pendanaan_non_itb'); ?>";
            $.ajax({ url:url, type:'post', data:formData, cache:false, contentType:false, processData:false,
                success: function(msg){ var d=jQuery.parseJSON(msg); if(d.status){ $('#modal_pendanaan_non_itb').modal('hide'); setTimeout(()=>location.reload(),1000); } }
            }); return false;
        });

        // Buka modal prestasi dalam mode tambah
        function tambah_informasi_prestasi(){ $('#modal_prestasi').modal('show'); }
        // Buka modal prestasi dalam mode edit: ambil data via AJAX
        function ubah_informasi_prestasi(id){
            $('#modal_prestasi').modal('show');
            $.ajax({ url:"<?php echo base_url('startup/get_startup_prestasi'); ?>", type:'post', data:{id_startup_prestasi:id},
                success: function(msg){ var d=jQuery.parseJSON(msg);
                    $('#id_startup_prestasi').val(d[0].id_startup_prestasi); $('#nama_kegiatan').val(d[0].nama_kegiatan); $('#tahun_prestasi').val(d[0].tahun);
                }
            });
        }
        $('#form_prestasi').submit(function(){
            var formData = new FormData($('#form_prestasi')[0]);
            var url = $('#id_startup_prestasi').val()=='' ? "<?php echo base_url('startup/proses_tambah_informasi_prestasi'); ?>" : "<?php echo base_url('startup/proses_ubah_informasi_prestasi'); ?>";
            $.ajax({ url:url, type:'post', data:formData, cache:false, contentType:false, processData:false,
                success: function(msg){ var d=jQuery.parseJSON(msg); if(d.status){ $('#modal_prestasi').modal('hide'); setTimeout(()=>location.reload(),1000); } }
            }); return false;
        });

        // Buka modal tambah mentor
        function tambah_informasi_mentor(){ $('#modal_mentor').modal('show'); }
        $('#form_mentor').submit(function(){
            var formData = new FormData($('#form_mentor')[0]);
            $.ajax({ url:"<?php echo base_url('startup/proses_tambah_informasi_mentor'); ?>", type:'post', data:formData, cache:false, contentType:false, processData:false,
                success: function(msg){ var d=jQuery.parseJSON(msg); if(d.status){ $('#modal_mentor').modal('hide'); setTimeout(()=>location.reload(),1000); } }
            }); return false;
        });

        // Konfirmasi dan hapus mentor dari startup via AJAX
        function hapus_informasi_mentor(id){
            Swal.fire({title:'Hapus Mentor?',text:'Data tidak dapat dikembalikan.',icon:'warning',showCancelButton:true,confirmButtonColor:'#d33',cancelButtonColor:'#6c757d',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'})
            .then((r)=>{ if(r.isConfirmed){
                $.ajax({ url:"<?php echo base_url('startup/proses_hapus_informasi_mentor'); ?>", type:'post', data:{id_startup_mentor:id},
                    success: function(msg){ var d=jQuery.parseJSON(msg);
                        Swal.fire({icon:d.status?'success':'error',title:d.status?'Berhasil!':'Gagal!',text:d.status?'Mentor berhasil dihapus':'Terjadi kesalahan',showConfirmButton:false,timer:1500}).then(()=>{ if(d.status) location.reload(); });
                    }
                });
            }});
        }

        // Expose semua fungsi ke scope global agar bisa dipanggil dari atribut onclick HTML
        window.verifikasi_startup = verifikasi_startup;
        window.tolak_startup = tolak_startup;
        window.tambah_informasi_tim = tambah_informasi_tim;
        window.ubah_informasi_tim = ubah_informasi_tim;
        window.hapus_informasi_tim = hapus_informasi_tim;
        window.tambah_informasi_produk = tambah_informasi_produk;
        window.ubah_informasi_produk = ubah_informasi_produk;
        window.hapus_informasi_produk = hapus_informasi_produk;
        window.tambah_informasi_pendanaan_itb = tambah_informasi_pendanaan_itb;
        window.ubah_informasi_pendanaan_itb = ubah_informasi_pendanaan_itb;
        window.tambah_informasi_pendanaan_non_itb = tambah_informasi_pendanaan_non_itb;
        window.ubah_informasi_pendanaan_non_itb = ubah_informasi_pendanaan_non_itb;
        window.tambah_informasi_prestasi = tambah_informasi_prestasi;
        window.ubah_informasi_prestasi = ubah_informasi_prestasi;
        window.tambah_informasi_mentor = tambah_informasi_mentor;
        window.hapus_informasi_mentor = hapus_informasi_mentor;
    });
</script>
