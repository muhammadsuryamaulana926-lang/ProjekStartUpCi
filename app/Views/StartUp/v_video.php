<?php /* View: Video — halaman daftar video pembelajaran dengan embed YouTube langsung di card */ ?>
<style>
    .app-content { background-color: #F3F4F4 !important; }
    .video-card { background:#fff; border-radius:12px; border:1.5px solid var(--slate-100); overflow:hidden; transition:all 0.3s; }
    .video-card:hover { box-shadow:0 12px 24px rgba(0,0,0,0.1); }

    /* Area thumbnail — sebelum diklik tampil gambar, setelah diklik tampil iframe */
    .video-thumb { position:relative; width:100%; padding-top:56.25%; background:#000; overflow:hidden; cursor:pointer; }
    .video-thumb img { position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; transition:opacity 0.3s; }
    .video-thumb iframe { position:absolute; top:0; left:0; width:100%; height:100%; border:none; display:none; }
    .video-thumb.playing img  { display:none; }
    .video-thumb.playing iframe { display:block; }

    /* Tombol play di atas thumbnail */
    .play-btn { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:56px; height:56px; background:rgba(255,0,0,0.9); border-radius:50%; display:flex; align-items:center; justify-content:center; transition:transform 0.2s, background 0.2s; z-index:2; }
    .play-btn:hover { background:rgba(200,0,0,1); transform:translate(-50%,-50%) scale(1.1); }
    .play-btn svg { width:24px; height:24px; color:#fff; margin-left:4px; }
    .video-thumb.playing .play-btn { display:none; }

    /* Tombol fullscreen di pojok kanan bawah thumbnail */
    .btn-fullscreen { position:absolute; bottom:8px; right:8px; width:32px; height:32px; background:rgba(0,0,0,0.6); border:none; border-radius:6px; color:#fff; display:none; align-items:center; justify-content:center; cursor:pointer; z-index:3; transition:background 0.2s; }
    .btn-fullscreen:hover { background:rgba(0,0,0,0.9); }
    .btn-fullscreen svg { width:16px; height:16px; }
    .video-thumb.playing .btn-fullscreen { display:flex; }

    .badge-publik { background:rgba(34,197,94,0.1); color:#16a34a; padding:2px 10px; border-radius:20px; font-size:9px; font-weight:800; text-transform:uppercase; }
    .badge-privat { background:rgba(239,68,68,0.1); color:#dc2626; padding:2px 10px; border-radius:20px; font-size:9px; font-weight:800; text-transform:uppercase; }
</style>

<div class="app-content">
    <div class="page-header">
        <div>
            <h2>Video</h2>
            <p class="subtitle">Konten video pembelajaran startup</p>
        </div>
        <?php if (session()->get('user_role') === 'admin'): ?>
        <button onclick="bukaModalTambahVideo()" class="btn-submit-primary">
            <i class="mdi mdi-plus me-1"></i> Tambah Video
        </button>
        <?php endif; ?>
    </div>

    <?php if (empty($videos)): ?>
    <div class="card-premium">
        <div class="p-5 text-center">
            <i class="mdi mdi-video-outline" style="font-size:4rem;color:var(--slate-200);"></i>
            <p style="font-size:13px;font-weight:700;color:var(--slate-400);margin-top:1rem;text-transform:uppercase;letter-spacing:0.2em;">Belum ada video tersedia</p>
        </div>
    </div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($videos as $v): ?>
        <div class="col-md-4">
            <div class="video-card">
                <!-- Area video: klik thumbnail untuk mulai putar langsung di card -->
                <div class="video-thumb" id="thumb_<?= $v->id_konten_video ?>">
                    <!-- Thumbnail YouTube -->
                    <img src="https://img.youtube.com/vi/<?= $v->youtube_id ?>/hqdefault.jpg" alt="<?= esc($v->judul_video) ?>">
                    <!-- Tombol play -->
                    <div class="play-btn" onclick="putarVideo(<?= $v->id_konten_video ?>, '<?= $v->youtube_id ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                    <!-- iframe YouTube embed — muncul setelah diklik -->
                    <iframe id="iframe_<?= $v->id_konten_video ?>"
                        src=""
                        allowfullscreen
                        allow="autoplay; encrypted-media; fullscreen">
                    </iframe>
                    <!-- Tombol fullscreen — muncul saat video sedang diputar -->
                    <button class="btn-fullscreen" onclick="layarPenuh(<?= $v->id_konten_video ?>)" title="Layar Penuh">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                        </svg>
                    </button>
                </div>

                <div class="p-3">
                    <div style="font-size:13px;font-weight:800;color:var(--slate-900);margin-bottom:6px;line-height:1.4;"><?= esc($v->judul_video) ?></div>
                    <?php if ($v->deskripsi_video): ?>
                    <div style="font-size:11px;color:var(--slate-500);margin-bottom:8px;line-height:1.5;"><?= esc(substr($v->deskripsi_video, 0, 80)) ?>...</div>
                    <?php endif; ?>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="badge-<?= strtolower($v->status_video) ?>"><?= $v->status_video ?></span>
                        <?php if (session()->get('user_role') === 'admin'): ?>
                        <div class="d-flex gap-2">
                            <button onclick="bukaModalUbahVideo(<?= $v->id_konten_video ?>)" class="btn-action" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button onclick="hapusVideo(<?= $v->id_konten_video ?>)" class="btn-action btn-danger-hover" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php if (session()->get('user_role') === 'admin'): ?>
<!-- Modal Tambah/Edit Video -->
<div id="modalVideo" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formVideo" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModalVideo"><i class="mdi mdi-video-plus me-1"></i> Tambah Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_konten_video" id="id_konten_video">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" name="judul_video" id="judul_video" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL YouTube <span class="text-danger">*</span></label>
                        <input type="text" name="url_video" id="url_video" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
                        <small class="text-muted">Paste URL YouTube lengkap</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi_video" id="deskripsi_video" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status_video" id="status_video" class="form-select">
                            <option value="Publik">Publik</option>
                            <option value="Privat">Privat</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    // Putar video langsung di dalam card — ganti thumbnail dengan iframe YouTube
    function putarVideo(id, ytId) {
        var thumb  = document.getElementById('thumb_' + id);
        var iframe = document.getElementById('iframe_' + id);
        // Set src iframe dengan autoplay dan tanpa related video
        iframe.src = 'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0&modestbranding=1';
        thumb.classList.add('playing');
    }

    // Masuk ke mode layar penuh pada iframe video yang sedang diputar
    function layarPenuh(id) {
        var iframe = document.getElementById('iframe_' + id);
        if (iframe.requestFullscreen)       iframe.requestFullscreen();
        else if (iframe.webkitRequestFullscreen) iframe.webkitRequestFullscreen();
        else if (iframe.mozRequestFullScreen)    iframe.mozRequestFullScreen();
        else if (iframe.msRequestFullscreen)     iframe.msRequestFullscreen();
    }

    <?php if (session()->get('user_role') === 'admin'): ?>
    const CSRF_NAME = '<?= csrf_token() ?>';
    const CSRF_HASH = '<?= csrf_hash() ?>';

    // Buka modal dalam mode tambah video baru
    function bukaModalTambahVideo() {
        document.getElementById('formVideo').reset();
        document.getElementById('id_konten_video').value = '';
        document.getElementById('judulModalVideo').innerHTML = '<i class="mdi mdi-video-plus me-1"></i> Tambah Video';
        new bootstrap.Modal(document.getElementById('modalVideo')).show();
    }

    // Buka modal dalam mode edit, ambil data video via AJAX
    function bukaModalUbahVideo(id) {
        $.ajax({
            url: '<?= base_url('konten/ambil_video') ?>',
            type: 'POST',
            data: { id_konten_video: id, [CSRF_NAME]: CSRF_HASH },
            success: function(res) {
                var d = typeof res === 'string' ? JSON.parse(res) : res;
                document.getElementById('id_konten_video').value = d.id_konten_video;
                document.getElementById('judul_video').value     = d.judul_video;
                document.getElementById('url_video').value       = 'https://www.youtube.com/watch?v=' + d.kode_video;
                document.getElementById('deskripsi_video').value = d.deskripsi_video || '';
                document.getElementById('status_video').value    = d.status_video;
                document.getElementById('judulModalVideo').innerHTML = '<i class="mdi mdi-video-edit me-1"></i> Edit Video';
                new bootstrap.Modal(document.getElementById('modalVideo')).show();
            }
        });
    }

    // Submit form tambah/edit video via AJAX
    $('#formVideo').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append(CSRF_NAME, CSRF_HASH);
        var isEdit = document.getElementById('id_konten_video').value !== '';
        var url = isEdit ? '<?= base_url('konten/ubah_video') ?>' : '<?= base_url('konten/simpan_video') ?>';
        $.ajax({
            url: url, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
            success: function(res) {
                var d = typeof res === 'string' ? JSON.parse(res) : res;
                if (d.status) {
                    bootstrap.Modal.getInstance(document.getElementById('modalVideo')).hide();
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Video berhasil disimpan', showConfirmButton: false, timer: 1500 })
                        .then(() => location.reload());
                } else {
                    Swal.fire('Gagal!', d.msg || 'Terjadi kesalahan', 'error');
                }
            }
        });
    });

    // Konfirmasi dan hapus video via AJAX
    function hapusVideo(id) {
        Swal.fire({ title: 'Hapus Video?', text: 'Data tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
        .then((r) => {
            if (r.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('konten/hapus_video') ?>', type: 'POST',
                    data: { id_konten_video: id, [CSRF_NAME]: CSRF_HASH },
                    success: function(res) {
                        var d = typeof res === 'string' ? JSON.parse(res) : res;
                        Swal.fire({ icon: d.status ? 'success' : 'error', title: d.status ? 'Berhasil!' : 'Gagal!', text: d.status ? 'Video berhasil dihapus' : 'Terjadi kesalahan', showConfirmButton: false, timer: 1500 })
                            .then(() => { if (d.status) location.reload(); });
                    }
                });
            }
        });
    }
    <?php endif; ?>
</script>
