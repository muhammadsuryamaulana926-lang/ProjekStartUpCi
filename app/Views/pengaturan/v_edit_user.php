<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Manajemen User</h4>
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
                            <h4 class="header-title mb-3">Edit User</h4>
                            <form action="<?= base_url('manajemen_user/ubah_user') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="uuid_user" value="<?= esc($user['uuid_user']) ?>">
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="nama_lengkap" required value="<?= esc(old('nama_lengkap', $user['nama_lengkap'])) ?>">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Email <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="email" class="form-control" name="email" required value="<?= esc(old('email', $user['email'])) ?>">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Password Baru</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="input_password" placeholder="Kosongkan jika tidak ingin mengubah password...">
                                            <button type="button" class="btn btn-outline-secondary" onclick="toggle_password('input_password', this)" tabindex="-1">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Role <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="role" required onchange="updateIzinByRole(this.value)">
                                            <?php foreach ($daftar_role as $value => $label): ?>
                                                <option value="<?= $value ?>" <?= old('role', $user['role']) === $value ? 'selected' : '' ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Izin Akses -->
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <h5 class="mt-3 mb-2" style="font-size:15px; font-weight:700; border-bottom:1px solid #f0f0f0; padding-bottom:8px;">Izin Akses per Modul</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th class="text-center" style="min-width:40px;">No</th>
                                                        <th style="min-width:200px;">Akses Halaman</th>
                                                        <th class="text-center" style="min-width:80px;"><i class="mdi mdi-eye text-info"></i> Lihat</th>
                                                        <th class="text-center" style="min-width:80px;"><i class="mdi mdi-plus-circle text-success"></i> Tambah</th>
                                                        <th class="text-center" style="min-width:80px;"><i class="mdi mdi-pencil text-warning"></i> Edit</th>
                                                        <th class="text-center" style="min-width:80px;"><i class="mdi mdi-delete text-danger"></i> Hapus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1; foreach ($daftar_modul as $modul_key => $modul_label): ?>
                                                        <?php $izin = $izin_per_modul[$modul_key] ?? []; ?>
                                                        <tr>
                                                            <td style="text-align:center;"><?= $no++ ?>.</td>
                                                            <td><b><?= $modul_label ?></b></td>
                                                            <td style="text-align:center;"><input type="checkbox" class="form-check-input" name="izin[<?= $modul_key ?>][bisa_lihat]" value="1" <?= !empty($izin['bisa_lihat']) ? 'checked' : '' ?>></td>
                                                            <td style="text-align:center;"><input type="checkbox" class="form-check-input" name="izin[<?= $modul_key ?>][bisa_tambah]" value="1" <?= !empty($izin['bisa_tambah']) ? 'checked' : '' ?>></td>
                                                            <td style="text-align:center;"><input type="checkbox" class="form-check-input" name="izin[<?= $modul_key ?>][bisa_edit]" value="1" <?= !empty($izin['bisa_edit']) ? 'checked' : '' ?>></td>
                                                            <td style="text-align:center;"><input type="checkbox" class="form-check-input" name="izin[<?= $modul_key ?>][bisa_hapus]" value="1" <?= !empty($izin['bisa_hapus']) ? 'checked' : '' ?>></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save"></i> Simpan Perubahan
                                    </button>
                                    <a href="<?= base_url('manajemen_user') ?>" class="btn btn-white waves-effect waves-light">
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

<script>
function toggle_password(id, btn) {
    var inp = document.getElementById(id);
    var icon = btn.querySelector('i');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password' ? 'mdi mdi-eye' : 'mdi mdi-eye-off';
}

function updateIzinByRole(role) {
    if (!role) return;
    fetch('<?= base_url('manajemen_user/get_izin_by_role') ?>?role=' + role)
        .then(r => r.json())
        .then(data => {
            document.querySelectorAll('.form-check-input').forEach(cb => cb.checked = false);
            data.forEach(izin => {
                ['bisa_lihat','bisa_tambah','bisa_edit','bisa_hapus'].forEach(key => {
                    if (izin[key] == 1) {
                        var cb = document.querySelector('input[name="izin[' + izin.modul + '][' + key + ']"]');
                        if (cb) cb.checked = true;
                    }
                });
            });
        });
}
</script>
