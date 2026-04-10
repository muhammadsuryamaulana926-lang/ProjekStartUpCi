<?php /* View: Buku — halaman daftar ebook dengan PDF viewer embed */ ?>
<style>
    .app-content { background-color: #F3F4F4 !important; }
    .ebook-card { background:#fff; border-radius:12px; border:1.5px solid var(--slate-100); overflow:hidden; transition:all 0.3s; }
    .ebook-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,0.1); }
    .ebook-sampul { width:100%; height:200px; object-fit:cover; background:var(--slate-50); display:flex; align-items:center; justify-content:center; }
    .ebook-sampul img { width:100%; height:200px; object-fit:cover; }
    .ebook-sampul-default { width:100%; height:200px; background:var(--primary-light); display:flex; align-items:center; justify-content:center; }
    .badge-publik { background:rgba(34,197,94,0.1); color:#16a34a; padding:2px 10px; border-radius:20px; font-size:9px; font-weight:800; text-transform:uppercase; }
    .badge-privat { background:rgba(239,68,68,0.1); color:#dc2626; padding:2px 10px; border-radius:20px; font-size:9px; font-weight:800; text-transform:uppercase; }

    /* Modal PDF Viewer */
    #modalPdf { display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.85); align-items:center; justify-content:center; }
    #modalPdf.show { display:flex; }
    #modalPdf .pdf-wrap { position:relative; width:90%; max-width:900px; height:90vh; }
    #modalPdf .pdf-wrap iframe { width:100%; height:100%; border:none; border-radius:12px; }
    #modalPdf .btn-tutup { position:absolute; top:-40px; right:0; background:transparent; border:none; color:#fff; font-size:28px; cursor:pointer; line-height:1; }
</style>

<div class="app-content">
    <div class="page-header">
        <div>
            <h2>Buku</h2>
            <p class="subtitle">Referensi ebook untuk startup</p>
        </div>
        <?php if (session()->get('user_role') === 'admin'): ?>
        <button onclick="bukaModalTambahEbook()" class="btn-submit-primary">
            <i class="mdi mdi-plus me-1"></i> Tambah Ebook
        </button>
        <?php endif; ?>
    </div>

    <?php if (empty($ebooks)): ?>
    <div class="card-premium">
        <div class="p-5 text-center">
            <i class="mdi mdi-book-open-outline" style="font-size:4rem;color:var(--slate-200);"></i>
            <p style="font-size:13px;font-weight:700;color:var(--slate-400);margin-top:1rem;text-transform:uppercase;letter-spacing:0.2em;">Belum ada ebook tersedia</p>
        </div>
    </div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($ebooks as $e): ?>
        <div class="col-md-3">
            <div class="ebook-card">
                <!-- Sampul ebook -->
                <?php if ($e->sampul_ebook && file_exists(FCPATH . 'uploads/ebook/sampul/' . $e->sampul_ebook)): ?>
                    <img src="<?= base_url('uploads/ebook/sampul/' . $e->sampul_ebook) ?>" style="width:100%;height:200px;object-fit:cover;">
                <?php else: ?>
                    <div class="ebook-sampul-default">
                        <i class="mdi mdi-book-open-page-variant" style="font-size:4rem;color:var(--primary);opacity:0.4;"></i>
                    </div>
                <?php endif; ?>

                <div class="p-3">
                    <div style="font-size:13px;font-weight:800;color:var(--slate-900);margin-bottom:4px;line-height:1.4;"><?= esc($e->judul_ebook) ?></div>
                    <?php if ($e->penulis_ebook): ?>
                    <div style="font-size:11px;color:var(--slate-400);margin-bottom:6px;">oleh <?= esc($e->penulis_ebook) ?></div>
                    <?php endif; ?>
                    <?php if ($e->deskripsi_ebook): ?>
                    <div style="font-size:11px;color:var(--slate-500);margin-bottom:8px;line-height:1.5;"><?= esc(substr($e->deskripsi_ebook, 0, 70)) ?>...</div>
                    <?php endif; ?>

                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <span class="badge-<?= strtolower($e->status_ebook) ?>"><?= $e->status_ebook ?></span>
                        <div class="d-flex gap-1">
                            <!-- Tombol baca: streaming PDF tanpa ekspos path asli -->
                            <button onclick="bacaEbook('<?= $e->uuid_konten_ebook ?>')" class="btn-action" title="Baca">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <?php if (session()->get('user_role') === 'admin'): ?>
                            <button onclick="bukaModalUbahEbook(<?= $e->id_konten_ebook ?>)" class="btn-action" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button onclick="hapusEbook(<?= $e->id_konten_ebook ?>)" class="btn-action btn-danger-hover" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Modal PDF Viewer — file dibaca via streaming, path asli tidak terekspos -->
<div id="modalPdf">
    <div class="pdf-wrap">
        <button class="btn-tutup" onclick="tutupPdf()">&#x2715;</button>
        <iframe id="iframePdf" src=""></iframe>
    </div>
</div>

<?php if (session()->get('user_role') === 'admin'): ?>
<!-- Modal Tambah/Edit Ebook -->
<style>
    /* ── Professional Modal Style ─────────────────────────────── */
    .modal-pro .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        overflow: hidden;
    }
    .modal-pro .modal-header {
        padding: 1.5rem 1.75rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fff;
        align-items: flex-start;
    }
    .modal-pro .modal-header .modal-eyebrow {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--primary, #0061FF);
        margin-bottom: 3px;
    }
    .modal-pro .modal-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.3;
    }
    .modal-pro .btn-close {
        margin-top: 2px;
        opacity: 0.4;
        transition: opacity 0.15s;
    }
    .modal-pro .btn-close:hover { opacity: 0.8; }
    .modal-pro .modal-body {
        padding: 1.5rem 1.75rem;
        background: #fff;
    }
    .modal-pro .modal-footer {
        padding: 1rem 1.75rem;
        border-top: 1px solid #f1f5f9;
        background: #fafafa;
        gap: 8px;
    }
    /* Form fields */
    .modal-pro .pf-group { margin-bottom: 1.1rem; }
    .modal-pro .pf-group:last-child { margin-bottom: 0; }
    .modal-pro .pf-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #64748b;
        margin-bottom: 6px;
    }
    .modal-pro .pf-label .req { color: #ef4444; font-size: 13px; vertical-align: middle; }
    .modal-pro .pf-input,
    .modal-pro .pf-textarea,
    .modal-pro .pf-select,
    .modal-pro .pf-file {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 9px 13px;
        font-size: 13px;
        color: #1e293b;
        background: #fff;
        transition: border-color 0.15s, box-shadow 0.15s;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
    }
    .modal-pro .pf-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }
    .modal-pro .pf-file {
        padding: 7px 13px;
        cursor: pointer;
        color: #64748b;
    }
    .modal-pro .pf-input:focus,
    .modal-pro .pf-textarea:focus,
    .modal-pro .pf-select:focus {
        border-color: var(--primary, #0061FF);
        box-shadow: 0 0 0 3px rgba(0,97,255,0.08);
    }
    .modal-pro .pf-hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }
    /* Buttons */
    .modal-pro .btn-pro-cancel {
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
    }
    .modal-pro .btn-pro-cancel:hover { background: #f8fafc; border-color: #cbd5e1; }
    .modal-pro .btn-pro-submit {
        padding: 9px 22px;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        background: var(--primary, #0061FF);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: opacity 0.15s, transform 0.1s;
    }
    .modal-pro .btn-pro-submit:hover { opacity: 0.88; }
    .modal-pro .btn-pro-submit:active { transform: scale(0.98); }
    .modal-pro .btn-pro-danger {
        padding: 9px 22px;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        background: #ef4444;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: opacity 0.15s;
    }
    .modal-pro .btn-pro-danger:hover { opacity: 0.88; }
    /* 2-col grid helper */
    .modal-pro .pf-row { display: grid; gap: 1rem; }
    .modal-pro .pf-row.col-2 { grid-template-columns: 1fr 1fr; }
    @media (max-width: 576px) { .modal-pro .pf-row.col-2 { grid-template-columns: 1fr; } }
</style>

<div id="modalEbook" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-pro">
        <div class="modal-content">
            <form id="formEbook" enctype="multipart/form-data">
                <div class="modal-header">
                    <div>
                        <div class="modal-eyebrow">Konten</div>
                        <h5 class="modal-title" id="judulModalEbook">Tambah Ebook</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_konten_ebook" id="id_konten_ebook">

                    <div class="pf-group">
                        <label class="pf-label">Judul Ebook <span class="req">*</span></label>
                        <input type="text" name="judul_ebook" id="judul_ebook" class="pf-input" placeholder="Masukkan judul ebook" required>
                    </div>

                    <div class="pf-row col-2">
                        <div class="pf-group">
                            <label class="pf-label">Penulis</label>
                            <input type="text" name="penulis_ebook" id="penulis_ebook" class="pf-input" placeholder="Nama penulis">
                        </div>
                        <div class="pf-group">
                            <label class="pf-label">Status</label>
                            <select name="status_ebook" id="status_ebook" class="pf-select">
                                <option value="Publik">Publik</option>
                                <option value="Privat">Privat</option>
                            </select>
                        </div>
                    </div>

                    <div class="pf-group">
                        <label class="pf-label">Deskripsi</label>
                        <textarea name="deskripsi_ebook" id="deskripsi_ebook" class="pf-textarea" rows="3" placeholder="Deskripsi singkat ebook..."></textarea>
                    </div>

                    <div class="pf-row col-2">
                        <div class="pf-group">
                            <label class="pf-label">File PDF <span class="req" id="pdf_required">*</span></label>
                            <input type="file" name="file_ebook" id="file_ebook" class="pf-file" accept=".pdf">
                            <p class="pf-hint">Format: .pdf</p>
                        </div>
                        <div class="pf-group">
                            <label class="pf-label">Sampul <span style="color:#94a3b8;font-weight:600;">(opsional)</span></label>
                            <input type="file" name="sampul_ebook" class="pf-file" accept=".jpg,.jpeg,.png">
                            <p class="pf-hint">Format: .jpg, .jpeg, .png</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn-pro-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-pro-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    // Buka PDF viewer dengan streaming via route baca_ebook (path asli tidak terekspos)
    function bacaEbook(uuid) {
        document.getElementById('iframePdf').src = '<?= base_url('konten/baca_ebook/') ?>' + uuid;
        document.getElementById('modalPdf').classList.add('show');
    }

    // Tutup PDF viewer dan hentikan streaming
    function tutupPdf() {
        document.getElementById('iframePdf').src = '';
        document.getElementById('modalPdf').classList.remove('show');
    }

    // Tutup PDF viewer jika klik di luar area
    document.getElementById('modalPdf').addEventListener('click', function(e) {
        if (e.target === this) tutupPdf();
    });

    <?php if (session()->get('user_role') === 'admin'): ?>
    const CSRF_NAME = '<?= csrf_token() ?>';
    const CSRF_HASH = '<?= csrf_hash() ?>';

    // Buka modal dalam mode tambah ebook baru
    function bukaModalTambahEbook() {
        document.getElementById('formEbook').reset();
        document.getElementById('id_konten_ebook').value = '';
        document.getElementById('judulModalEbook').innerHTML = 'Tambah Ebook';
        document.getElementById('pdf_required').style.display = 'inline';
        new bootstrap.Modal(document.getElementById('modalEbook')).show();
    }

    // Buka modal dalam mode edit, ambil data ebook via AJAX
    function bukaModalUbahEbook(id) {
        $.ajax({
            url: '<?= base_url('konten/ambil_ebook') ?>',
            type: 'POST',
            data: { id_konten_ebook: id, [CSRF_NAME]: CSRF_HASH },
            success: function(res) {
                var d = typeof res === 'string' ? JSON.parse(res) : res;
                document.getElementById('id_konten_ebook').value  = d.id_konten_ebook;
                document.getElementById('judul_ebook').value      = d.judul_ebook;
                document.getElementById('penulis_ebook').value    = d.penulis_ebook || '';
                document.getElementById('deskripsi_ebook').value  = d.deskripsi_ebook || '';
                document.getElementById('status_ebook').value     = d.status_ebook;
                document.getElementById('judulModalEbook').innerHTML = 'Edit Ebook';
                document.getElementById('pdf_required').style.display = 'none';
                new bootstrap.Modal(document.getElementById('modalEbook')).show();
            }
        });
    }

    // Submit form tambah/edit ebook via AJAX
    $('#formEbook').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append(CSRF_NAME, CSRF_HASH);
        var isEdit = document.getElementById('id_konten_ebook').value !== '';
        var url = isEdit ? '<?= base_url('konten/ubah_ebook') ?>' : '<?= base_url('konten/simpan_ebook') ?>';
        $.ajax({
            url: url, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
            success: function(res) {
                var d = typeof res === 'string' ? JSON.parse(res) : res;
                if (d.status) {
                    bootstrap.Modal.getInstance(document.getElementById('modalEbook')).hide();
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Ebook berhasil disimpan', showConfirmButton: false, timer: 1500 })
                        .then(() => location.reload());
                } else {
                    Swal.fire('Gagal!', d.msg || 'Terjadi kesalahan', 'error');
                }
            }
        });
    });

    // Konfirmasi dan hapus ebook via AJAX
    function hapusEbook(id) {
        Swal.fire({ title: 'Hapus Ebook?', text: 'File PDF juga akan dihapus permanen.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
        .then((r) => {
            if (r.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('konten/hapus_ebook') ?>', type: 'POST',
                    data: { id_konten_ebook: id, [CSRF_NAME]: CSRF_HASH },
                    success: function(res) {
                        var d = typeof res === 'string' ? JSON.parse(res) : res;
                        Swal.fire({ icon: d.status ? 'success' : 'error', title: d.status ? 'Berhasil!' : 'Gagal!', text: d.status ? 'Ebook berhasil dihapus' : 'Terjadi kesalahan', showConfirmButton: false, timer: 1500 })
                            .then(() => { if (d.status) location.reload(); });
                    }
                });
            }
        });
    }
    <?php endif; ?>
</script>