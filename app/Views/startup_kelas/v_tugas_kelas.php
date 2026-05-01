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
    padding: 18px 20px;
    margin-bottom: 16px;
    background: #fafafa;
}
.komentar-box {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 6px;
    padding: 12px 16px;
    margin-top: 12px;
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
            <script>Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 2500, showConfirmButton: false });</script>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <script>Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('error') ?>' });</script>
            <?php endif; ?>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <?php
                    $role_now = session()->get('user_role');
                    $back_url = $role_now === 'pemateri'
                        ? base_url('v_dashboard')
                        : base_url('presensi_kelas/detail_kelas/' . $kelas['id_kelas']);
                ?>
                <a href="<?= $back_url ?>" class="btn btn-light btn-modern border">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Info Kelas + Daftar Tugas dalam 1 card -->
            <div class="paper-card">
                <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-1"><?= esc($kelas['nama_kelas']) ?></h4>
                        <div class="text-muted small">
                            <i class="mdi mdi-book-open-variant me-1"></i><?= esc($program['nama_program']) ?>
                            &bull; <i class="mdi mdi-calendar me-1"></i><?= date('d M Y', strtotime($kelas['tanggal'])) ?>
                            &bull; <i class="mdi mdi-account-tie me-1"></i><?= esc($kelas['nama_dosen'] ?? '-') ?>
                        </div>
                    </div>
                    <?php if ($bisa_kelola): ?>
                    <button class="btn btn-primary btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#modalBuatTugas">
                        <i class="mdi mdi-plus"></i> Buat Tugas Baru
                    </button>
                    <?php endif; ?>
                </div>

                <h5 class="font-weight-bold text-dark mb-3">Daftar Tugas <span class="badge bg-secondary ms-2"><?= count($tugas_list) ?></span></h5>

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
                                <?php if ($bisa_kelola): ?>
                                    <form action="<?= base_url('tugas_kelas/hapus_tugas') ?>" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_tugas" value="<?= $t['id_tugas'] ?>">
                                        <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded"
                                            onclick="return swalConfirm(this.closest('form'))">
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
                                        <?php $tp = strtolower($jawaban_saya['tipe_file'] ?? ''); ?>
                                        <?php if (in_array($tp, ['pdf','png','jpg','jpeg','gif','doc','docx','ppt','pptx','xls','xlsx'])): ?>
                                        <button type="button" class="btn btn-sm btn-outline-info rounded mb-2"
                                            onclick="buka_preview_tugas('<?= base_url('tugas_kelas/preview/jawaban/' . $jawaban_saya['id_jawaban']) ?>', 'Jawaban Saya', '<?= base_url('tugas_kelas/download/jawaban/' . $jawaban_saya['id_jawaban']) ?>')">
                                            <i class="mdi mdi-eye"></i> Lihat File
                                        </button>
                                        <?php endif; ?>
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
                                <?php
                                    $semua = $semua_jawaban[$t['id_tugas']] ?? [];
                                    $sudah_kirim = array_column($semua, 'nama_peserta');
                                    $belum_kirim = array_diff($peserta_kelas, $sudah_kirim);
                                ?>
                                <div class="mt-3 border-top pt-3">
                                    <div class="fw-semibold small text-muted mb-2">Sudah Mengumpulkan <span class="badge bg-success"><?= count($semua) ?></span></div>
                                    <?php if (empty($semua)): ?>
                                        <div class="text-muted small">Belum ada yang mengumpulkan.</div>
                                    <?php else: ?>
                                        <?php foreach ($semua as $j): ?>
                                        <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                                            <div class="avatar-kecil"><?= strtoupper(substr($j['nama_peserta'], 0, 1)) ?></div>
                                            <div>
                                                <div class="small fw-semibold text-dark"><?= esc($j['nama_peserta']) ?></div>
                                                <div class="text-muted" style="font-size:11px;"><?= date('d M Y, H:i', strtotime($j['dibuat_pada'])) ?></div>
                                            </div>
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

<!-- Modal Buat Tugas -->
<div class="modal fade" id="modalBuatTugas" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Tugas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('tugas_kelas/simpan_tugas') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Tugas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required placeholder="Contoh: Tugas 1 - Analisis Bisnis">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instruksi / Soal</label>
                        <textarea class="form-control" name="instruksi" rows="3" placeholder="Tuliskan instruksi atau soal tugas..."></textarea>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">File Soal <small class="text-muted">(opsional)</small></label>
                        <input type="file" class="form-control" name="file_soal" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.png,.jpg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-plus"></i> Buat Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Preview Tugas/Jawaban -->
<div class="modal fade" id="modalPreviewTugas" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="height:90vh;">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold mb-0" id="judulPreviewTugas"></h6>
                <div class="d-flex gap-2 ms-auto">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-0" style="height:100%; overflow:hidden;">
                <iframe id="iframePreviewTugas" src="" style="width:100%; height:100%; border:none;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
function buka_preview_tugas(url, judul, url_unduh) {
    document.getElementById('judulPreviewTugas').textContent = judul;
    document.getElementById('iframePreviewTugas').src = url;
    document.getElementById('btnUnduhPreviewTugas').href = url_unduh;
    new bootstrap.Modal(document.getElementById('modalPreviewTugas')).show();
}

document.getElementById('modalPreviewTugas').addEventListener('hidden.bs.modal', function() {
    document.getElementById('iframePreviewTugas').src = '';
});
</script>
