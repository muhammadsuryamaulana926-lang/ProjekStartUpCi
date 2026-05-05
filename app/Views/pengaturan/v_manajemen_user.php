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

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>
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
                            <h4 class="header-title mb-3">Daftar User</h4>
                            <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="mb-0 small fw-semibold text-nowrap">Filter Role:</label>
                                    <select id="filterRole" class="form-select form-select-sm" style="min-width:160px;">
                                        <option value="">Semua Role</option>
                                        <?php foreach ($daftar_role as $key => $label): ?>
                                        <option value="<?= $key ?>"><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <a href="<?= base_url('manajemen_user/tambah_user') ?>" class="btn btn-md btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-plus"></i> Tambah User
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="tabelUser" class="table table-bordered">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th class="text-center" style="min-width:40px;">No</th>
                                            <th style="min-width:150px;">Nama Lengkap</th>
                                            <th style="min-width:150px;">Email</th>
                                            <th style="min-width:100px;">Role</th>
                                            <th class="text-center" style="min-width:100px;">Status</th>
                                            <th class="text-center" style="min-width:100px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada data user.</td>
                                        </tr>
                                        <?php else: ?>
                                        <?php $no = 1; foreach ($users as $u): ?>
                                        <tr data-role="<?= esc($u['role']) ?>">
                                            <td style="text-align:center;"><?= $no++ ?>.</td>
                                            <td><b><?= esc($u['nama_lengkap']) ?></b></td>
                                            <td><?= esc($u['email']) ?></td>
                                            <td>
                                                <?php
                                                $badge_warna = [
                                                    'admin'           => 'bg-primary',
                                                    'superadmin'      => 'bg-dark',
                                                    'pemateri'        => 'bg-success',
                                                    'pemilik_startup' => 'bg-warning text-dark',
                                                    'pemilik_ipp'     => 'bg-info text-dark',
                                                ];
                                                ?>
                                                <span class="badge <?= $badge_warna[$u['role']] ?? 'bg-secondary' ?>">
                                                    <?= esc($daftar_role[$u['role']] ?? ucwords(str_replace('_', ' ', $u['role']))) ?>
                                                </span>
                                            </td>
                                            <td style="text-align:center;">
                                                <form action="<?= base_url('manajemen_user/toggle_aktif') ?>" method="POST" class="d-inline" onsubmit="return konfirmasiToggle(this)">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="uuid_user" value="<?= $u['uuid_user'] ?>">
                                                    <input type="hidden" name="is_active" value="<?= $u['is_active'] ? 0 : 1 ?>">
                                                    <button type="submit" class="btn btn-sm <?= $u['is_active'] ? 'btn-success' : 'btn-secondary' ?>">
                                                        <i class="mdi <?= $u['is_active'] ? 'mdi-check-circle' : 'mdi-close-circle' ?>"></i>
                                                        <?= $u['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="text-align:center;">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Pilih <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?= base_url('manajemen_user/edit_user/' . $u['uuid_user']) ?>"><i class="mdi mdi-pencil"></i> Ubah</a>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="konfirmasiHapus('<?= $u['uuid_user'] ?>')"><i class="mdi mdi-trash-can-outline"></i> Hapus</a>
                                                    </div>
                                                </div>
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

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->

<!-- Modal Hapus -->
<div class="modal fade" id="modal_hapus_user" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Apakah Anda yakin data user ini akan dihapus?</div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn-hapus-user-confirm"><i class="mdi mdi-check"></i> Ya</button>
                <button class="btn btn-danger" data-bs-dismiss="modal"><i class="mdi mdi-close"></i> Batal</button>
            </div>
        </div>
    </div>
</div>

<form id="form-hapus-user" action="<?= base_url('manajemen_user/hapus_user') ?>" method="POST" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="uuid_user" id="hapus-uuid-user">
</form>

<script>
var _hapusUuidUser = null;

function konfirmasiHapus(uuid) {
    _hapusUuidUser = uuid;
    $('#modal_hapus_user').modal('show');
}

document.getElementById('btn-hapus-user-confirm').addEventListener('click', function() {
    if (_hapusUuidUser) {
        document.getElementById('hapus-uuid-user').value = _hapusUuidUser;
        document.getElementById('form-hapus-user').submit();
    }
});

function konfirmasiToggle(form) {
    if (!confirm('Apakah Anda yakin mengubah status user ini?')) return false;
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#tabelUser')) {
        var table = $('#tabelUser').DataTable({
            pageLength: 10,
            ordering: false,
            destroy: true,
            autoWidth: false,
            language: {
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                paginate: { previous: 'Previous', next: 'Next' }
            }
        });

        $('#filterRole').on('change', function() {
            var role = $(this).val();
            $.fn.dataTable.ext.search.pop();
            if (role) {
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    return $(table.row(dataIndex).node()).data('role') === role;
                });
            }
            table.draw();
        });
    }
});
</script>
