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
            <script>Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 2500, showConfirmButton: false });</script>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <script>Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('error') ?>' });</script>
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


            <!-- Daftar Peserta Kelas -->
            <div class="card border">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="mdi mdi-account-group-outline me-2 text-primary"></i>Peserta yang Hadir
                        <span class="badge bg-secondary ms-2"><?= count($peserta_kelas) ?></span>
                    </h5>
                </div>
                <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Peserta</th>
                                <th>Kondisi</th>
                                <th>Waktu Presensi</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($peserta_kelas)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada peserta yang hadir.</td>
                            </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($peserta_kelas as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= esc($p['nama_peserta']) ?></strong></td>
                                    <td>
                                        <?php if (!empty($p['kondisi_hadir'])): ?>
                                            <span class="badge bg-success"><?= esc($p['kondisi_hadir']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= !empty($p['waktu_presensi']) ? date('d M Y, H:i', strtotime($p['waktu_presensi'])) : '-' ?></td>
                                    <td class="text-center">
                                        <form action="<?= base_url('peserta_kelas/hapus_peserta') ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_peserta_kelas" value="<?= $p['id_peserta_kelas'] ?>">
                                            <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger rounded"
                                                onclick="return swalConfirm(this.closest('form'))">
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
