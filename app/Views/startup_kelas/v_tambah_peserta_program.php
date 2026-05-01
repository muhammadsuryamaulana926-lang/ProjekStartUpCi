<style>
body { background-color: #f5f5f5 !important; }
.paper-wrapper { max-width: 600px; margin: 40px auto; }
.paper-form {
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 40px;
}
.paper-title { font-size: 24px; font-weight: 700; color: #333; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
.form-label { font-weight: 600; color: #555; margin-bottom: 8px; }
.form-control { border-radius: 6px; border: 1px solid #cbd5e1; padding: 10px 15px; transition: all 0.3s; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
.btn-modern { padding: 10px 24px; border-radius: 6px; font-weight: 600; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.section-akun { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-top: 16px; }
</style>

<div class="container-fluid" style="background-color: #f5f5f5; padding-bottom: 50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title">Tambah Peserta Manual</h2>
            <div style="font-size:14px; color:#64748b; margin-bottom:20px;">Program: <strong><?= esc($program['nama_program']) ?></strong></div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mb-4"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('peserta_program/simpan_peserta_program') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_program" value="<?= esc($program['id_program']) ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap Peserta <span class="text-danger">*</span></label>
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

                <?php if (!empty($kelas)): ?>
                <div class="mb-3">
                    <label class="form-label">Daftarkan ke Kelas</label>
                    <div class="section-akun">
                        <?php foreach ($kelas as $k): ?>
                        <div class="form-check mb-1">
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

                <!-- Toggle buat akun -->
                <div class="mb-3" style="display:none;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="buat_akun" name="buat_akun" value="1" onchange="toggleAkun(this)">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-light btn-modern border">Batal</a>
                    <button type="submit" class="btn btn-primary btn-modern">Tambahkan Peserta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah User Baru -->
<div id="modalTambahUserBaru" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:10px; padding:28px; width:100%; max-width:420px; box-shadow:0 8px 30px rgba(0,0,0,0.15);">
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
            <button type="button" class="btn btn-light border" onclick="document.getElementById('modalTambahUserBaru').style.display='none'">Batal</button>
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
    var nama     = document.getElementById('nb_nama').value.trim();
    var email    = document.getElementById('nb_email').value.trim();
    var password = document.getElementById('nb_password').value;
    var role     = document.getElementById('nb_role').value;
    var pesan    = document.getElementById('nb_pesan');

    if (!nama || !email || !password) {
        pesan.textContent = 'Semua field wajib diisi.';
        pesan.style.display = 'block';
        return;
    }

    fetch('<?= base_url('kelas/simpan_pemateri_ajax') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'nama_lengkap=' + encodeURIComponent(nama)
            + '&email=' + encodeURIComponent(email)
            + '&password=' + encodeURIComponent(password)
            + '&role=' + encodeURIComponent(role)
            + '&<?= csrf_token() ?>=' + '<?= csrf_hash() ?>'
    })
    .then(r => r.json())
    .then(function(res) {
        if (res.status === 'error') {
            pesan.textContent = res.pesan;
            pesan.style.display = 'block';
            return;
        }
        var sel = document.getElementById('nama_peserta');
        var opt = document.createElement('option');
        opt.value = res.nama_lengkap;
        opt.textContent = res.nama_lengkap + ' — ' + email;
        opt.selected = true;
        sel.appendChild(opt);
        document.getElementById('modalTambahUserBaru').style.display = 'none';
        document.getElementById('nb_nama').value = '';
        document.getElementById('nb_email').value = '';
        document.getElementById('nb_password').value = '';
        pesan.style.display = 'none';
    });
}
</script>
