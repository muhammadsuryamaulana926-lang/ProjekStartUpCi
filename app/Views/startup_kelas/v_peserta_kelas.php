<style>
body { background-color: #f5f5f5 !important; }
.paper-card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 24px;
}
.table-paper th { background-color: #f8f9fa; font-weight: 600; border-bottom: 2px solid #dee2e6; }
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.form-control, .form-select { border-radius: 6px; border: 1px solid #cbd5e1; }
.form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-9">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-light btn-modern border">
                    <i class="mdi mdi-arrow-left"></i> Kembali ke Program
                </a>
            </div>

            <!-- Info Kelas -->
            <div class="paper-card">
                <h4 class="font-weight-bold text-dark mb-1"><?= esc($kelas['nama_kelas']) ?></h4>
                <div class="text-muted small">
                    <i class="mdi mdi-book-open-variant me-1"></i><?= esc($program['nama_program']) ?>
                    &bull; <i class="mdi mdi-calendar me-1"></i><?= date('d M Y', strtotime($kelas['tanggal'])) ?>
                    &bull; <i class="mdi mdi-clock me-1"></i><?= date('H:i', strtotime($kelas['jam_mulai'])) ?> - <?= date('H:i', strtotime($kelas['jam_selesai'])) ?>
                </div>
            </div>

            <!-- Tambah Peserta ke Kelas -->
            <div class="paper-card">
                <h5 class="font-weight-bold text-dark mb-4">Tambah Peserta ke Kelas</h5>

                <?php if (empty($belum_terdaftar)): ?>
                    <div class="text-muted small">Semua peserta program sudah terdaftar di kelas ini.</div>
                <?php else: ?>
                    <form action="<?= base_url('peserta_kelas/tambah_peserta') ?>" method="POST" class="d-flex gap-2">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                        <select class="form-select" name="nama_peserta" required>
                            <option value="">-- Pilih Peserta --</option>
                            <?php foreach ($belum_terdaftar as $p): ?>
                                <option value="<?= esc($p['nama_peserta']) ?>"><?= esc($p['nama_peserta']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-modern px-4">
                            <i class="mdi mdi-plus"></i> Tambah
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Daftar Peserta Kelas -->
            <div class="paper-card">
                <h5 class="font-weight-bold text-dark mb-4">
                    Peserta Kelas
                    <span class="badge bg-secondary ms-2"><?= count($peserta_kelas) ?></span>
                </h5>

                <div class="table-responsive">
                    <table class="table table-hover table-paper align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Peserta</th>
                                <th>Tanggal Ditambahkan</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($peserta_kelas)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada peserta di kelas ini.</td>
                            </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($peserta_kelas as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= esc($p['nama_peserta']) ?></strong></td>
                                    <td><?= date('d M Y H:i', strtotime($p['dibuat_pada'])) ?></td>
                                    <td class="text-center">
                                        <form action="<?= base_url('peserta_kelas/hapus_peserta') ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_peserta_kelas" value="<?= $p['id_peserta_kelas'] ?>">
                                            <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger rounded"
                                                onclick="return confirm('Keluarkan peserta ini dari kelas?')">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
