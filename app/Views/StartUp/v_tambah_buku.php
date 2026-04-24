<style>
body { background-color: #f5f5f5 !important; }
.paper-wrapper { max-width: 700px; margin: 40px auto; }
.paper-form { background-color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; border-radius: 8px; padding: 40px; }
.paper-title { font-size: 24px; font-weight: 700; color: #333; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
.form-label { font-weight: 600; color: #555; margin-bottom: 8px; }
.form-control, .form-select { border-radius: 6px; border: 1px solid #cbd5e1; padding: 10px 15px; transition: all 0.3s; }
.form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
.btn-modern { padding: 10px 24px; border-radius: 6px; font-weight: 600; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
</style>

<div class="container-fluid" style="background-color:#f5f5f5; padding-bottom:50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title"><?= isset($ebook) ? 'Edit Buku Digital' : 'Tambah Buku Digital Baru' ?></h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= isset($ebook) ? base_url('perpustakaan/ubah_buku_page') : base_url('perpustakaan/simpan_buku_page') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <?php if (isset($ebook)): ?>
                    <input type="hidden" name="id_konten_ebook" value="<?= esc($ebook->id_konten_ebook) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="judul_ebook" required
                           value="<?= esc($ebook->judul_ebook ?? '') ?>"
                           placeholder="Masukkan judul buku...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Penulis / Penerbit <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="penulis_ebook" required
                           value="<?= esc($ebook->penulis_ebook ?? '') ?>"
                           placeholder="Nama penulis atau institusi penerbit">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi <span class="text-muted fw-normal">(Opsional)</span></label>
                    <textarea class="form-control" name="deskripsi_ebook" rows="3"
                              placeholder="Deskripsi singkat atau ringkasan isi buku..."><?= esc($ebook->deskripsi_ebook ?? '') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_ebook" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $kategoriList = ['Bisnis & Startup','Teknologi','Marketing','Keuangan','Manajemen','Hukum & Legalitas','Desain & Produk','Motivasi'];
                            foreach ($kategoriList as $kat):
                                $selected = isset($ebook) && $ebook->kategori_ebook === $kat ? 'selected' : '';
                            ?>
                                <option value="<?= esc($kat) ?>" <?= $selected ?>><?= esc($kat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status Akses <span class="text-danger">*</span></label>
                        <select name="status_ebook" class="form-select" required>
                            <option value="Publik" <?= isset($ebook) && $ebook->status_ebook === 'Publik' ? 'selected' : '' ?>>Publik</option>
                            <option value="Privat" <?= isset($ebook) && $ebook->status_ebook === 'Privat' ? 'selected' : '' ?>>Privat</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload File PDF <?= !isset($ebook) ? '<span class="text-danger">*</span>' : '<span class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah)</span>' ?></label>
                    <input type="file" class="form-control" name="file_ebook" accept="application/pdf" <?= !isset($ebook) ? 'required' : '' ?>>
                    <?php if(isset($ebook) && $ebook->file_ebook): ?>
                        <small class="text-primary mt-1 d-block">File tersimpan: <?= esc($ebook->file_ebook) ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label">Sampul Buku (Gambar) <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="file" class="form-control" name="sampul_ebook" accept="image/png, image/jpeg, image/jpg">
                    <small class="text-muted">Format: JPG, JPEG, PNG.</small>
                    <?php if(isset($ebook) && $ebook->sampul_ebook): ?>
                        <div class="mt-2 text-muted" style="font-size:12px;">Cover tersimpan: <?= esc($ebook->sampul_ebook) ?></div>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('v_perpustakaan') ?>" class="btn btn-light btn-modern border">Batal</a>
                    <button type="submit" class="btn btn-primary btn-modern">
                        <?= isset($ebook) ? 'Update Buku' : 'Simpan Buku' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
