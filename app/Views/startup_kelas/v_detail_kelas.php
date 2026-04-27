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
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.info-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-size: 14px; color: #475569; }
.info-row strong { color: #1e293b; }
.peserta-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 8px; }
.avatar-kecil { width: 34px; height: 34px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; color: #475569; flex-shrink: 0; }
.form-control { border-radius: 6px; border: 1px solid #cbd5e1; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
.countdown-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px 20px; text-align: center; }
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
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h4 class="font-weight-bold text-dark mb-0"><?= esc($kelas['nama_kelas']) ?></h4>
                    <span class="badge <?= $kelas['status_kelas'] == 'aktif' ? 'bg-primary' : ($kelas['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?> px-3 py-2">
                        <?= ucfirst($kelas['status_kelas']) ?>
                    </span>
                </div>

                <?php if (!empty($kelas['deskripsi'])): ?>
                    <p class="text-muted small mb-3"><?= esc($kelas['deskripsi']) ?></p>
                <?php endif; ?>

                <div class="info-row"><i class="mdi mdi-book-open-variant text-primary"></i><strong>Program:</strong> <?= esc($program['nama_program']) ?></div>
                <div class="info-row"><i class="mdi mdi-calendar text-primary"></i><strong>Tanggal:</strong> <?= date('d M Y', strtotime($kelas['tanggal'])) ?></div>
                <div class="info-row"><i class="mdi mdi-clock text-primary"></i><strong>Waktu:</strong> <?= date('H:i', strtotime($kelas['jam_mulai'])) ?> - <?= date('H:i', strtotime($kelas['jam_selesai'])) ?> WIB</div>
                <?php if (!empty($kelas['nama_dosen'])): ?>
                <div class="info-row"><i class="mdi mdi-account-tie text-primary"></i><strong>Pemateri:</strong> <?= esc($kelas['nama_dosen']) ?></div>
                <?php endif; ?>
                <?php if (!empty($kelas['tipe_kelas'])): ?>
                <div class="info-row"><i class="mdi mdi-laptop text-primary"></i><strong>Tipe:</strong> <?= ucfirst($kelas['tipe_kelas']) ?>
                    <?php if ($kelas['tipe_kelas'] === 'online' && !empty($kelas['platform_online'])): ?>
                        — <?= esc($kelas['platform_online']) ?>
                    <?php elseif ($kelas['tipe_kelas'] === 'offline' && !empty($kelas['lokasi_offline'])): ?>
                        — <?= esc($kelas['lokasi_offline']) ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php
                $jam_mulai   = strtotime($kelas['tanggal'] . ' ' . $kelas['jam_mulai']);
                $jam_selesai = strtotime($kelas['tanggal'] . ' ' . $kelas['jam_selesai']);
                $sekarang    = time();
                $buka_presensi = $jam_mulai - 1800; // 30 menit sebelum
            ?>

            <!-- Section untuk peserta (bukan admin) -->
            <?php if (!$bisa_kelola && $sudah_join): ?>

                <?php if ($sekarang < $buka_presensi): ?>
                <!-- Belum waktunya -->
                <div class="paper-card text-center">
                    <div class="countdown-box mb-3">
                        <div class="text-muted small mb-1">Presensi dibuka dalam</div>
                        <div id="countdown" class="fw-bold text-primary" style="font-size:2rem; letter-spacing:2px;">--:--:--</div>
                        <div class="text-muted small mt-1">Presensi dibuka 30 menit sebelum kelas dimulai</div>
                    </div>
                </div>

                <?php elseif ($sekarang > $jam_selesai): ?>
                <!-- Kelas sudah selesai -->
                <div class="paper-card text-center py-4">
                    <i class="mdi mdi-check-circle text-success" style="font-size:48px;"></i>
                    <p class="mt-3 text-muted">Kelas telah selesai.</p>
                </div>

                <?php elseif ($sudah_presensi): ?>
                <!-- Sudah presensi — tampilkan akses kelas -->
                <div class="paper-card">
                    <div class="alert alert-success mb-4">
                        <i class="mdi mdi-check-circle me-2"></i> Anda sudah melakukan presensi. Silakan akses kelas.
                    </div>
                    <div class="d-flex gap-3 flex-wrap">
                        <?php if (!empty($kelas['link_meeting'])): ?>
                            <a href="<?= esc($kelas['link_meeting']) ?>" target="_blank" class="btn btn-primary btn-modern px-4">
                                <i class="mdi mdi-video"></i> Masuk Kelas (<?= esc($kelas['platform_online'] ?? 'Online') ?>)
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($kelas['link_zoom'])): ?>
                            <a href="<?= esc($kelas['link_zoom']) ?>" target="_blank" class="btn btn-primary btn-modern px-4">
                                <i class="mdi mdi-video"></i> Join Zoom
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($kelas['link_youtube'])): ?>
                            <a href="<?= base_url('program/nonton_kelas/' . $kelas['id_kelas']) ?>" class="btn btn-danger btn-modern px-4">
                                <i class="mdi mdi-play-circle"></i> Rekaman Kelas
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('materi_kelas/' . $kelas['id_kelas']) ?>" class="btn btn-outline-secondary btn-modern px-4">
                            <i class="mdi mdi-folder-open"></i> Materi Kelas
                        </a>
                        <a href="<?= base_url('tugas_kelas/' . $kelas['id_kelas']) ?>" class="btn btn-outline-warning btn-modern px-4">
                            <i class="mdi mdi-clipboard-text"></i> Tugas
                        </a>
                    </div>
                </div>

                <?php else: ?>
                <!-- Form Presensi -->
                <div class="paper-card">
                    <h5 class="font-weight-bold text-dark mb-1">Form Presensi</h5>
                    <p class="text-muted small mb-4">Isi form presensi terlebih dahulu untuk mengakses kelas.</p>

                    <form action="<?= base_url('presensi_kelas/simpan_presensi') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                        <input type="hidden" name="id_program" value="<?= esc($program['id_program']) ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" class="form-control" value="<?= esc($nama_peserta) ?>" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kondisi Kehadiran <span class="text-danger">*</span></label>
                            <select class="form-control" name="kondisi_hadir" required>
                                <option value="">-- Pilih --</option>
                                <option value="Hadir">Hadir</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Catatan <small class="text-muted">(opsional)</small></label>
                            <textarea class="form-control" name="catatan" rows="2" placeholder="Contoh: Hadir dari kantor, dll..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-modern px-5">
                            <i class="mdi mdi-check"></i> Konfirmasi Presensi & Akses Kelas
                        </button>
                    </form>
                </div>
                <?php endif; ?>

            <?php elseif (!$bisa_kelola && !$sudah_join): ?>
            <div class="paper-card text-center py-4">
                <p class="text-muted">Anda harus bergabung ke program ini untuk mengakses kelas.</p>
                <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-primary btn-modern">Gabung Program</a>
            </div>
            <?php endif; ?>

            <!-- Daftar Presensi -->
            <div class="paper-card">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h5 class="font-weight-bold text-dark m-0">
                        Daftar Hadir
                        <span class="badge bg-secondary ms-2"><?= count($presensi) ?> orang</span>
                    </h5>
                </div>

                <?php if (empty($presensi)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="mdi mdi-account-group-outline" style="font-size:40px; color:#cbd5e1;"></i>
                        <p class="mt-2 small">Belum ada peserta yang presensi.</p>
                    </div>
                <?php else: ?>
                    <?php $no = 1; foreach ($presensi as $p): ?>
                    <div class="peserta-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-kecil"><?= strtoupper(substr($p['nama_peserta'], 0, 1)) ?></div>
                            <div>
                                <div class="fw-semibold small text-dark"><?= esc($p['nama_peserta']) ?></div>
                                <?php if (!empty($p['kondisi_hadir'])): ?>
                                    <span class="badge <?= $p['kondisi_hadir'] === 'Hadir Langsung' ? 'bg-success' : 'bg-primary' ?> mt-1" style="font-size:10px;">
                                        <?= esc($p['kondisi_hadir']) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($p['catatan'])): ?>
                                    <div class="text-muted" style="font-size:12px;"><?= esc($p['catatan']) ?></div>
                                <?php endif; ?>
                                <div class="text-muted" style="font-size:11px;"><?= date('d M Y, H:i', strtotime($p['dibuat_pada'])) ?></div>
                            </div>
                        </div>
                        <?php if ($bisa_kelola): ?>
                        <form action="<?= base_url('presensi_kelas/hapus_presensi') ?>" method="POST" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_presensi" value="<?= $p['id_presensi'] ?>">
                            <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded"
                                onclick="return confirm('Hapus presensi ini?')" title="Hapus">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Akses kelas untuk admin -->
            <?php if ($bisa_kelola): ?>
            <div class="paper-card">
                <h5 class="font-weight-bold text-dark mb-3">Akses Kelas</h5>
                <div class="d-flex gap-3 flex-wrap">
                    <?php if (!empty($kelas['link_meeting'])): ?>
                        <a href="<?= esc($kelas['link_meeting']) ?>" target="_blank" class="btn btn-primary btn-modern">
                            <i class="mdi mdi-video"></i> <?= esc($kelas['platform_online'] ?? 'Link Meeting') ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($kelas['link_zoom'])): ?>
                        <a href="<?= esc($kelas['link_zoom']) ?>" target="_blank" class="btn btn-primary btn-modern">
                            <i class="mdi mdi-video"></i> Join Zoom
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($kelas['link_youtube'])): ?>
                        <a href="<?= base_url('program/nonton_kelas/' . $kelas['id_kelas']) ?>" class="btn btn-danger btn-modern">
                            <i class="mdi mdi-play-circle"></i> Rekaman Kelas
                        </a>
                    <?php endif; ?>
                    <a href="<?= base_url('materi_kelas/' . $kelas['id_kelas']) ?>" class="btn btn-outline-secondary btn-modern">
                        <i class="mdi mdi-folder-open"></i> Materi Kelas
                    </a>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php if ($sekarang < $buka_presensi && !$bisa_kelola && $sudah_join): ?>
<script>
var target = <?= $buka_presensi * 1000 ?>;
function update_countdown() {
    var sisa = Math.max(0, Math.floor((target - Date.now()) / 1000));
    var j = Math.floor(sisa / 3600);
    var m = Math.floor((sisa % 3600) / 60);
    var s = sisa % 60;
    document.getElementById('countdown').textContent =
        String(j).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    if (sisa <= 0) location.reload();
}
update_countdown();
setInterval(update_countdown, 1000);
</script>
<?php endif; ?>
