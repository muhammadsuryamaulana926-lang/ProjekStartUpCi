<style>
body { background-color: #f5f5f5 !important; }
.paper-card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 28px;
    margin-bottom: 24px;
}
.tugas-card {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
}
.tugas-header {
    background: #f8fafc;
    padding: 14px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tugas-body { padding: 20px; }
.jawaban-item {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 16px;
    margin-bottom: 10px;
    background: #fafafa;
}
.komentar-box {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 6px;
    padding: 10px 14px;
    margin-top: 8px;
    font-size: 13px;
}
.avatar-kecil { width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; color: #475569; flex-shrink: 0; }
.form-label { font-weight: 600; color: #555; }
.form-control { border-radius: 6px; border: 1px solid #cbd5e1; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
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

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="<?= base_url('presensi_kelas/detail_kelas/' . $kelas['id_kelas']) ?>" class="btn btn-light btn-modern border">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Info Kelas -->
            <div class="paper-card">
                <h4 class="font-weight-bold text-dark mb-1"><?= esc($kelas['nama_kelas']) ?></h4>
                <div class="text-muted small">
                    <i class="mdi mdi-book-open-variant me-1"></i><?= esc($program['nama_program']) ?>
                    &bull; <i class="mdi mdi-calendar me-1"></i><?= date('d M Y', strtotime($kelas['tanggal'])) ?>
                    &bull; <i class="mdi mdi-account-tie me-1"></i><?= esc($kelas['nama_dosen'] ?? '-') ?>
                </div>
            </div>

            <!-- Form Tambah Tugas (pemateri/admin) -->
            <?php if ($bisa_kelola): ?>
            <div class="paper-card">
                <h5 class="font-weight-bold text-dark mb-4">Buat Tugas Baru</h5>
                <form action="<?= base_url('tugas_kelas/simpan_tugas') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Judul Tugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" required placeholder="Contoh: Tugas 1 - Analisis Bisnis">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Instruksi / Soal</label>
                            <textarea class="form-control" name="instruksi" rows="3" placeholder="Tuliskan instruksi atau soal tugas..."></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">File Soal <small class="text-muted">(opsional)</small></label>
                            <input type="file" class="form-control" name="file_soal" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.png,.jpg">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="mdi mdi-plus"></i> Buat Tugas
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <!-- Daftar Tugas -->
            <div class="paper-card">
                <h5 class="font-weight-bold text-dark mb-4">
                    Daftar Tugas
                    <span class="badge bg-secondary ms-2"><?= count($tugas_list) ?></span>
                </h5>

                <?php if (empty($tugas_list)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="mdi mdi-clipboard-text-outline" style="font-size:48px; color:#cbd5e1;"></i>
                        <p class="mt-3">Belum ada tugas untuk kelas ini.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($tugas_list as $t): ?>
                    <div class="tugas-card">
                        <!-- Header Tugas -->
                        <div class="tugas-header">
                            <div>
                                <strong class="text-dark"><?= esc($t['judul']) ?></strong>
                                <div class="text-muted" style="font-size:11px;">
                                    Dibuat oleh <?= esc($t['dibuat_oleh']) ?> &bull; <?= date('d M Y, H:i', strtotime($t['dibuat_pada'])) ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <?php if (!empty($t['nama_file'])): ?>
                                    <a href="<?= base_url('tugas_kelas/download/tugas/' . $t['id_tugas']) ?>" class="btn btn-sm btn-outline-primary rounded">
                                        <i class="mdi mdi-download"></i> Unduh Soal
                                    </a>
                                <?php endif; ?>
                                <?php if ($bisa_kelola): ?>
                                    <form action="<?= base_url('tugas_kelas/hapus_tugas') ?>" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_tugas" value="<?= $t['id_tugas'] ?>">
                                        <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded"
                                            onclick="return confirm('Yakin hapus tugas ini?')">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="tugas-body">
                            <?php if (!empty($t['instruksi'])): ?>
                                <p class="text-dark mb-3" style="font-size:14px;"><?= nl2br(esc($t['instruksi'])) ?></p>
                            <?php endif; ?>

                            <!-- Form Submit Jawaban (peserta) -->
                            <?php
                                $jawaban_saya = $jawaban_saya[$t['id_tugas']] ?? null;
                                $is_peserta   = !$bisa_kelola;
                            ?>
                            <?php if ($is_peserta): ?>
                                <?php if ($jawaban_saya): ?>
                                    <!-- Sudah submit -->
                                    <div class="alert alert-success py-2 mb-3">
                                        <i class="mdi mdi-check-circle me-1"></i> Jawaban sudah dikumpulkan pada <?= date('d M Y, H:i', strtotime($jawaban_saya['dibuat_pada'])) ?>
                                    </div>
                                    <?php if (!empty($jawaban_saya['jawaban_teks'])): ?>
                                        <div class="bg-light rounded p-3 mb-2" style="font-size:13px;"><?= nl2br(esc($jawaban_saya['jawaban_teks'])) ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($jawaban_saya['nama_file'])): ?>
                                        <a href="<?= base_url('tugas_kelas/download/jawaban/' . $jawaban_saya['id_jawaban']) ?>" class="btn btn-sm btn-outline-success rounded mb-2">
                                            <i class="mdi mdi-download"></i> File Jawaban Saya
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($jawaban_saya['komentar'])): ?>
                                        <div class="komentar-box">
                                            <strong><i class="mdi mdi-comment-text me-1"></i>Komentar Pemateri:</strong>
                                            <div class="mt-1"><?= nl2br(esc($jawaban_saya['komentar'])) ?></div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <!-- Form submit jawaban -->
                                    <form action="<?= base_url('tugas_kelas/simpan_jawaban') ?>" method="POST" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_tugas" value="<?= $t['id_tugas'] ?>">
                                        <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                        <div class="mb-2">
                                            <label class="form-label">Jawaban</label>
                                            <textarea class="form-control" name="jawaban_teks" rows="3" placeholder="Tulis jawaban kamu di sini..."></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload File Jawaban <small class="text-muted">(opsional)</small></label>
                                            <input type="file" class="form-control" name="file_jawaban" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.png,.jpg">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-modern btn-sm">
                                            <i class="mdi mdi-send"></i> Kumpulkan Jawaban
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Daftar Jawaban (pemateri/admin) -->
                            <?php if ($bisa_kelola): ?>
                                <?php $semua = $semua_jawaban[$t['id_tugas']] ?? []; ?>
                                <div class="mt-3 border-top pt-3">
                                    <div class="fw-semibold small text-muted mb-3">
                                        Jawaban Masuk <span class="badge bg-secondary"><?= count($semua) ?></span>
                                    </div>
                                    <?php if (empty($semua)): ?>
                                        <div class="text-muted small">Belum ada jawaban masuk.</div>
                                    <?php else: ?>
                                        <?php foreach ($semua as $j): ?>
                                        <div class="jawaban-item">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="avatar-kecil"><?= strtoupper(substr($j['nama_peserta'], 0, 1)) ?></div>
                                                <div>
                                                    <strong class="small"><?= esc($j['nama_peserta']) ?></strong>
                                                    <div class="text-muted" style="font-size:11px;"><?= date('d M Y, H:i', strtotime($j['dibuat_pada'])) ?></div>
                                                </div>
                                            </div>
                                            <?php if (!empty($j['jawaban_teks'])): ?>
                                                <div class="bg-white border rounded p-2 mb-2" style="font-size:13px;"><?= nl2br(esc($j['jawaban_teks'])) ?></div>
                                            <?php endif; ?>
                                            <?php if (!empty($j['nama_file'])): ?>
                                                <a href="<?= base_url('tugas_kelas/download/jawaban/' . $j['id_jawaban']) ?>" class="btn btn-xs btn-outline-success rounded mb-2" style="font-size:12px; padding:2px 10px;">
                                                    <i class="mdi mdi-download"></i> Unduh Jawaban
                                                </a>
                                            <?php endif; ?>

                                            <!-- Komentar -->
                                            <?php if (!empty($j['komentar'])): ?>
                                                <div class="komentar-box mb-2">
                                                    <strong><i class="mdi mdi-comment-text me-1"></i>Komentar:</strong>
                                                    <div class="mt-1"><?= nl2br(esc($j['komentar'])) ?></div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Form Komentar -->
                                            <form action="<?= base_url('tugas_kelas/simpan_komentar') ?>" method="POST" class="mt-2">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id_jawaban" value="<?= $j['id_jawaban'] ?>">
                                                <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" name="komentar"
                                                        value="<?= esc($j['komentar'] ?? '') ?>"
                                                        placeholder="Tulis komentar...">
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="mdi mdi-send"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
