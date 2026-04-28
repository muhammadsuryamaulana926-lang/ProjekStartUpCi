<style>
body { background-color: #f5f5f5 !important; }
.paper-card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 24px;
}
.program-title {
    font-size: 17px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}
.kelas-item {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px 20px;
    margin-bottom: 12px;
    transition: all 0.2s;
}
.kelas-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.07); border-color: #cbd5e1; }
.kelas-item:last-child { margin-bottom: 0; }
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-10">

            <div class="paper-card">
                <h5 class="fw-bold mb-1">Selamat datang, <?= esc(session()->get('user_name')) ?></h5>
                <p class="text-muted mb-0" style="font-size:14px;">Berikut program dan kelas yang Anda materikan.</p>
            </div>

            <?php if (empty($per_program)): ?>
            <div class="paper-card text-center text-muted py-5">
                <i class="mdi mdi-book-open-outline d-block mb-2" style="font-size:40px; color:#cbd5e1;"></i>
                <p class="mb-0">Belum ada kelas yang ditugaskan kepada Anda.</p>
            </div>
            <?php else: ?>
                <?php foreach ($per_program as $id_program => $prog): ?>
                <div class="paper-card">
                    <div class="program-title">
                        <i class="mdi mdi-folder-open-outline me-2 text-primary"></i>
                        <?= esc($prog['nama_program']) ?>
                        <span class="badge bg-primary ms-2" style="font-size:11px;"><?= count($prog['kelas']) ?> Kelas</span>
                    </div>

                    <?php foreach ($prog['kelas'] as $k): ?>
                    <div class="kelas-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold text-dark mb-1"><?= esc($k['nama_kelas']) ?></div>
                                <div class="text-muted small">
                                    <i class="mdi mdi-calendar me-1"></i><?= date('d M Y', strtotime($k['tanggal'])) ?>
                                    &nbsp;·&nbsp;
                                    <i class="mdi mdi-clock-outline me-1"></i><?= date('H:i', strtotime($k['jam_mulai'])) ?> – <?= date('H:i', strtotime($k['jam_selesai'])) ?>
                                    <?php if (!empty($k['tipe_kelas'])): ?>
                                    &nbsp;·&nbsp;
                                    <i class="mdi mdi-<?= $k['tipe_kelas'] === 'online' ? 'video' : 'map-marker' ?> me-1"></i><?= ucfirst($k['tipe_kelas']) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge <?= $k['status_kelas'] == 'aktif' ? 'bg-primary' : ($k['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?>">
                                    <?= ucfirst($k['status_kelas']) ?>
                                </span>
                                <?php if ($k['jawaban_pending'] > 0): ?>
                                <span class="badge bg-danger" title="Jawaban belum dikomentari">
                                    <i class="mdi mdi-bell"></i> <?= $k['jawaban_pending'] ?> Jawaban
                                </span>
                                <?php endif; ?>
                                <a href="<?= base_url('tugas_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-warning rounded" title="Tugas & Jawaban">
                                    <i class="mdi mdi-clipboard-check"></i>
                                </a>
                                <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-outline-secondary rounded" title="Detail & Presensi">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                                <a href="<?= base_url('materi_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-outline-secondary rounded" title="Materi">
                                    <i class="mdi mdi-folder-open"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
