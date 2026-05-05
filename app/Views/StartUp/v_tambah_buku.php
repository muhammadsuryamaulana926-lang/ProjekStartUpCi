<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Perpustakaan</h4>
                    </div>
                </div>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3"><?= isset($ebook) ? 'Edit Buku Digital' : 'Tambah Buku Digital Baru' ?></h4>
                            <form action="<?= isset($ebook) ? base_url('perpustakaan/ubah_buku_page') : base_url('perpustakaan/simpan_buku_page') ?>" method="POST" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <?php if (isset($ebook)): ?>
                                    <input type="hidden" name="id_konten_ebook" value="<?= esc($ebook->id_konten_ebook) ?>">
                                <?php endif; ?>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Judul Buku <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="judul_ebook" required
                                               value="<?= esc($ebook->judul_ebook ?? '') ?>"
                                               placeholder="Masukkan judul buku...">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Penulis / Penerbit <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="penulis_ebook" required
                                               value="<?= esc($ebook->penulis_ebook ?? '') ?>"
                                               placeholder="Nama penulis atau institusi penerbit">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Deskripsi</label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" name="deskripsi_ebook" rows="3"
                                                  placeholder="Deskripsi singkat atau ringkasan isi buku..."><?= esc($ebook->deskripsi_ebook ?? '') ?></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select name="kategori_ebook" class="form-control" required>
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
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Status Akses <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select name="status_ebook" class="form-control" required>
                                            <option value="Publik" <?= isset($ebook) && $ebook->status_ebook === 'Publik' ? 'selected' : '' ?>>Publik</option>
                                            <option value="Privat" <?= isset($ebook) && $ebook->status_ebook === 'Privat' ? 'selected' : '' ?>>Privat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">
                                        File PDF <?= !isset($ebook) ? '<span class="text-danger">*</span>' : '' ?>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="file" class="form-control" name="file_ebook" accept="application/pdf" <?= !isset($ebook) ? 'required' : '' ?>>
                                        <?php if(isset($ebook) && $ebook->file_ebook): ?>
                                            <small class="text-muted">File tersimpan: <?= esc($ebook->file_ebook) ?></small>
                                        <?php else: ?>
                                            <small class="text-muted">Format: PDF.</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Sampul Buku</label>
                                    <div class="col-md-4">
                                        <input type="file" class="form-control" name="sampul_ebook" accept="image/png, image/jpeg, image/jpg">
                                        <?php if(isset($ebook) && $ebook->sampul_ebook): ?>
                                            <small class="text-muted">Cover tersimpan: <?= esc($ebook->sampul_ebook) ?></small>
                                        <?php else: ?>
                                            <small class="text-muted">Format: JPG, JPEG, PNG. (Opsional)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save"></i> <?= isset($ebook) ? 'Update Buku' : 'Simpan Buku' ?>
                                    </button>
                                    <a href="<?= base_url('v_perpustakaan') ?>" class="btn btn-white waves-effect waves-light">
                                        <i class="mdi mdi-keyboard-backspace"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->
