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
.materi-item {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px 20px;
    margin-bottom: 12px;
    transition: all 0.2s;
    background: #fff;
}
.materi-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); border-color: #cbd5e1; }
.ikon-tipe { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.form-label { font-weight: 600; color: #555; }
.form-control { border-radius: 6px; border: 1px solid #cbd5e1; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
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
                    &bull; <i class="mdi mdi-clock me-1"></i><?= date('H:i', strtotime($kelas['jam_mulai'])) ?> - <?= date('H:i', strtotime($kelas['jam_selesai'])) ?>
                    <?php if (!empty($kelas['nama_dosen'])): ?>
                    &bull; <i class="mdi mdi-account-tie me-1"></i><?= esc($kelas['nama_dosen']) ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Form Upload Materi (hanya admin/superadmin) -->
            <?php if ($bisa_kelola): ?>
            <div class="paper-card">
                <h5 class="font-weight-bold text-dark mb-4">
                    <i class="mdi mdi-upload text-primary me-2"></i>Unggah Materi Baru
                </h5>
                <form action="<?= base_url('materi_kelas/simpan_materi') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Judul Materi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" required placeholder="Contoh: Slide Presentasi Sesi 1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link Berbagi (Google Drive, dll)</label>
                            <input type="url" class="form-control" name="link_berbagi" placeholder="https://drive.google.com/...">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" placeholder="Keterangan singkat materi...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Upload File</label>
                            <input type="file" class="form-control" name="file_materi" accept=".pdf,.ppt,.pptx,.doc,.docx,.xls,.xlsx,.zip,.png,.jpg">
                            <small class="text-muted">PDF, PPT, DOC, XLS, ZIP, Gambar</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="mdi mdi-upload"></i> Unggah Materi
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <!-- Daftar Materi -->
            <div class="paper-card">
                <h5 class="font-weight-bold text-dark mb-4">
                    <i class="mdi mdi-folder-open text-warning me-2"></i>Daftar Materi
                    <span class="badge bg-secondary ms-2"><?= count($materi) ?></span>
                </h5>

                <?php if (empty($materi)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="mdi mdi-file-document-outline" style="font-size:48px; color:#cbd5e1;"></i>
                        <p class="mt-3">Belum ada materi yang diunggah.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($materi as $m): ?>
                    <?php
                        $ikon_map = [
                            'pdf'  => ['mdi-file-pdf-box', '#ef4444', '#fef2f2'],
                            'ppt'  => ['mdi-file-powerpoint', '#f97316', '#fff7ed'],
                            'pptx' => ['mdi-file-powerpoint', '#f97316', '#fff7ed'],
                            'doc'  => ['mdi-file-word', '#3b82f6', '#eff6ff'],
                            'docx' => ['mdi-file-word', '#3b82f6', '#eff6ff'],
                            'xls'  => ['mdi-file-excel', '#22c55e', '#f0fdf4'],
                            'xlsx' => ['mdi-file-excel', '#22c55e', '#f0fdf4'],
                            'zip'  => ['mdi-folder-zip', '#a855f7', '#faf5ff'],
                            'png'  => ['mdi-file-image', '#06b6d4', '#ecfeff'],
                            'jpg'  => ['mdi-file-image', '#06b6d4', '#ecfeff'],
                        ];
                        $tipe  = strtolower($m['tipe_file'] ?? '');
                        $ikon  = $ikon_map[$tipe] ?? ['mdi-file-document', '#64748b', '#f8fafc'];
                    ?>
                    <div class="materi-item">
                        <div class="d-flex align-items-start gap-3">
                            <div class="ikon-tipe" style="background:<?= $ikon[2] ?>; color:<?= $ikon[1] ?>;">
                                <i class="mdi <?= $ikon[0] ?>"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong class="text-dark"><?= esc($m['judul']) ?></strong>
                                        <?php if (!empty($m['deskripsi'])): ?>
                                            <div class="text-muted small mt-1"><?= esc($m['deskripsi']) ?></div>
                                        <?php endif; ?>
                                        <div class="text-muted mt-1" style="font-size:11px;">
                                            <i class="mdi mdi-account me-1"></i><?= esc($m['diunggah_oleh']) ?>
                                            &bull; <?= date('d M Y, H:i', strtotime($m['dibuat_pada'])) ?>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 ms-3 flex-shrink-0">
                                        <?php if (!empty($m['link_berbagi'])): ?>
                                            <a href="<?= esc($m['link_berbagi']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded" title="Buka Link">
                                                <i class="mdi mdi-open-in-new"></i> Buka
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($m['nama_file'])): ?>
                                            <?php
                                                $tipe_preview = strtolower($m['tipe_file'] ?? '');
                                                $bisa_preview = in_array($tipe_preview, ['pdf','png','jpg','jpeg','gif','doc','docx','ppt','pptx','xls','xlsx']);
                                            ?>
                                            <?php if ($bisa_preview): ?>
                                            <button type="button" class="btn btn-sm btn-outline-info rounded"
                                                onclick="buka_preview('<?= base_url('materi_kelas/preview_materi/' . $m['id_materi']) ?>', '<?= esc($m['judul']) ?>', '<?= $tipe_preview ?>')"
                                                title="Lihat">
                                                <i class="mdi mdi-eye"></i> Lihat
                                            </button>
                                            <?php endif; ?>
                                            <a href="<?= base_url('materi_kelas/download_materi/' . $m['id_materi']) ?>" class="btn btn-sm btn-outline-success rounded" title="Download">
                                                <i class="mdi mdi-download"></i> Unduh
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($bisa_kelola): ?>
                                            <form action="<?= base_url('materi_kelas/hapus_materi') ?>" method="POST" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id_materi" value="<?= $m['id_materi'] ?>">
                                                <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded"
                                                    onclick="return confirm('Yakin hapus materi ini?')" title="Hapus">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<!-- Modal Preview Materi -->
<div class="modal fade" id="modalPreviewMateri" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="height:90vh;">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold mb-0" id="judulPreview"></h6>
                <div class="d-flex gap-2 ms-auto">
                    <a id="btnUnduhPreview" href="#" class="btn btn-sm btn-success rounded">
                        <i class="mdi mdi-download"></i> Unduh
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-0" style="height:100%; overflow:hidden;">
                <iframe id="iframePreview" src="" style="width:100%; height:100%; border:none;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
function buka_preview(url, judul, tipe) {
    document.getElementById('judulPreview').textContent = judul;

    var tipe_gambar = ['png','jpg','jpeg','gif'];
    var tipe_office = ['doc','docx','ppt','pptx','xls','xlsx'];
    var src = url;

    if (tipe_office.indexOf(tipe) !== -1) {
        src = 'https://docs.google.com/viewer?url=' + encodeURIComponent(url) + '&embedded=true';
    }

    document.getElementById('iframePreview').src = src;

    // Tombol unduh — ambil id_materi dari URL
    var parts = url.split('/');
    var id_materi = parts[parts.length - 1];
    document.getElementById('btnUnduhPreview').href = '<?= base_url('materi_kelas/download_materi/') ?>' + id_materi;

    var modal = new bootstrap.Modal(document.getElementById('modalPreviewMateri'));
    modal.show();
}

// Kosongkan iframe saat modal ditutup agar tidak loading di background
document.getElementById('modalPreviewMateri').addEventListener('hidden.bs.modal', function() {
    document.getElementById('iframePreview').src = '';
});
</script>
