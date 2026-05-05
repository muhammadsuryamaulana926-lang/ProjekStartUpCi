<style>
.paper-wrapper { max-width: 860px; margin: 40px auto; }
.paper-form {
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 40px;
}
.paper-title {
    font-size: 22px;
    font-weight: 700;
    color: #333;
    margin-bottom: 28px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 12px;
}
.form-label { font-weight: 600; color: #555; }
.form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 9px 14px;
    transition: all 0.2s;
}
.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid" style="background:#f5f5f5; padding-bottom:50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title"><i class="mdi mdi-briefcase-plus-outline me-2 text-primary"></i>Tambah Program Kewirausahaan &amp; Inkubasi Bisnis</h2>

            <form>
                <!-- Nama Program -->
                <div class="row mb-3 align-items-center">
                    <label class="col-md-3 col-form-label">Nama Program <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Masukkan nama program">
                    </div>
                </div>

                <!-- Penyelenggara -->
                <div class="row mb-3 align-items-center">
                    <label class="col-md-3 col-form-label">Penyelenggara <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select">
                            <option value="">-- Pilih Penyelenggara --</option>
                            <option>DKST Kota</option>
                            <option>Dinas Koperasi</option>
                            <option>Kementerian UMKM</option>
                            <option>Swasta / Mitra</option>
                        </select>
                    </div>
                </div>

                <!-- Tahun Program -->
                <div class="row mb-3 align-items-center">
                    <label class="col-md-3 col-form-label">Tahun Program <span class="text-danger">*</span></label>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option value="">-- Pilih Tahun --</option>
                            <?php for ($y = date('Y') + 2; $y >= 2020; $y--): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <!-- Jenis Program -->
                <div class="row mb-3 align-items-center">
                    <label class="col-md-3 col-form-label">Jenis Program <span class="text-danger">*</span></label>
                    <div class="col-md-5">
                        <select class="form-select">
                            <option value="">-- Pilih Jenis --</option>
                            <option>Inkubasi</option>
                            <option>Kewirausahaan</option>
                            <option>Akselerasi</option>
                            <option>Pelatihan</option>
                            <option>Pendampingan</option>
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="row mb-3 align-items-start">
                    <label class="col-md-3 col-form-label">Deskripsi</label>
                    <div class="col-md-9">
                        <textarea class="form-control" rows="4" placeholder="Deskripsi singkat program..."></textarea>
                    </div>
                </div>

                <!-- Periode Pendaftaran -->
                <div class="row mb-3 align-items-center">
                    <label class="col-md-3 col-form-label">Periode Pendaftaran <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text" style="cursor:pointer;" onclick="document.getElementById('tgl_daftar').focus()"><i class="mdi mdi-calendar"></i></span>
                            <input type="text" id="tgl_daftar" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <!-- Periode Kegiatan -->
                <div class="row mb-3 align-items-center">
                    <label class="col-md-3 col-form-label">Periode Kegiatan <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text" style="cursor:pointer;" onclick="document.getElementById('tgl_kegiatan').focus()"><i class="mdi mdi-calendar"></i></span>
                            <input type="text" id="tgl_kegiatan" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <!-- Total Anggaran -->
                <div class="row mb-4 align-items-center">
                    <label class="col-md-3 col-form-label">Total Anggaran</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="total_anggaran" class="form-control" placeholder="0" inputmode="numeric">
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="mdi mdi-content-save me-1"></i> Simpan
                        </button>
                        <a href="<?= base_url('inkubasi_bisnis/program_kewirausahaan') ?>" class="btn btn-secondary px-4 fw-semibold">
                            <i class="mdi mdi-arrow-left me-1"></i> Batal
                        </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
(function initTambahProgram() {
    if (typeof flatpickr === 'undefined') {
        return setTimeout(initTambahProgram, 50);
    }
    var rangeOpts = { mode: 'range', dateFormat: 'd M Y', locale: { firstDayOfWeek: 1 } };
    flatpickr('#tgl_daftar', rangeOpts);
    flatpickr('#tgl_kegiatan', rangeOpts);

    var anggaranEl = document.getElementById('total_anggaran');
    if (anggaranEl) {
        anggaranEl.addEventListener('input', function() {
            var pos = this.selectionStart;
            var before = this.value.length;
            var val = this.value.replace(/\./g, '').replace(/\D/g, '');
            this.value = val ? parseInt(val).toLocaleString('id-ID') : '';
            var after = this.value.length;
            this.setSelectionRange(pos + (after - before), pos + (after - before));
        });
    }
})();
</script>
