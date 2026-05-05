<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Program</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Tambah Program Baru</h4>
                            <form action="<?= base_url('program/simpan_program') ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Nama Program <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="nama_program" required placeholder="Masukkan nama program, misal: Inkubasi Startup 2026">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Deskripsi Program</label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" name="deskripsi" rows="5" placeholder="Penjelasan singkat mengenai program..."></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Status Program</label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="status_program">
                                            <option value="aktif">Aktif</option>
                                            <option value="selesai">Selesai</option>
                                            <option value="dibatalkan">Dibatalkan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save"></i> Simpan
                                    </button>
                                    <a href="<?= base_url('program') ?>" class="btn btn-white waves-effect waves-light">
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
