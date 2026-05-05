<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">

            <?php if (session()->getFlashdata('success')): ?>
            <script data-flashdata>Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 2500, showConfirmButton: false });</script>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <script data-flashdata>Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('error') ?>' });</script>
            <?php endif; ?>

            <div class="card border">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <h5 class="mb-0 fw-bold"><i class="mdi mdi-account-group-outline me-2 text-primary"></i>Manajemen User</h5>
                        <a href="<?= base_url('manajemen_user/tambah_user') ?>" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Tambah User
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label small fw-semibold mb-0 text-nowrap">Filter Role</label>
                            <select id="filterRole" class="form-select form-select-sm" style="min-width:160px;">
                                <option value="">Semua Role</option>
                                <?php foreach ($daftar_role as $key => $label): ?>
                                <option value="<?= $key ?>"><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label small fw-semibold mb-0">Search:</label>
                            <input type="text" id="customSearch" class="form-control form-control-sm" style="min-width:200px;">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tabelUser" class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width:50px;">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data user.</td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($users as $u): ?>
                                <tr data-nama="<?= strtolower(esc($u['nama_lengkap'])) ?>" data-email="<?= strtolower(esc($u['email'])) ?>" data-role="<?= esc($u['role']) ?>">
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><strong><?= esc($u['nama_lengkap']) ?></strong></td>
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
                                    <td class="text-center">
                                        <form action="<?= base_url('manajemen_user/toggle_aktif') ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="uuid_user" value="<?= $u['uuid_user'] ?>">
                                            <input type="hidden" name="is_active" value="<?= $u['is_active'] ? 0 : 1 ?>">
                                            <button type="submit" class="btn btn-sm <?= $u['is_active'] ? 'btn-success' : 'btn-secondary' ?>"
                                                onclick="return swalConfirm(this.closest('form'))">
                                                <i class="mdi <?= $u['is_active'] ? 'mdi-check-circle' : 'mdi-close-circle' ?>"></i>
                                                <?= $u['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('manajemen_user/edit_user/' . $u['uuid_user']) ?>" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="<?= base_url('manajemen_user/hapus_user') ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="uuid_user" value="<?= $u['uuid_user'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return swalConfirm(this.closest('form'))">
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
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// Cegah inisialisasi DataTable berkali-kali
if (!window.manajemenUserTableInitialized) {
    window.manajemenUserTableInitialized = true;
    
    $(document).ready(function() {
        // Destroy DataTable jika sudah ada
        if ($.fn.DataTable.isDataTable('#tabelUser')) {
            $('#tabelUser').DataTable().destroy();
        }
        
        var table = $('#tabelUser').DataTable({
            pageLength: 10,
            ordering: false,
            dom: '<"d-flex align-items-center justify-content-between px-3 py-2"l>rt<"d-flex align-items-center justify-content-between px-3 py-2"ip>',
            language: {
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                paginate: { previous: 'Previous', next: 'Next' }
            }
        });

        $('#customSearch').on('keyup', function() {
            table.search($(this).val()).draw();
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
    });
}

function swalConfirm(form) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then(function(result) {
        if (result.isConfirmed) form.submit();
    });
    return false;
}
</script>
