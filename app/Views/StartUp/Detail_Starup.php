<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Startup - SIMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/sweetalert2.min.css') ?>">
    <script src="<?= base_url('js/sweetalert2.min.js') ?>"></script>
</head>
<body class="text-uppercase">
    <div class="app-wrapper" id="app-wrapper">
        
        <!-- SIDEBAR -->
        <?= view('Partials/sidebar') ?>

        <main class="app-main">
            
            <!-- TOPBAR -->
            <?= view('Partials/topbar') ?>

            <!-- CONTENT AREA -->
            <div class="app-content" style="background: rgba(248,250,252,0.3); overflow-x:hidden;" id="scroll-area">
                
                <div class="container-fluid px-0">
                    
                    <div class="row g-4">
                        
                        <!-- KOLOM KIRI: PROFIL SIDEBAR -->
                        <div class="col-12 col-lg-5" style="max-width:480px">
                            <div class="sidebar-card shadow-sm position-relative">
                                <!-- Tombol Kembali -->
                                <button onclick="window.history.back()" class="btn-back">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </button>

                                <!-- Logo -->
                                <div class="text-center mb-4">
                                    <?php if ($startup['logo_perusahaan']): ?>
                                        <img src="<?= base_url('uploads/logos/' . $startup['logo_perusahaan']) ?>" alt="Logo" style="width:160px;height:160px;object-fit:contain">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center mx-auto rounded-4" style="width:160px;height:160px;background:var(--slate-50);border:1px solid var(--slate-100);box-shadow:inset 0 2px 4px rgba(0,0,0,.05)">
                                            <span class="fw-black text-slate-200" style="font-size:3rem"><?= strtoupper(substr($startup['nama_perusahaan'], 0, 1)) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Nama Startup -->
                                <div class="text-center mb-4">
                                    <h2 class="fs-4 fw-black text-slate-900 tracking-tight text-uppercase mb-1"><?= $startup['nama_perusahaan'] ?></h2>
                                    <p class="text-xxs fw-bold text-slate-400 tracking-widest text-uppercase mb-0">Profil Entitas Bisnis</p>
                                </div>

                                <!-- Detail Info -->
                                <div class="pt-4 border-top" style="border-color:var(--slate-100) !important">
                                    <div class="mb-4">
                                        <span class="label-text">Kluster Utama</span>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php foreach($startup['klasters'] as $kl): ?>
                                                <span class="badge-custom badge-blue" style="text-transform:none;font-weight:400"><?= $kl ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="row g-4 mb-4">
                                        <div class="col-6">
                                            <span class="label-text">Tahun Berdiri</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle" style="width:6px;height:6px;background:var(--slate-400)"></div>
                                                <span style="font-weight:400;font-size:12px;color:var(--slate-600)"><?= $startup['tahun_berdiri'] ?: '-' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <span class="label-text">Tahun Daftar</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle" style="width:6px;height:6px;background:var(--slate-400)"></div>
                                                <span style="font-weight:400;font-size:12px;color:var(--slate-600)"><?= $startup['tahun_daftar'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <span class="label-text">Status Startup</span>
                                        <span class="badge-custom badge-green" style="text-transform:none;font-weight:400"><?= $startup['status_startup'] ?></span>
                                    </div>
                                    <div>
                                        <span class="label-text">Status Ajuan</span>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle animate-pulse" style="width:10px;height:10px;background:var(--primary)"></div>
                                            <span class="text-sm-custom tracking-widest" style="font-weight:400;color:var(--primary);text-transform:none"><?= $startup['status_ajuan'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KOLOM KANAN: INFORMASI DETAIL -->
                        <div class="col">
                            
                            <!-- INFORMASI STARTUP -->
                            <div class="card-premium shadow-sm mb-4">
                                <div class="card-header-custom d-flex align-items-center justify-content-between bg-white px-4">
                                    <h3 class="fw-black text-slate-900 text-uppercase tracking-mega mb-0" style="font-size:14px">STARTUP</h3>
                                </div>

                                <div class="p-4">
                                    <div class="mb-4">
                                        <h4 class="text-sm-custom fw-black text-slate-900 text-uppercase tracking-mega">Informasi Startup</h4>
                                    </div>
                                    <div class="row g-5">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <span class="label-text">Target Pemasaran</span>
                                                <p class="value-text mb-0"><?= $startup['target_pemasaran'] ?: '-' ?></p>
                                            </div>
                                            <div class="mb-4">
                                                <span class="label-text">Fokus Pelanggan</span>
                                                <p class="value-text mb-0"><?= $startup['fokus_pelanggan'] ?: '-' ?></p>
                                            </div>
                                            <div>
                                                <span class="label-text">Dosen Pembina</span>
                                                <p class="value-text mb-0" style="color:var(--primary)"><?= $startup['nama_dosen'] ?: '-' ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <span class="label-text">Alamat Lengkap Kantor</span>
                                                <p class="value-text text-slate-500 mb-0"><?= $startup['alamat'] ?: '-' ?></p>
                                            </div>
                                            <div>
                                                <span class="label-text">Program Yang Diikuti</span>
                                                <span class="badge-custom badge-slate mt-2 d-inline-block" style="text-transform:none;font-weight:400"><?= $startup['nama_program'] ?: '-' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- INFORMASI TIM -->
                                <div class="p-4 pt-0">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <h4 class="text-sm-custom fw-black text-slate-900 text-uppercase tracking-mega mb-0">Informasi Tim</h4>
                                        <button onclick="openTambahAnggotaModal()" class="btn-primary-custom" style="padding:0.5rem 1rem;font-size:8px">+ Tambah Anggota</button>
                                    </div>
                                    <div class="border" style="border-color:var(--slate-100) !important;overflow-x:auto">
                                        <table class="table-premium">
                                            <thead>
                                                <tr>
                                                    <th style="font-size:8px">No</th>
                                                    <th style="font-size:8px">Nama Lengkap</th>
                                                    <th style="font-size:8px">Jabatan</th>
                                                    <th style="font-size:8px">Jenis Kelamin</th>
                                                    <th style="font-size:8px">WhatsApp</th>
                                                    <th style="font-size:8px">Email</th>
                                                    <th style="font-size:8px">LinkedIn</th>
                                                    <th style="font-size:8px">Instagram</th>
                                                    <th style="font-size:8px">Perguruan Tinggi</th>
                                                    <th style="font-size:8px" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($tim)): ?>
                                                    <?php foreach($tim as $i => $t): ?>
                                                    <tr id="tim-row-<?= $t['id_tim'] ?>">
                                                        <td class="text-xs fw-bold text-slate-400"><?= $i + 1 ?></td>
                                                        <td class="text-xs text-slate-700" style="font-weight:400;text-transform:none"><?= $t['nama_lengkap'] ?></td>
                                                        <td>
                                                            <span class="badge-custom badge-slate" style="text-transform:none;font-weight:400"><?= $t['jabatan'] ?></span>
                                                        </td>
                                                        <td class="text-xs text-slate-600" style="font-weight:400;text-transform:none"><?= $t['jenis_kelamin'] === 'L' ? 'Laki-laki' : ($t['jenis_kelamin'] === 'P' ? 'Perempuan' : '-') ?></td>
                                                        <td class="text-xs" style="font-weight:400;color:#16a34a"><?= $t['no_whatsapp'] ?: '-' ?></td>
                                                        <td class="text-xs" style="font-weight:400;color:var(--primary);text-transform:lowercase"><?= $t['email'] ?: '-' ?></td>
                                                        <td class="text-xs text-slate-500" style="font-weight:400;text-transform:none"><?= $t['linkedin'] ?: '-' ?></td>
                                                        <td class="text-xs text-slate-500" style="font-weight:400;text-transform:none"><?= $t['instagram'] ?: '-' ?></td>
                                                        <td class="text-xs text-slate-600" style="font-weight:400;text-transform:none"><?= $t['nama_perguruan_tinggi'] ?: '-' ?></td>
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                                <button onclick="openEditTimModal(<?= $t['id_tim'] ?>, '<?= esc($t['nama_lengkap']) ?>', '<?= esc($t['jabatan']) ?>', '<?= $t['jenis_kelamin'] ?>', '<?= $t['no_whatsapp'] ?>', '<?= $t['email'] ?>', '<?= esc($t['linkedin']) ?>', '<?= esc($t['instagram']) ?>', '<?= esc($t['nama_perguruan_tinggi']) ?>')" class="btn-action">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                    </svg>
                                                                </button>
                                                                <button class="btn-action btn-danger-hover" onclick="confirmDeleteMember('<?= $t['id_tim'] ?>', '<?= $t['nama_lengkap'] ?>')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="10" class="text-center py-5 text-xxs fw-black text-slate-300 text-uppercase tracking-widest">Database tim startup sedang kosong</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?= view('Partials/footer') ?>
        </main>
    </div>

    <!-- MODAL EDIT STARTUP (Bootstrap Modal) -->
    <div class="modal fade modal-custom" id="modal-edit-startup" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Data Startup</h3>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form id="form-edit-startup" action="<?= base_url('update-startup') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_startup" value="<?= $startup['id_startup'] ?>">
                        <div class="mb-3">
                            <label class="modal-form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_perusahaan" required value="<?= esc($startup['nama_perusahaan']) ?>" class="modal-form-control">
                        </div>
                        <div class="mb-3">
                            <label class="modal-form-label">Deskripsi Bidang Usaha <span class="text-danger">*</span></label>
                            <textarea name="deskripsi_bidang_usaha" rows="2" required class="modal-form-control"><?= esc($startup['deskripsi_bidang_usaha']) ?></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="modal-form-label">Tahun Berdiri</label>
                                <input type="number" name="tahun_berdiri" value="<?= $startup['tahun_berdiri'] ?>" class="modal-form-control">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Tahun Daftar <span class="text-danger">*</span></label>
                                <select name="tahun_daftar" required class="modal-form-control">
                                    <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                                        <option value="<?= $y ?>" <?= ($startup['tahun_daftar'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="modal-form-label">Target Pemasaran</label>
                            <input type="text" name="target_pemasaran" value="<?= esc($startup['target_pemasaran']) ?>" class="modal-form-control">
                        </div>
                        <div class="mb-3">
                            <label class="modal-form-label">Fokus Pelanggan</label>
                            <input type="text" name="fokus_pelanggan" value="<?= esc($startup['fokus_pelanggan']) ?>" class="modal-form-control">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="modal-form-label">No WhatsApp</label>
                                <input type="text" name="nomor_whatsapp" value="<?= esc($startup['nomor_whatsapp']) ?>" class="modal-form-control">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Email</label>
                                <input type="email" name="email_perusahaan" value="<?= esc($startup['email_perusahaan']) ?>" class="modal-form-control" style="text-transform:lowercase">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="modal-form-label">Website</label>
                            <input type="text" name="website_perusahaan" value="<?= esc($startup['website_perusahaan']) ?>" class="modal-form-control">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="modal-form-label">LinkedIn</label>
                                <input type="text" name="linkedin_perusahaan" value="<?= esc($startup['linkedin_perusahaan']) ?>" class="modal-form-control">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Instagram</label>
                                <input type="text" name="instagram_perusahaan" value="<?= esc($startup['instagram_perusahaan']) ?>" class="modal-form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="modal-form-label">Dosen Pembina</label>
                            <select name="id_dosen_pembina" class="modal-form-control" style="text-transform:none;font-weight:400">
                                <option value="">Pilih Dosen Pembina</option>
                                <?php foreach($dosens as $dosen): ?>
                                <option value="<?= $dosen['id_dosen_pembina'] ?>" <?= ($startup['id_dosen_pembina'] == $dosen['id_dosen_pembina']) ? 'selected' : '' ?>><?= esc($dosen['nama_lengkap']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="modal-form-label">Program</label>
                            <select name="id_program" class="modal-form-control" style="text-transform:none;font-weight:400">
                                <option value="">Pilih Program</option>
                                <?php foreach($programs as $program): ?>
                                <option value="<?= $program['id_program'] ?>" <?= ($startup['id_program'] == $program['id_program']) ? 'selected' : '' ?>><?= esc($program['nama_program']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="modal-form-label">Alamat</label>
                            <textarea name="alamat" rows="2" class="modal-form-control" style="text-transform:none;font-weight:400"><?= esc($startup['alamat']) ?></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="modal-form-label">Status Startup <span class="text-danger">*</span></label>
                                <select name="status_startup" required class="modal-form-control">
                                    <option value="Aktif" <?= ($startup['status_startup'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                                    <option value="Tidak Aktif" <?= ($startup['status_startup'] == 'Tidak Aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                                    <option value="Lulus" <?= ($startup['status_startup'] == 'Lulus') ? 'selected' : '' ?>>Lulus</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Logo</label>
                                <input type="file" name="logo_perusahaan" class="modal-form-control" style="padding:6px 8px">
                            </div>
                        </div>
                        <div>
                            <label class="modal-form-label">Kluster</label>
                            <div class="row g-2 mt-1">
                                <?php foreach($klasters as $klaster): ?>
                                <div class="col-6">
                                    <label class="d-flex align-items-center gap-2 text-xs text-slate-600" style="font-weight:400;text-transform:none;cursor:pointer">
                                        <input type="checkbox" name="kluster[]" value="<?= $klaster['id_klaster'] ?>" <?= in_array($klaster['id_klaster'], $startup['selected_klasters']) ? 'checked' : '' ?> class="form-check-input" style="width:14px;height:14px">
                                        <?= esc($klaster['nama_klaster']) ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-modal-save">Simpan Perubahan</button>
                        <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH ANGGOTA (Bootstrap Modal) -->
    <div class="modal fade modal-custom" id="modal-tambah-anggota" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">Tambah Anggota</h3>
                        <p class="modal-subtitle mb-0">Profil baru</p>
                    </div>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('save-tim') ?>" method="post" id="form-tambah-anggota">
                        <input type="hidden" name="id_startup" value="<?= $startup['id_startup'] ?>">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="modal-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" required class="modal-form-control" placeholder="...">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan" required class="modal-form-control" placeholder="...">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Gender</label>
                                <select name="jenis_kelamin" class="modal-form-control">
                                    <option value="">PILIH</option>
                                    <option value="L">LAKI-LAKI</option>
                                    <option value="P">PEREMPUAN</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">WhatsApp</label>
                                <input type="text" name="no_whatsapp" class="modal-form-control" placeholder="08XX..">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Email</label>
                                <input type="email" name="email" class="modal-form-control" placeholder="e@mail.com" style="text-transform:lowercase">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">LinkedIn</label>
                                <input type="text" name="linkedin" class="modal-form-control" placeholder="...">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Instagram</label>
                                <input type="text" name="instagram" class="modal-form-control" placeholder="@..">
                            </div>
                            <div class="col-12">
                                <label class="modal-form-label">Perguruan Tinggi</label>
                                <input type="text" name="nama_perguruan_tinggi" class="modal-form-control" placeholder="...">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="form-tambah-anggota" class="btn-modal-save d-flex align-items-center justify-content-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:12px;height:12px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                        Simpan Anggota
                    </button>
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT ANGGOTA TIM (Bootstrap Modal) -->
    <div class="modal fade modal-custom" id="modal-edit-tim" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">Edit Anggota Tim</h3>
                        <p class="modal-subtitle mb-0">Perbarui data anggota</p>
                    </div>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('update-tim') ?>" method="post" id="form-edit-tim">
                        <input type="hidden" name="id_tim" id="edit_id_tim">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="modal-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" id="edit_nama_lengkap" required class="modal-form-control">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan" id="edit_jabatan" required class="modal-form-control">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Gender</label>
                                <select name="jenis_kelamin" id="edit_jenis_kelamin" class="modal-form-control">
                                    <option value="">Pilih</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">WhatsApp</label>
                                <input type="text" name="no_whatsapp" id="edit_no_whatsapp" class="modal-form-control">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Email</label>
                                <input type="email" name="email" id="edit_email" class="modal-form-control" style="text-transform:lowercase">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">LinkedIn</label>
                                <input type="text" name="linkedin" id="edit_linkedin" class="modal-form-control">
                            </div>
                            <div class="col-6">
                                <label class="modal-form-label">Instagram</label>
                                <input type="text" name="instagram" id="edit_instagram" class="modal-form-control">
                            </div>
                            <div class="col-12">
                                <label class="modal-form-label">Perguruan Tinggi</label>
                                <input type="text" name="nama_perguruan_tinggi" id="edit_perguruan_tinggi" class="modal-form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="form-edit-tim" class="btn-modal-save">Simpan Perubahan</button>
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openTambahAnggotaModal() {
            const modal = new bootstrap.Modal(document.getElementById('modal-tambah-anggota'));
            modal.show();
            setTimeout(() => {
                document.getElementById('nama_lengkap').focus();
            }, 500);
        }

        function openEditTimModal(id, nama, jabatan, jk, wa, email, linkedin, instagram, pt) {
            document.getElementById('edit_id_tim').value           = id;
            document.getElementById('edit_nama_lengkap').value     = nama;
            document.getElementById('edit_jabatan').value          = jabatan;
            document.getElementById('edit_jenis_kelamin').value    = jk;
            document.getElementById('edit_no_whatsapp').value      = wa;
            document.getElementById('edit_email').value            = email;
            document.getElementById('edit_linkedin').value         = linkedin;
            document.getElementById('edit_instagram').value        = instagram;
            document.getElementById('edit_perguruan_tinggi').value = pt;
            const modal = new bootstrap.Modal(document.getElementById('modal-edit-tim'));
            modal.show();
        }

        // Notifikasi Flashdata
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL!',
                text: '<?= session()->getFlashdata('success') ?>',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                showClass: { popup: 'swal2-show', backdrop: 'swal2-backdrop-show' },
                hideClass: { popup: 'swal2-hide', backdrop: 'swal2-backdrop-hide' },
                customClass: {
                    popup: 'rounded-4 p-4',
                    title: 'fw-black text-uppercase',
                    htmlContainer: 'text-muted text-uppercase small'
                }
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'GAGAL!',
                text: '<?= session()->getFlashdata('error') ?>',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                showClass: { popup: 'swal2-show', backdrop: 'swal2-backdrop-show' },
                hideClass: { popup: 'swal2-hide', backdrop: 'swal2-backdrop-hide' },
                customClass: {
                    popup: 'rounded-4 p-4',
                    title: 'fw-black text-uppercase',
                    htmlContainer: 'text-muted text-uppercase small'
                }
            });
        <?php endif; ?>

        function confirmDeleteMember(id, name) {
            Swal.fire({
                title: 'HAPUS ANGGOTA?',
                text: "Anda akan menghapus " + name + " dari tim startup ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0061FF',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'YA, HAPUS!',
                cancelButtonText: 'BATAL',
                reverseButtons: true,
                showClass: { popup: 'swal2-show', backdrop: 'swal2-backdrop-show' },
                hideClass: { popup: 'swal2-hide', backdrop: 'swal2-backdrop-hide' },
                customClass: {
                    popup: 'rounded-4 p-4',
                    title: 'fw-black text-uppercase',
                    htmlContainer: 'text-muted text-uppercase small',
                    confirmButton: 'btn btn-primary px-4 py-2 fw-bold text-uppercase small',
                    cancelButton: 'btn btn-light px-4 py-2 fw-bold text-uppercase small text-muted'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('delete-tim') ?>/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            if(response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1000,
                                    customClass: { popup: 'rounded-4 p-4', title: 'fw-black text-uppercase', htmlContainer: 'text-muted text-uppercase small' }
                                });
                                // Hapus baris dari tabel
                                $('#tim-row-' + id).fadeOut(400, function(){ $(this).remove(); });
                            } else {
                                Swal.fire('Error', response.message || 'Gagal menghapus data', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
                        }
                    });
                }
            })
        }

        // JQUERY AJAX UNTUK SEMUA FORM (Tambah Tim, Edit Tim, Edit Startup)
        $(document).ready(function() {
            function handleAjaxForm(formId, modalId) {
                $(formId).on('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    let actionUrl = $(this).attr('action');

                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $(modalId).modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1000,
                                    customClass: { popup: 'rounded-4 p-4', title: 'fw-black text-uppercase', htmlContainer: 'text-muted text-uppercase small' }
                                }).then(() => {
                                    location.reload(); // Reload halaman untuk memuat data terbaru
                                });
                            } else {
                                Swal.fire('Error', response.message || 'Gagal menyimpan data', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                        }
                    });
                });
            }

            // Terapkan ke semua form modal
            handleAjaxForm('#form-tambah-anggota', '#modal-tambah-anggota');
            handleAjaxForm('#form-edit-tim', '#modal-edit-tim');
            handleAjaxForm('#form-edit-startup', '#modal-edit-startup');
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>
