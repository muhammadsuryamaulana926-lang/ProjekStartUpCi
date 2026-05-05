<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Kelas</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-1">Tambah Jadwal Kelas</h4>
                            <p class="text-muted mb-3">Program: <strong><?= esc($program['nama_program']) ?></strong></p>
                            <form action="<?= base_url('kelas/simpan_kelas') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_program" value="<?= esc($program['id_program']) ?>">
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Nama Kelas <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="nama_kelas" required placeholder="Misal: Sesi 1 - Fundamental Bisnis">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status_kelas" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="selesai">Selesai</option>
                                            <option value="dibatalkan">Dibatalkan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Deskripsi / Materi</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="deskripsi" rows="3" placeholder="Penjelasan tentang materi yang akan dibahas..."></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Tanggal</label>
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" name="tanggal" id="tanggal">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" placeholder="Jam Mulai">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" placeholder="Jam Selesai">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Dosen / Pemateri</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <select class="form-control" name="id_pemateri" id="id_pemateri" onchange="isi_nama_dosen(this)">
                                                <option value="">-- Pilih Pemateri --</option>
                                                <?php foreach ($daftar_pemateri as $p): ?>
                                                <option value="<?= $p['id_user'] ?>" data-nama="<?= esc($p['nama_lengkap']) ?>">
                                                    <?= esc($p['nama_lengkap']) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('modalTambahPemateri').style.display='flex'" title="Tambah Pemateri Baru">
                                                <i class="mdi mdi-plus"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="nama_dosen" id="nama_dosen">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Tipe Kelas <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <div class="d-flex gap-3 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipe_kelas" id="tipe_online" value="online" onchange="toggle_tipe_kelas()">
                                                <label class="form-check-label" for="tipe_online">Online</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipe_kelas" id="tipe_offline" value="offline" onchange="toggle_tipe_kelas()">
                                                <label class="form-check-label" for="tipe_offline">Offline</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Field Online -->
                                <div id="seksi_online" style="display:none;">
                                    <div class="row mb-2">
                                        <label class="col-md-2 col-form-label">Platform</label>
                                        <div class="col-md-3">
                                            <select name="platform_online" id="platform_online" class="form-control" onchange="update_label_meeting()">
                                                <option value="">-- Pilih Platform --</option>
                                                <option value="Zoom">Zoom</option>
                                                <option value="Google Meet">Google Meet</option>
                                                <option value="Microsoft Teams">Microsoft Teams</option>
                                                <option value="Webex">Webex</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-md-2 col-form-label"><span id="label_link_meeting">Link Meeting</span></label>
                                        <div class="col-md-4">
                                            <input type="url" class="form-control" name="link_zoom" id="link_zoom" placeholder="https://...">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-md-2 col-form-label">Link YouTube Live</label>
                                        <div class="col-md-4">
                                            <input type="url" class="form-control" name="link_youtube" id="link_youtube" placeholder="https://youtube.com/...">
                                        </div>
                                    </div>
                                </div>

                                <!-- Field Offline -->
                                <div id="seksi_offline" style="display:none;">
                                    <div class="row mb-2">
                                        <label class="col-md-2 col-form-label">Lokasi / Ruangan</label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="lokasi_offline" placeholder="Contoh: Gedung A Lantai 2, Ruang Seminar 301">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save"></i> Simpan
                                    </button>
                                    <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-white waves-effect waves-light">
                                        <i class="mdi mdi-keyboard-backspace"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->

<!-- Modal Tambah Pemateri -->
<div id="modalTambahPemateri" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:8px; padding:28px; width:100%; max-width:420px; box-shadow:0 8px 30px rgba(0,0,0,0.15);">
        <h6 class="fw-bold mb-3">Tambah Pemateri Baru</h6>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="pm_nama" placeholder="Nama pemateri...">
        </div>
        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="pm_email" placeholder="email@contoh.com">
        </div>
        <div class="mb-3">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="password" class="form-control" id="pm_password" placeholder="Password...">
                <button type="button" class="btn btn-outline-secondary" onclick="toggle_pm_password(this)" tabindex="-1">
                    <i class="mdi mdi-eye"></i>
                </button>
            </div>
        </div>
        <div id="pm_pesan" class="text-danger small mb-2" style="display:none;"></div>
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalTambahPemateri').style.display='none'">Batal</button>
            <button type="button" class="btn btn-primary" onclick="kirim_tambah_pemateri()">Simpan</button>
        </div>
    </div>
</div>

<script>
(function() {
    var now = new Date();
    var pad = function(n) { return String(n).padStart(2, '0'); };
    document.getElementById('tanggal').value    = now.getFullYear() + '-' + pad(now.getMonth()+1) + '-' + pad(now.getDate());
    document.getElementById('jam_mulai').value  = pad(now.getHours()) + ':' + pad(now.getMinutes());
    var selesai = new Date(now.getTime() + 60 * 60 * 1000);
    document.getElementById('jam_selesai').value = pad(selesai.getHours()) + ':' + pad(selesai.getMinutes());
})();

function isi_nama_dosen(sel) {
    var opt = sel.options[sel.selectedIndex];
    document.getElementById('nama_dosen').value = opt ? (opt.dataset.nama || '') : '';
}

function update_label_meeting() {
    var platform = document.getElementById('platform_online').value;
    var labels = { 'Zoom': 'Link Zoom Meeting', 'Google Meet': 'Link Google Meet', 'Microsoft Teams': 'Link Microsoft Teams', 'Webex': 'Link Webex', 'Lainnya': 'Link Meeting' };
    document.getElementById('label_link_meeting').textContent = labels[platform] || 'Link Meeting';
}

function toggle_tipe_kelas() {
    var tipe = document.querySelector('input[name="tipe_kelas"]:checked');
    var isOnline = tipe && tipe.value === 'online';
    document.getElementById('seksi_online').style.display  = isOnline ? 'block' : 'none';
    document.getElementById('seksi_offline').style.display = (!isOnline && tipe) ? 'block' : 'none';
    if (!isOnline) {
        document.getElementById('link_zoom').value = '';
        document.getElementById('link_youtube').value = '';
    }
}

function toggle_pm_password(btn) {
    var inp = document.getElementById('pm_password');
    var icon = btn.querySelector('i');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password' ? 'mdi mdi-eye' : 'mdi mdi-eye-off';
}

function kirim_tambah_pemateri() {
    var nama = document.getElementById('pm_nama').value.trim();
    var email = document.getElementById('pm_email').value.trim();
    var password = document.getElementById('pm_password').value;
    var pesan = document.getElementById('pm_pesan');
    if (!nama || !email || !password) { pesan.textContent = 'Semua field wajib diisi.'; pesan.style.display = 'block'; return; }
    fetch('<?= base_url('kelas/simpan_pemateri_ajax') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'nama_lengkap=' + encodeURIComponent(nama) + '&email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password) + '&<?= csrf_token() ?>=' + '<?= csrf_hash() ?>'
    })
    .then(r => r.json())
    .then(function(res) {
        if (res.status === 'error') { pesan.textContent = res.pesan; pesan.style.display = 'block'; return; }
        var sel = document.getElementById('id_pemateri');
        var opt = document.createElement('option');
        opt.value = res.id_user; opt.dataset.nama = res.nama_lengkap; opt.textContent = res.nama_lengkap; opt.selected = true;
        sel.appendChild(opt);
        document.getElementById('nama_dosen').value = res.nama_lengkap;
        document.getElementById('modalTambahPemateri').style.display = 'none';
        document.getElementById('pm_nama').value = '';
        document.getElementById('pm_email').value = '';
        document.getElementById('pm_password').value = '';
        pesan.style.display = 'none';
    });
}
</script>
