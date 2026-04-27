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
                    <input type="text" class="form-control" name="nama_peserta" required placeholder="Masukkan nama peserta...">
                </div>

                <!-- Toggle buat akun -->
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="buat_akun" name="buat_akun" value="1" onchange="toggleAkun(this)">
                        <label class="form-check-label fw-semibold" for="buat_akun">
                            Sekaligus buat akun untuk peserta ini
                        </label>
                    </div>
                </div>

                <!-- Section akun (tersembunyi default) -->
                <div class="section-akun" id="seksi_akun" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="input_email" placeholder="email@contoh.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="input_password" placeholder="Masukkan password...">
                            <button type="button" class="btn btn-outline-secondary" onclick="toggle_password('input_password', this)" tabindex="-1">
                                <i class="mdi mdi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-control" name="role_akun" id="input_role">
                            <option value="pemilik_startup">Pemilik Startup</option>
                            <option value="pemateri">Pemateri</option>
                        </select>
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

<script>
function toggleAkun(cb) {
    var seksi = document.getElementById('seksi_akun');
    var email = document.getElementById('input_email');
    var pass  = document.getElementById('input_password');
    seksi.style.display = cb.checked ? 'block' : 'none';
    email.required = cb.checked;
    pass.required  = cb.checked;
}

function toggle_password(id, btn) {
    var inp  = document.getElementById(id);
    var icon = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.className = 'mdi mdi-eye-off';
    } else {
        inp.type = 'password';
        icon.className = 'mdi mdi-eye';
    }
}
</script>
