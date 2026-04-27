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
.table-paper th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}
.btn-modern {
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
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
                    <h4 class="m-0 font-weight-bold text-dark">Manajemen User</h4>
                    <a href="<?= base_url('manajemen_user/tambah_user') ?>" class="btn btn-primary btn-modern">
                        <i class="mdi mdi-plus"></i> Tambah User
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-paper align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data user.</td>
                            </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= esc($u['nama_lengkap']) ?></strong></td>
                                    <td><?= esc($u['email']) ?></td>
                                    <td>
                                        <?php
                                            $badge_warna = [
                                                'admin'           => 'bg-primary',
                                                'superadmin'      => 'bg-dark',
                                                'pemateri'        => 'bg-success',
                                                'pemilik_startup' => 'bg-warning text-dark',
                                            ];
                                            $badge_label = [
                                                'admin'           => 'Admin',
                                                'superadmin'      => 'Superadmin',
                                                'pemateri'        => 'Pemateri',
                                                'pemilik_startup' => 'Pemilik Startup',
                                            ];
                                        ?>
                                        <span class="badge <?= $badge_warna[$u['role']] ?? 'bg-secondary' ?> px-3 py-2">
                                            <?= $badge_label[$u['role']] ?? ucfirst($u['role']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="<?= base_url('manajemen_user/toggle_aktif') ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_user" value="<?= $u['id_user'] ?>">
                                            <input type="hidden" name="is_active" value="<?= $u['is_active'] ? 0 : 1 ?>">
                                            <button type="submit" class="btn btn-sm <?= $u['is_active'] ? 'btn-success' : 'btn-secondary' ?> rounded"
                                                onclick="return confirm('Ubah status user ini?')" title="<?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                                <i class="mdi <?= $u['is_active'] ? 'mdi-check-circle' : 'mdi-close-circle' ?>"></i>
                                                <?= $u['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('manajemen_user/edit_user/' . $u['id_user']) ?>" class="btn btn-sm btn-warning text-white rounded" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="<?= base_url('manajemen_user/hapus_user') ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_user" value="<?= $u['id_user'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger rounded" onclick="return confirm('Yakin hapus user ini? Data tidak dapat dikembalikan.')" title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
