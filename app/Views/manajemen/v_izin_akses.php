<style>
body { background-color: #f5f5f5 !important; }
.paper-card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 30px;
}
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.role-tab {
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
    color: #64748b;
    border: 1px solid #e2e8f0;
    background: #fff;
    transition: all 0.2s;
}
.role-tab:hover { background: #f1f5f9; color: #3b82f6; }
.role-tab.aktif { background: #3b82f6; color: #fff; border-color: #3b82f6; }
.matrix-table th { background: #f8f9fa; font-weight: 600; font-size: 13px; }
.matrix-table td { vertical-align: middle; font-size: 14px; }
.matrix-table .modul-label { font-weight: 600; color: #334155; }
.form-check-input { width: 18px; height: 18px; cursor: pointer; }
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-10">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="paper-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="m-0 font-weight-bold text-dark">Izin Akses per Role</h4>
                    <a href="<?= base_url('manajemen_user') ?>" class="btn btn-light btn-modern border">
                        <i class="mdi mdi-account-group"></i> Manajemen User
                    </a>
                </div>

                <!-- Filter Role -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <label class="form-label small fw-semibold mb-0 text-nowrap">Per Role</label>
                    <select id="selectRole" class="form-select form-select-sm" style="min-width:180px;" onchange="window.location.href='<?= base_url('izin_akses') ?>?role='+this.value">
                        <?php foreach ($daftar_role as $role_key => $role_label): ?>
                        <option value="<?= $role_key ?>" <?= $role_aktif === $role_key ? 'selected' : '' ?>>
                            <?= $role_label ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <form action="<?= base_url('izin_akses/simpan_izin') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="role" value="<?= esc($role_aktif) ?>">

                    <div class="table-responsive">
                        <table class="table table-hover matrix-table align-middle">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Akses Halaman</th>
                                    <th class="text-center" width="15%">
                                        <i class="mdi mdi-eye text-info"></i> Lihat
                                    </th>
                                    <th class="text-center" width="15%">
                                        <i class="mdi mdi-plus-circle text-success"></i> Tambah
                                    </th>
                                    <th class="text-center" width="15%">
                                        <i class="mdi mdi-pencil text-warning"></i> Edit
                                    </th>
                                    <th class="text-center" width="15%">
                                        <i class="mdi mdi-delete text-danger"></i> Hapus
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($daftar_modul as $modul_key => $modul_label): ?>
                                    <?php $izin = $izin_per_modul[$modul_key] ?? []; ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td class="modul-label"><?= $modul_label ?></td>
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

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-modern px-5">
                            <i class="mdi mdi-content-save"></i> Simpan Izin Akses
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
