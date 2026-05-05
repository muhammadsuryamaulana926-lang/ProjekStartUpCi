<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Program Kewirausahaan</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Tambah Program Kewirausahaan &amp; Inkubasi Bisnis</h4>
                            <form action="" method="POST">
                                <?= csrf_field() ?>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Nama Program <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="nama_program" required placeholder="Masukkan nama program">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Penyelenggara <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="penyelenggara" required>
                                            <option value="">-- Pilih Penyelenggara --</option>
                                            <option>DKST Kota</option>
                                            <option>Dinas Koperasi</option>
                                            <option>Kementerian UMKM</option>
                                            <option>Swasta / Mitra</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Tahun Program <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="tahun_program" required>
                                            <option value="">-- Pilih Tahun --</option>
                                            <?php for ($y = date('Y') + 2; $y >= 2020; $y--): ?>
                                            <option value="<?= $y ?>"><?= $y ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Jenis Program <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="jenis_program" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            <option>Inkubasi</option>
                                            <option>Kewirausahaan</option>
                                            <option>Akselerasi</option>
                                            <option>Pelatihan</option>
                                            <option>Pendampingan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Deskripsi</label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" name="deskripsi" rows="4" placeholder="Deskripsi singkat program..."></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Periode Pendaftaran <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            <input type="text" id="tgl_daftar" name="periode_pendaftaran" class="form-control" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Periode Kegiatan <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            <input type="text" id="tgl_kegiatan" name="periode_kegiatan" class="form-control" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Total Anggaran</label>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="total_anggaran" name="total_anggaran" class="form-control" placeholder="0" inputmode="numeric">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save"></i> Simpan
                                    </button>
                                    <a href="<?= base_url('inkubasi_bisnis/program_kewirausahaan') ?>" class="btn btn-white waves-effect waves-light">
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
(function initTambahProgram() {
    if (typeof flatpickr === 'undefined') return setTimeout(initTambahProgram, 50);
    var rangeOpts = { mode: 'range', dateFormat: 'd M Y', locale: { firstDayOfWeek: 1 } };
    flatpickr('#tgl_daftar', rangeOpts);
    flatpickr('#tgl_kegiatan', rangeOpts);

    var anggaranEl = document.getElementById('total_anggaran');
    if (anggaranEl) {
        anggaranEl.addEventListener('input', function() {
            var pos = this.selectionStart, before = this.value.length;
            var val = this.value.replace(/\./g, '').replace(/\D/g, '');
            this.value = val ? parseInt(val).toLocaleString('id-ID') : '';
            var after = this.value.length;
            this.setSelectionRange(pos + (after - before), pos + (after - before));
        });
    }
})();
</script>
