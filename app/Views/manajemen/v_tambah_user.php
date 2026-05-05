<style>
body { background-color: #f5f5f5 !important; }
.paper-wrapper { max-width: 1100px; margin: 40px auto; }
.paper-form {
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 40px;
}
.paper-title {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    margin-bottom: 25px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}
.section-title {
    font-size: 15px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f0f0f0;
}
.form-label { font-weight: 600; color: #555; margin-bottom: 8px; }
.form-control {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 10px 15px;
    transition: all 0.3s;
}
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
.btn-modern { padding: 10px 24px; border-radius: 6px; font-weight: 600; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.matrix-table th { background: #f8f9fa; font-weight: 600; font-size: 12px; }
.matrix-table td { font-size: 13px; vertical-align: middle; }
.form-check-input { width: 16px; height: 16px; cursor: pointer; }
</style>

<div class="container-fluid" style="background-color: #f5f5f5; padding-bottom: 50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title">Tambah User Baru</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mb-4"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('manajemen_user/simpan_user') ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Data Akun -->

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_lengkap" required value="<?= old('nama_lengkap') ?>" placeholder="Masukkan nama lengkap...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" required value="<?= old('email') ?>" placeholder="Masukkan email...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="input_password" required placeholder="Masukkan password...">
                        <button type="button" class="btn btn-outline-secondary" onclick="toggle_password('input_password', this)" tabindex="-1">
                            <i class="mdi mdi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <div id="notif_role_sukses" class="alert alert-success py-2 small mb-2" style="display:none;"></div>
                    <div class="input-group">
                        <select class="form-control" name="role" id="roleSelect" required onchange="updateIzinByRole(this.value)">
                            <option value="">-- Pilih Role --</option>
                            <?php foreach ($daftar_role as $value => $label): ?>
                                <option value="<?= $value ?>" <?= old('role') === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('modalTambahRole').style.display='flex'" title="Tambah Role Baru">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Izin Akses -->
                <div class="section-title mt-4">Izin Akses per Modul</div>

                <div class="table-responsive">
                    <table class="table table-hover matrix-table align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="40%">Akses Halaman</th>
                                <th class="text-center" width="13%"><i class="mdi mdi-eye text-info"></i> Lihat</th>
                                <th class="text-center" width="14%"><i class="mdi mdi-plus-circle text-success"></i> Tambah</th>
                                <th class="text-center" width="14%"><i class="mdi mdi-pencil text-warning"></i> Edit</th>
                                <th class="text-center" width="14%"><i class="mdi mdi-delete text-danger"></i> Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($daftar_modul as $modul_key => $modul_label): ?>
                                <?php $izin = $izin_per_modul[$modul_key] ?? []; ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-semibold"><?= $modul_label ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input"
                                            name="izin[<?= $modul_key ?>][bisa_lihat]" value="1"
                                            <?= !empty($izin['bisa_lihat']) ? 'checked' : '' ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input"
                                            name="izin[<?= $modul_key ?>][bisa_tambah]" value="1"
                                            <?= !empty($izin['bisa_tambah']) ? 'checked' : '' ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input"
                                            name="izin[<?= $modul_key ?>][bisa_edit]" value="1"
                                            <?= !empty($izin['bisa_edit']) ? 'checked' : '' ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input"
                                            name="izin[<?= $modul_key ?>][bisa_hapus]" value="1"
                                            <?= !empty($izin['bisa_hapus']) ? 'checked' : '' ?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('manajemen_user') ?>" class="btn btn-light btn-modern border">Batal</a>
                    <button type="submit" class="btn btn-primary btn-modern">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Role -->
<div id="modalTambahRole" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:10px; padding:28px; width:100%; max-width:380px; box-shadow:0 8px 30px rgba(0,0,0,0.15);">
        <h6 class="fw-bold mb-3">Tambah Role Baru</h6>
        <div class="mb-3">
            <label class="form-label">Nama Role <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="input_role_baru" placeholder="Contoh: Mentor, Koordinator...">
            <small class="text-muted">Spasi otomatis diganti underscore.</small>
        </div>
        <div id="pesan_role" class="text-danger small mb-2" style="display:none;"></div>
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-light border" onclick="document.getElementById('modalTambahRole').style.display='none'">Batal</button>
            <button type="button" class="btn btn-primary" onclick="kirim_tambah_role()">Simpan Role</button>
        </div>
    </div>
</div>

<script>
function toggle_password(id, btn) {
    var inp = document.getElementById(id);
    var icon = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.className = 'mdi mdi-eye-off';
    } else {
        inp.type = 'password';
        icon.className = 'mdi mdi-eye';
    }
}

function kirim_tambah_role() {
    var label = document.getElementById('input_role_baru').value.trim();
    var pesan = document.getElementById('pesan_role');
    if (!label) { pesan.textContent = 'Nama role tidak boleh kosong.'; pesan.style.display='block'; return; }

    fetch('<?= base_url('manajemen_user/tambah_role') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: '<?= csrf_token() ?>=' + '<?= csrf_hash() ?>' + '&label=' + encodeURIComponent(label)
    })
    .then(r => r.json())
    .then(res => {
        if (res.status === 'ok') {
            var sel = document.getElementById('roleSelect');
            var opt = document.createElement('option');
            opt.value = res.nama_role;
            opt.textContent = res.label;
            opt.selected = true;
            sel.appendChild(opt);
            document.getElementById('modalTambahRole').style.display = 'none';
            document.getElementById('input_role_baru').value = '';
            pesan.style.display = 'none';
            updateIzinByRole(res.nama_role);
            // Tampilkan notif sukses
            var notif = document.getElementById('notif_role_sukses');
            notif.textContent = 'Role "' + res.label + '" berhasil ditambahkan.';
            notif.style.display = 'block';
            setTimeout(function() { notif.style.display = 'none'; }, 3000);
        } else {
            pesan.textContent = res.pesan;
            pesan.style.display = 'block';
        }
    });
}

// Saat role berubah, load izin akses role tersebut via AJAX
function updateIzinByRole(role) {
    if (!role) return;
    fetch('<?= base_url('manajemen_user/get_izin_by_role') ?>?role=' + role)
        .then(r => r.json())
        .then(data => {
            document.querySelectorAll('.form-check-input').forEach(cb => cb.checked = false);
            data.forEach(izin => {
                ['bisa_lihat','bisa_tambah','bisa_edit','bisa_hapus'].forEach(key => {
                    if (izin[key] == 1) {
                        const cb = document.querySelector(`input[name="izin[${izin.modul}][${key}]"]`);
                        if (cb) cb.checked = true;
                    }
                });
            });
        });
}
</script>
