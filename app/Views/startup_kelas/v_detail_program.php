<style>
/* HVS Paper Style */
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
.paper-title {
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}
.paper-subtitle {
    color: #7f8c8d;
    font-size: 15px;
    line-height: 1.6;
}
.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #34495e;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
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
.kelas-card {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s;
}
.kelas-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-color: #cbd5e1;
}
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5; min-h-screen">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-10">
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="<?= base_url('program') ?>" class="btn btn-light btn-modern border">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
                

            </div>

            <!-- Header Program -->
            <div class="paper-card">
                <h1 class="paper-title"><?= esc($program['nama_program']) ?></h1>
                <p class="paper-subtitle mb-0"><?= nl2br(esc($program['deskripsi'])) ?></p>
            </div>

            <!-- List Kelas -->
            <div class="paper-card">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h3 class="m-0 font-weight-bold text-dark">Daftar Kelas</h3>
                    <?php if (in_array(session()->get('user_role'), ['admin', 'superadmin'])): ?>
                    <a href="<?= base_url('program/tambah_kelas/' . $program['id_program']) ?>" class="btn btn-primary btn-modern btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Kelas
                    </a>
                    <?php endif; ?>
                </div>

                <?php if(empty($kelas)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="mdi mdi-calendar-blank" style="font-size: 48px; color: #cbd5e1;"></i>
                        <p class="mt-3">Belum ada jadwal kelas untuk program ini.</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach($kelas as $k): ?>
                        <div class="col-md-6 mb-3">
                            <div class="kelas-card">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="font-weight-bold text-dark m-0"><?= esc($k['nama_kelas']) ?></h5>
                                    <span class="badge <?= $k['status_kelas'] == 'aktif' ? 'bg-primary' : ($k['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?>">
                                        <?= ucfirst($k['status_kelas']) ?>
                                    </span>
                                </div>
                                
                                <p class="text-muted small mb-3" style="min-height: 40px;"><?= esc($k['deskripsi']) ?></p>
                                
                                <div class="bg-light p-3 rounded mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="mdi mdi-calendar-clock text-primary me-2"></i>
                                        <strong>Jadwal:</strong> &nbsp;<?= date('d M Y', strtotime($k['tanggal'])) ?> (<?= date('H:i', strtotime($k['jam_mulai'])) ?> - <?= date('H:i', strtotime($k['jam_selesai'])) ?>)
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-account-tie text-primary me-2"></i>
                                        <strong>Dosen/Pemateri:</strong> &nbsp;<?= esc($k['nama_dosen']) ?>
                                    </div>
                                </div>

                                <?php
                                    $is_admin   = in_array(session()->get('user_role'), ['admin', 'superadmin', 'pemateri']);
                                    $jam_mulai_k  = strtotime($k['tanggal'] . ' ' . $k['jam_mulai']);
                                    $jam_selesai_k = strtotime($k['tanggal'] . ' ' . $k['jam_selesai']);
                                    $sekarang_k   = time();
                                    $bisa_akses_k = $sekarang_k >= ($jam_mulai_k - 1800) && $sekarang_k <= $jam_selesai_k;
                                    $sudah_selesai_k = $sekarang_k > $jam_selesai_k;
                                ?>
                                <div class="d-flex gap-2">
                                    <?php if($sudah_join || $is_admin): ?>
                                        <?php if($is_admin || $bisa_akses_k || $sudah_selesai_k): ?>
                                            <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-outline-secondary flex-fill btn-modern btn-sm">
                                                <i class="mdi mdi-account-group"></i> Detail & Presensi
                                            </a>
                                            <?php if(!empty($k['link_zoom']) && ($is_admin || $bisa_akses_k)): ?>
                                                <a href="<?= esc($k['link_zoom']) ?>" target="_blank" class="btn btn-primary flex-fill btn-modern">
                                                    <i class="mdi mdi-video"></i> Join Zoom
                                                </a>
                                            <?php endif; ?>
                                            <?php if(!empty($k['link_youtube'])): ?>
                                                <a href="<?= base_url('program/nonton_kelas/' . $k['id_kelas']) ?>" class="btn btn-danger flex-fill btn-modern">
                                                    <i class="mdi mdi-play-circle d-inline-block" style="font-size:16px;"></i> Rekaman Kelas
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-outline-secondary flex-fill btn-modern btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#modalBelumWaktu"
                                                data-jam="<?= date('H:i', $jam_mulai_k) ?>"
                                                data-tanggal="<?= date('d M Y', $jam_mulai_k) ?>"
                                                data-nama="<?= esc($k['nama_kelas']) ?>">
                                                <i class="mdi mdi-lock-clock"></i> Detail & Presensi
                                            </button>
                                            <?php if(!empty($k['link_zoom'])): ?>
                                                <button type="button" class="btn btn-primary flex-fill btn-modern"
                                                    data-bs-toggle="modal" data-bs-target="#modalBelumWaktu"
                                                    data-jam="<?= date('H:i', $jam_mulai_k) ?>"
                                                    data-tanggal="<?= date('d M Y', $jam_mulai_k) ?>"
                                                    data-nama="<?= esc($k['nama_kelas']) ?>">
                                                    <i class="mdi mdi-lock-clock"></i> Join Zoom
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="alert alert-warning w-100 text-center mb-0 py-2">Khusus Peserta Terdaftar</div>
                                    <?php endif; ?>
                                </div>

                                <?php if (in_array(session()->get('user_role'), ['admin', 'superadmin'])): ?>
                                <div class="mt-3 pt-3 border-top text-end">
                                    <a href="<?= base_url('peserta_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-success text-white">Peserta Hadir</a>
                                    <a href="<?= base_url('program/edit_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <a href="<?= base_url('program/hapus_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kelas ini?')">Hapus</a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- List Peserta (Hanya Admin) -->
            <?php if (in_array(session()->get('user_role'), ['admin', 'superadmin'])): ?>
            <div class="paper-card">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h3 class="m-0 font-weight-bold text-dark">Data Peserta Program</h3>
                    <a href="<?= base_url('program/tambah_peserta_program/' . $program['id_program']) ?>" class="btn btn-success btn-modern btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Peserta
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Peserta</th>
                                <th>Tanggal Bergabung</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($peserta)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada peserta tergabung.</td>
                            </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($peserta as $pst): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= esc($pst['nama_peserta']) ?></strong></td>
                                    <td><?= date('d M Y H:i', strtotime($pst['dibuat_pada'])) ?></td>
                                    <td class="text-center">
                                        <form action="<?= base_url('peserta_program/hapus_peserta_program') ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_peserta_program" value="<?= $pst['id_peserta_program'] ?>">
                                            <input type="hidden" name="id_program" value="<?= $program['id_program'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger text-white rounded" onclick="return confirm('Keluarkan peserta ini dari program?')" title="Hapus Peserta">
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
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Modal Belum Waktunya -->
<div class="modal fade" id="modalBelumWaktu" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4">
                <i class="mdi mdi-lock-clock text-warning" style="font-size:56px;"></i>
                <h5 class="fw-bold mt-3 mb-2">Kelas Belum Dibuka</h5>
                <p class="text-muted mb-1">Kelas <strong id="modalNamaKelas"></strong></p>
                <p class="text-muted">dijadwalkan pada <strong id="modalTanggalKelas"></strong> pukul <strong id="modalJamKelas"></strong> WIB.</p>
                <div class="alert alert-info py-2 mt-3">
                    <i class="mdi mdi-information-outline me-1"></i>
                    Akses kelas dibuka <strong>30 menit sebelum</strong> kelas dimulai.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('modalBelumWaktu').addEventListener('show.bs.modal', function(e) {
    var btn = e.relatedTarget;
    document.getElementById('modalNamaKelas').textContent  = btn.dataset.nama;
    document.getElementById('modalTanggalKelas').textContent = btn.dataset.tanggal;
    document.getElementById('modalJamKelas').textContent   = btn.dataset.jam;
});
</script>