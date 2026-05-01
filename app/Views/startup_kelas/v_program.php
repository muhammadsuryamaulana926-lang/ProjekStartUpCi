<style>
/* HVS Paper Style Form & Card */
body {
    background-color: #f5f5f5 !important;
}
.paper-card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 30px;
}
.paper-container {
    max-width: 900px;
    margin: 40px auto;
}
.table-paper th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}
.btn-modern {
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5; min-h-screen">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-10">

            <?php if (session()->getFlashdata('success')): ?>
            <script>Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 2500, showConfirmButton: false });</script>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <script>Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('error') ?>' });</script>
            <?php endif; ?>

            <?php if (in_array(session()->get('user_role'), ['admin', 'superadmin'])): ?>
                <!-- TAMPILAN ADMIN (TABEL) -->
                <div class="card border">
                    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                        <h5 class="mb-0 fw-bold"><i class="mdi mdi-book-open-outline me-2 text-primary"></i>Daftar Program</h5>
                        <a href="<?= base_url('program/tambah_program') ?>" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Tambah Program
                        </a>
                    </div>
                    <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Nama Program</th>
                                    <th width="15%" class="text-center">Total Kelas</th>
                                    <th width="15%" class="text-center">Total Peserta</th>
                                    <th width="20%">Status</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($program)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data program</td>
                                </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach($program as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= esc($p['nama_program']) ?></strong>
                                            <div class="small text-muted" style="max-width:250px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= esc($p['deskripsi']) ?></div>
                                        </td>
                                        <td class="text-center"><?= $p['jumlah_kelas'] ?> Kelas</td>
                                        <td class="text-center"><?= $p['jumlah_peserta'] ?> Orang</td>
                                        <td>
                                            <?php
                                                $sp = $p['status_program'] ?? 'aktif';
                                                $badge = $sp == 'aktif' ? 'bg-success' : ($sp == 'selesai' ? 'bg-primary' : 'bg-danger');
                                            ?>
                                            <span class="badge <?= $badge ?> px-3 py-2"><?= ucfirst($sp) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= base_url('program/detail_program/' . $p['id_program']) ?>" class="btn btn-sm btn-info text-white me-1 rounded" title="Lihat Detail">
                                                    <i class="mdi mdi-eye"></i> Detail
                                                </a>
                                                <a href="<?= base_url('program/edit_program/' . $p['id_program']) ?>" class="btn btn-sm btn-warning text-white me-1 rounded" title="Edit Program">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('program/hapus_program/' . $p['id_program']) ?>" class="btn btn-sm btn-danger rounded"
                                                    onclick="event.preventDefault(); Swal.fire({title:'Yakin?',text:'Program akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonColor:'#d33',cancelButtonColor:'#6c757d',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'}).then(r=>{ if(r.isConfirmed) window.location.href=this.href; });"
                                                    title="Hapus Program">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- TAMPILAN PESERTA: semua program tampil, kelas hanya untuk yang sudah join -->
                <div class="mb-4">
                    <h2 class="font-weight-bold text-dark m-0" style="font-size:24px;">Program Kelas</h2>
                    <p class="text-muted mt-1" style="font-size:14px;">Daftar semua program yang tersedia.</p>
                </div>

                <?php if(empty($program)): ?>
                    <div class="text-center py-5">
                        <i class="mdi mdi-clipboard-text-outline" style="font-size:64px; color:#cbd5e1;"></i>
                        <p class="mt-3 text-muted">Belum ada program yang tersedia.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($program as $p): ?>
                    <div class="paper-card mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($p['nama_program']) ?></h5>
                                <p class="text-muted small mb-0" style="max-width:600px;"><?= esc($p['deskripsi']) ?></p>
                            </div>
                            <?php if ($p['sudah_join']): ?>
                                <span class="badge bg-success px-3 py-2">Tergabung</span>
                            <?php else: ?>
                                <span class="badge bg-secondary px-3 py-2">Belum Tergabung</span>
                            <?php endif; ?>
                        </div>

                        <?php if ($p['sudah_join']): ?>
                            <?php if (empty($p['kelas'])): ?>
                                <div class="text-center text-muted py-3" style="font-size:13px;">
                                    <i class="mdi mdi-calendar-blank me-1"></i> Belum ada kelas untuk program ini.
                                </div>
                            <?php else: ?>
                                <div class="row g-3 mt-1">
                                <?php foreach ($p['kelas'] as $k):
                                    $jam_mulai_k   = strtotime($k['tanggal'] . ' ' . $k['jam_mulai']);
                                    $jam_selesai_k = strtotime($k['tanggal'] . ' ' . $k['jam_selesai']);
                                    // Kalau jam selesai lebih kecil dari jam mulai, berarti lewat tengah malam
                                    if ($jam_selesai_k <= $jam_mulai_k) {
                                        $jam_selesai_k = strtotime('+1 day', $jam_selesai_k);
                                    }
                                    $now_k         = time();
                                    $sudah_selesai = $now_k > $jam_selesai_k;
                                    $bisa_presensi = $now_k >= ($jam_mulai_k - 1800) && $now_k <= $jam_selesai_k;
                                ?>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <strong class="text-dark" style="font-size:14px;"><?= esc($k['nama_kelas']) ?></strong>
                                            <span class="badge <?= $k['status_kelas'] == 'aktif' ? 'bg-primary' : ($k['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?> ms-2">
                                                <?= ucfirst($k['status_kelas']) ?>
                                            </span>
                                        </div>
                                        <div class="text-muted small mb-3">
                                            <i class="mdi mdi-calendar me-1"></i><?= date('d M Y', strtotime($k['tanggal'])) ?>
                                            &nbsp;&middot;&nbsp;
                                            <i class="mdi mdi-clock me-1"></i><?= date('H:i', strtotime($k['jam_mulai'])) ?> &ndash; <?= date('H:i', strtotime($k['jam_selesai'])) ?>
                                            <?php if (!empty($k['nama_dosen'])): ?>
                                            &nbsp;&middot;&nbsp;
                                            <i class="mdi mdi-account-tie me-1"></i><?= esc($k['nama_dosen']) ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($sudah_selesai): ?>
                                            <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-secondary w-100 btn-modern">
                                                <i class="mdi mdi-play-circle me-1"></i> Lihat Rekaman & Materi
                                            </a>
                                        <?php elseif (!empty($k['sudah_presensi'])): ?>
                                            <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-success w-100 btn-modern">
                                                <i class="mdi mdi-check-circle me-1"></i> Sudah Presensi — Masuk Kelas
                                            </a>
                                        <?php elseif ($bisa_presensi): ?>
                                            <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-primary w-100 btn-modern">
                                                <i class="mdi mdi-arrow-right-circle me-1"></i> Masuk Kelas
                                            </a>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary w-100 btn-modern" disabled>
                                                <i class="mdi mdi-lock-clock me-1"></i> Belum Waktunya
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-muted small py-2">
                                <i class="mdi mdi-lock-outline me-1"></i> Anda belum terdaftar di program ini.
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div>


