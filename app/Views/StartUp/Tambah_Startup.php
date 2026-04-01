<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Startup - SIMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
</head>
<body>
    
    <!-- TOPBAR SAJA (TANPA SIDEBAR) -->
    <?= view('Partials/topbar') ?>

    <main style="max-width:995px; margin:0 auto; padding: 0 1.5rem 8rem; margin-top:3rem;">
        
        <div class="mb-5 text-center">
            <h1 class="fw-black fs-3 text-slate-900 tracking-tight">Tambah Startup Baru</h1>
            <p class="text-slate-500 mt-2">Silahkan lengkapi informasi startup Anda pada formulir di bawah ini.</p>
        </div>

        <div class="form-card p-4 p-md-5">
            <form action="<?= base_url('save-startup') ?>" method="post" enctype="multipart/form-data">
                
                <!-- Nama Perusahaan -->
                <div class="form-row-custom">
                    <div>
                        <label class="form-label-custom">Nama Perusahaan <span class="text-danger fw-bold">*</span></label>
                        <p class="text-slate-400 mt-1" style="font-size:12px">Nama resmi entitas bisnis</p>
                    </div>
                    <input type="text" name="nama_perusahaan" required class="form-control-custom" placeholder="Masukkan nama perusahaan">
                </div>

                <!-- Deskripsi -->
                <div class="form-row-custom">
                    <div>
                        <label class="form-label-custom">Deskripsi Bidang Usaha <span class="text-danger fw-bold">*</span></label>
                        <p class="text-slate-400 mt-1" style="font-size:12px">Jelaskan secara singkat apa yang dilakukan startup Anda</p>
                    </div>
                    <textarea name="deskripsi_bidang_usaha" rows="4" required class="form-control-custom" placeholder="Tuliskan deskripsi startup Anda..."></textarea>
                </div>

                <!-- Kluster -->
                <div class="form-row-custom">
                    <div>
                        <label class="form-label-custom">Pilih Kluster <span class="text-danger fw-bold">*</span></label>
                        <p class="text-slate-400 mt-1" style="font-size:12px">Pilih satu atau lebih kategori yang sesuai</p>
                    </div>
                    <div class="row g-3">
                        <?php foreach($klasters as $klaster): ?>
                        <div class="col-6">
                            <label class="checkbox-label-custom">
                                <input type="checkbox" name="kluster[]" value="<?= $klaster['id_klaster'] ?>" class="form-check-input" style="width:16px;height:16px">
                                <?= esc($klaster['nama_klaster']) ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tahun Berdiri -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Tahun Berdiri</label>
                    <input type="number" name="tahun_berdiri" class="form-control-custom" placeholder="2024">
                </div>

                <!-- Target Pemasaran -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Target Pemasaran</label>
                    <input type="text" name="target_pemasaran" class="form-control-custom" placeholder="Contoh: B2B, B2C, Government">
                </div>

                <!-- Fokus Pelanggan -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Fokus Pelanggan</label>
                    <input type="text" name="fokus_pelanggan" class="form-control-custom" placeholder="Contoh: Mahasiswa, Petani, UMKM">
                </div>

                <!-- Dosen Pembina -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Dosen Pembina</label>
                    <div>
                        <select name="id_dosen_pembina" class="form-control-custom">
                            <option value="">Pilih Dosen Pembina</option>
                            <?php foreach($dosens as $dosen): ?>
                            <option value="<?= $dosen['id_dosen_pembina'] ?>"><?= esc($dosen['nama_lengkap']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-slate-400 mt-2" style="font-size:11px;font-style:italic">Jika tidak ditemukan, silahkan <a href="#" class="text-primary-custom fw-semibold text-decoration-underline">daftarkan dosen pembina</a> dulu</p>
                    </div>
                </div>

                <!-- Program -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Program Yang Diikuti</label>
                    <select name="id_program" class="form-control-custom">
                        <option value="">Pilih Program</option>
                        <?php foreach($programs as $program): ?>
                        <option value="<?= $program['id_program'] ?>"><?= esc($program['nama_program']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Alamat</label>
                    <textarea name="alamat" rows="3" class="form-control-custom" placeholder="Tuliskan alamat lengkap kantor..."></textarea>
                </div>

                <div class="row g-4 py-3">
                    <!-- WhatsApp -->
                    <div class="col-md-6">
                        <label class="form-label-custom">Nomor WhatsApp</label>
                        <input type="text" name="nomor_whatsapp" class="form-control-custom" placeholder="08XXXXXXXXXX">
                    </div>
                    <!-- Email Perusahaan -->
                    <div class="col-md-6">
                        <label class="form-label-custom">Email Perusahaan</label>
                        <input type="email" name="email_perusahaan" class="form-control-custom" placeholder="email@perusahaan.com">
                    </div>
                </div>

                <div class="row g-4 py-3">
                    <!-- Website -->
                    <div class="col-md-4">
                        <label class="form-label-custom">Website Perusahaan</label>
                        <input type="text" name="website_perusahaan" class="form-control-custom" placeholder="https://...">
                    </div>
                    <!-- LinkedIn -->
                    <div class="col-md-4">
                        <label class="form-label-custom">LinkedIn Perusahaan</label>
                        <input type="text" name="linkedin_perusahaan" class="form-control-custom" placeholder="Link">
                    </div>
                    <!-- Instagram -->
                    <div class="col-md-4">
                        <label class="form-label-custom">Instagram Perusahaan</label>
                        <input type="text" name="instagram_perusahaan" class="form-control-custom" placeholder="@username">
                    </div>
                </div>

                <!-- Logo -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Logo Perusahaan</label>
                    <div>
                        <input type="file" name="logo_perusahaan" class="form-control-custom" style="padding:6px 8px">
                        <p class="text-slate-400 mt-1" style="font-size:11px">Mendukung: JPG, JPEG, PNG (Maks 2MB)</p>
                    </div>
                </div>

                <!-- Tahun Daftar -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Tahun Daftar <span class="text-danger fw-bold">*</span></label>
                    <select name="tahun_daftar" required class="form-control-custom">
                        <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Status Startup -->
                <div class="form-row-custom">
                    <label class="form-label-custom">Status Startup <span class="text-danger fw-bold">*</span></label>
                    <select name="status_startup" required class="form-control-custom">
                        <option value="Aktif" selected>Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="d-flex align-items-center justify-content-end gap-3 pt-5">
                    <a href="javascript:history.back()" class="btn btn-light px-4 py-2 fw-semibold">
                        Batal
                    </a>
                    <button type="submit" class="btn-submit-primary d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Simpan Data Startup
                    </button>
                </div>

            </form>

            <!-- FOOTER -->
            <div class="mt-5 pt-4 border-top" style="border-color: var(--slate-100) !important">
                <?= view('Partials/footer') ?>
            </div>
        </div>

        <div style="height:80px"></div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
