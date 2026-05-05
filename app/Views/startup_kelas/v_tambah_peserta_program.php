<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Peserta Program</h4>
                    </div>
                </div>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-1">Tambah Peserta Manual</h4>
                            <p class="text-muted mb-3">Program: <strong><?= esc($program['nama_program']) ?></strong></p>
                            <form action="<?= base_url('peserta_program/simpan_peserta_program') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_program" value="<?= esc($program['id_program']) ?>">
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Nama Peserta <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <select class="form-control" name="nama_peserta" id="nama_peserta" required>
                                                <option value="">-- Pilih Peserta --</option>
                                                <?php foreach ($daftar_user as $u): ?>
                                                <option value="<?= esc($u['nama_lengkap']) ?>"><?= esc($u['nama_lengkap']) ?> — <?= esc($u['email']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('modalTambahUserBaru').style.display='flex'" title="Tambah Orang Baru">
                                                <i class="mdi mdi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($kelas)): ?>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Daftarkan ke Kelas</label>
                                    <div class="col-md-5">
                                        <?php foreach ($kelas as $k): ?>
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="id_kelas[]" value="<?= esc($k['id_kelas']) ?>" id="kelas_<?= esc($k['id_kelas']) ?>">
                                            <label class="form-check-label" for="kelas_<?= esc($k['id_kelas']) ?>">
                                                <?= esc($k['nama_kelas']) ?>
                                                <span class="text-muted small">(<?= date('d M Y', strtotime($k['tanggal'])) ?>)</span>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save"></i> Tambahkan Peserta
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

<!-- Modal Tambah User Baru -->
<div id="modalTambahUserBaru" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:8px; padding:28px; width:100%; max-width:420px; box-shadow:0 8px 30px rgba(0,0,0,0.15);">
        <h6 class="fw-bold mb-3">Tambah Orang Baru</h6>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nb_nama" placeholder="Nama lengkap...">
        </div>
        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="nb_email" placeholder="email@contoh.com">
        </div>
        <div class="mb-3">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="password" class="form-control" id="nb_password" placeholder="Password...">
                <button type="button" class="btn btn-outline-secondary" onclick="toggle_nb_password(this)" tabindex="-1"><i class="mdi mdi-eye"></i></button>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Role <span class="text-danger">*</span></label>
            <select class="form-control" id="nb_role">
                <?php foreach ($daftar_role as $value => $label): ?>
                <option value="<?= $value ?>"><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="nb_pesan" class="text-danger small mb-2" style="display:none;"></div>
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalTambahUserBaru').style.display='none'">Batal</button>
            <button type="button" class="btn btn-primary" onclick="kirim_tambah_user_baru()">Simpan</button>
        </div>
    </div>
</div>

<script>
function toggle_nb_password(btn) {
    var inp = document.getElementById('nb_password');
    var icon = btn.querySelector('i');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password' ? 'mdi mdi-eye' : 'mdi mdi-eye-off';
}

function kirim_tambah_user_baru() {
    var nama = document.getElementById('nb_nama').value.trim();
    var email = document.getElementById('nb_email').value.trim();
    var password = document.getElementById('nb_password').value;
    var role = document.getElementById('nb_role').value;
    var pesan = document.getElementById('nb_pesan');
    if (!nama || !email || !password) { pesan.textContent = 'Semua field wajib diisi.'; pesan.style.display = 'block'; return; }
    fetch('<?= base_url('kelas/simpan_pemateri_ajax') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'nama_lengkap=' + encodeURIComponent(nama) + '&email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password) + '&role=' + encodeURIComponent(role) + '&<?= csrf_token() ?>=' + '<?= csrf_hash() ?>'
    })
    .then(r => r.json())
    .then(function(res) {
        if (res.status === 'error') { pesan.textContent = res.pesan; pesan.style.display = 'block'; return; }
        var sel = document.getElementById('nama_peserta');
        var opt = document.createElement('option');
        opt.value = res.nama_lengkap; opt.textContent = res.nama_lengkap + ' — ' + email; opt.selected = true;
        sel.appendChild(opt);
        document.getElementById('modalTambahUserBaru').style.display = 'none';
        document.getElementById('nb_nama').value = '';
        document.getElementById('nb_email').value = '';
        document.getElementById('nb_password').value = '';
        pesan.style.display = 'none';
    });
}
</script>
