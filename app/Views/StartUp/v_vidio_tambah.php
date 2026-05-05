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
                            <h4 class="header-title mb-3"><?= isset($video) ? 'Edit Video' : 'Tambah Video Baru' ?></h4>
                            <form action="<?= isset($video) ? base_url('perpustakaan/ubah_video_page') : base_url('perpustakaan/simpan_video_page') ?>" method="POST">
                                <?= csrf_field() ?>
                                <?php if (isset($video)): ?>
                                    <input type="hidden" name="id_konten_video" value="<?= esc($video->id_konten_video) ?>">
                                <?php endif; ?>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Judul Video <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="judul_video" required
                                               value="<?= esc($video->judul_video ?? '') ?>"
                                               placeholder="Masukkan judul video...">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">URL YouTube <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input type="url" class="form-control" name="url_video" required
                                               value="<?= isset($video) ? 'https://www.youtube.com/watch?v=' . esc($video->kode_video) : '' ?>"
                                               placeholder="https://www.youtube.com/watch?v=...">
                                       
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Deskripsi</label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" name="deskripsi_video" rows="3"
                                                  placeholder="Deskripsi singkat konten video..."><?= esc($video->deskripsi_video ?? '') ?></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Kategori</label>
                                    <div class="col-md-3">
                                        <select name="kategori_video" class="form-control">
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php
                                            $kategoriList = ['Bisnis & Startup','Teknologi','Marketing','Keuangan','Manajemen','Hukum & Legalitas','Desain & Produk','Motivasi','Podcast'];
                                            foreach ($kategoriList as $kat):
                                                $selected = isset($video) && $video->kategori_video === $kat ? 'selected' : '';
                                            ?>
                                                <option value="<?= esc($kat) ?>" <?= $selected ?>><?= esc($kat) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Status Akses <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select name="status_video" class="form-control" required>
                                            <option value="Publik" <?= isset($video) && $video->status_video === 'Publik' ? 'selected' : '' ?>>Publik</option>
                                            <option value="Privat" <?= isset($video) && $video->status_video === 'Privat' ? 'selected' : '' ?>>Privat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save"></i> <?= isset($video) ? 'Update Video' : 'Simpan Video' ?>
                                    </button>
                                    <a href="<?= base_url('perpustakaan/video') ?>" class="btn btn-white waves-effect waves-light">
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
