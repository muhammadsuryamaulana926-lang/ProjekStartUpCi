<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Startup - SIMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
</head>
<body>
    
    <!-- TOPBAR SAJA -->
    <?= view('Partials/topbar') ?>

    <main style="max-width:995px; margin:0 auto; padding: 0 1.5rem 8rem; margin-top:3rem;">
        
        <div class="mb-5 text-center">
            <h1 class="fw-black fs-3 text-slate-900 tracking-tight text-uppercase">Edit Data Startup</h1>
            <p class="text-slate-500 mt-2 text-uppercase tracking-widest" style="font-size:14px">Perbaharui informasi profil startup yang sudah terdaftar.</p>
        </div>

        <div class="form-card p-4 p-md-5">
            <form action="<?= base_url('update-startup') ?>" method="post" enctype="multipart/form-data">
                
                <!-- Hidden Field ID -->
                <input type="hidden" name="id_startup" value="<?= $startup['id_startup'] ?>">

                <!-- Nama Perusahaan -->
                <div class="form-row-custom">
                    <div>
                        <label class="form-label-custom text-uppercase">Nama Perusahaan <span class="text-danger fw-bold">*</span></label>
                        <p class="text-slate-400 mt-1 text-uppercase" style="font-size:12px">Nama resmi entitas bisnis</p>
                    </div>
                    <input type="text" name="nama_perusahaan" value="<?= esc($startup['nama_perusahaan']) ?>" required class="form-control-custom" placeholder="Masukkan nama perusahaan">
                </div>

                <!-- Deskripsi -->
                <div class="form-row-custom">
                    <div>
                        <label class="form-label-custom text-uppercase">Deskripsi Bidang Usaha <span class="text-danger fw-bold">*</span></label>
                        <p class="text-slate-400 mt-1 text-uppercase" style="font-size:12px">Jelaskan secara singkat apa yang dilakukan</p>
                    </div>
                    <textarea name="deskripsi_bidang_usaha" rows="4" required class="form-control-custom" placeholder="Tuliskan deskripsi startup Anda..."><?= esc($startup['deskripsi_bidang_usaha']) ?></textarea>
                </div>

                <!-- Kluster -->
                <div class="form-row-custom">
                    <div>
                        <label class="form-label-custom text-uppercase">Pilih Kluster <span class="text-danger fw-bold">*</span></label>
                        <p class="text-slate-400 mt-1 text-uppercase" style="font-size:12px">Pilih satu atau lebih kategori</p>
                    </div>
                    <div class="row g-3">
                        <?php foreach($klasters as $klaster): ?>
                        <div class="col-6">
                            <label class="checkbox-label-custom text-uppercase">
                                <input type="checkbox" name="kluster[]" value="<?= $klaster['id_klaster'] ?>" 
                                    <?= in_array($klaster['id_klaster'], $startup['selected_klasters']) ? 'checked' : '' ?>
                                    class="form-check-input" style="width:16px;height:16px">
                                <?= esc($klaster['nama_klaster']) ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tahun Berdiri -->
                <div class="form-row-custom">
                    <label class="form-label-custom text-uppercase">Tahun Berdiri</label>
                    <input type="number" name="tahun_berdiri" value="<?= $startup['tahun_berdiri'] ?>" class="form-control-custom" placeholder="2024">
                </div>

                <!-- Target Pemasaran -->
                <div class="form-row-custom">
                    <label class="form-label-custom text-uppercase">Target Pemasaran</label>
                    <input type="text" name="target_pemasaran" value="<?= esc($startup['target_pemasaran']) ?>" class="form-control-custom" placeholder="Contoh: B2B, B2C, Government">
                </div>

                <!-- Fokus Pelanggan -->
                <div class="form-row-custom">
                    <label class="form-label-custom text-uppercase">Fokus Pelanggan</label>
                    <input type="text" name="fokus_pelanggan" value="<?= esc($startup['fokus_pelanggan']) ?>" class="form-control-custom" placeholder="Contoh: Mahasiswa, Petani, UMKM">
                </div>

                <!-- Dosen Pembina -->
                <div class="form-row-custom">
                    <label class="form-label-custom text-uppercase">Dosen Pembina</label>
                    <select name="id_dosen_pembina" class="form-control-custom">
                        <option value="">Pilih Dosen Pembina</option>
                        <?php foreach($dosens as $dosen): ?>
                        <option value="<?= $dosen['id_dosen_pembina'] ?>" <?= ($startup['id_dosen_pembina'] == $dosen['id_dosen_pembina']) ? 'selected' : '' ?>>
                            <?= esc($dosen['nama_lengkap']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Program -->
                <div class="form-row-custom">
                    <label class="form-label-custom text-uppercase">Program Yang Diikuti</label>
                    <select name="id_program" class="form-control-custom">
                        <option value="">Pilih Program</option>
                        <?php foreach($programs as $program): ?>
                        <option value="<?= $program['id_program'] ?>" <?= ($startup['id_program'] == $program['id_program']) ? 'selected' : '' ?>>
                            <?= esc($program['nama_program']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="form-row-custom">
                    <label class="form-label-custom text-uppercase">Alamat</label>
                    <textarea name="alamat" rows="3" class="form-control-custom" placeholder="Tuliskan alamat lengkap kantor..."><?= esc($startup['alamat']) ?></textarea>
                </div>

                <div class="row g-4 py-3">
                    <div class="col-md-6">
                        <label class="form-label-custom text-uppercase">Nomor WhatsApp</label>
                        <input type="text" name="nomor_whatsapp" value="<?= esc($startup['nomor_whatsapp']) ?>" class="form-control-custom" placeholder="08XXXXXXXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom text-uppercase">Email Perusahaan</label>
                        <input type="email" name="email_perusahaan" value="<?= esc($startup['email_perusahaan']) ?>" class="form-control-custom" placeholder="email@perusahaan.com">
                    </div>
                </div>

                <div class="row g-4 py-3">
                    <div class="col-md-4">
                        <label class="form-label-custom text-uppercase">Website Perusahaan</label>
                        <input type="text" name="website_perusahaan" value="<?= esc($startup['website_perusahaan']) ?>" class="form-control-custom" placeholder="https://...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom text-uppercase">LinkedIn Perusahaan</label>
                        <input type="text" name="linkedin_perusahaan" value="<?= esc($startup['linkedin_perusahaan']) ?>" class="form-control-custom" placeholder="Link">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom text-uppercase">Instagram Perusahaan</label>
                        <input type="text" name="instagram_perusahaan" value="<?= esc($startup['instagram_perusahaan']) ?>" class="form-control-custom" placeholder="@username">
                    </div>
                </div>

                <!-- Logo -->
                <div class="form-row-custom">
                    <div>
                        <label class="form-label-custom text-uppercase">Logo Perusahaan</label>
                        <p class="text-slate-400 mt-1 text-uppercase" style="font-size:11px">Kosongkan jika tidak ingin mengubah</p>
                    </div>
                    <div>
                        <?php if ($startup['logo_perusahaan']): ?>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3" style="background:var(--slate-50);border:1px solid var(--slate-100);width:fit-content">
                                <img src="<?= base_url('uploads/logos/' . $startup['logo_perusahaan']) ?>" alt="Current Logo" style="width:48px;height:48px;object-fit:contain">
                                <span class="text-xxs fw-black text-slate-400 text-uppercase tracking-widest">Logo Terpasang</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="logo_perusahaan" class="form-control-custom" style="padding:6px 8px">
                    </div>
                </div>

                <!-- Tahun Daftar -->
                <div class="form-row-custom">
                    <label class="form-label-custom text-uppercase">Tahun Daftar <span class="text-danger fw-bold">*</span></label>
                    <select name="tahun_daftar" required class="form-control-custom">
                        <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                            <option value="<?= $y ?>" <?= ($startup['tahun_daftar'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Status Startup -->
                <div class="form-row-custom">
                    <label class="form-label-custom text-uppercase">Status Startup <span class="text-danger fw-bold">*</span></label>
                    <select name="status_startup" required class="form-control-custom">
                        <option value="Aktif" <?= ($startup['status_startup'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                        <option value="Non-Aktif" <?= ($startup['status_startup'] == 'Non-Aktif') ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="d-flex align-items-center justify-content-end gap-3 pt-5">
                    <a href="<?= base_url('data-startup') ?>" class="btn btn-light px-4 py-2 text-slate-400 fw-black text-xxs tracking-widest text-uppercase">
                        Batal Perubahan
                    </a>
                    <button type="submit" class="btn-submit-primary d-flex align-items-center gap-2 text-uppercase tracking-wider" style="font-size:10px;font-weight:900;box-shadow:0 10px 25px rgba(0,97,255,0.2)">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                        Simpan Perubahan Data
                    </button>
                </div>

            </form>

            <div class="mt-5 pt-4 border-top text-uppercase" style="border-color: var(--slate-100) !important">
                <?= view('Partials/footer') ?>
            </div>
        </div>

        <div style="height:80px"></div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
