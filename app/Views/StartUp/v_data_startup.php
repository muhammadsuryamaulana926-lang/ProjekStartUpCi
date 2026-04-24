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
.paper-container { max-width: 1100px; margin: 40px auto; }
.table-paper th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
</style>

<div class="container-fluid py-4" style="background-color:#f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-11">

            <?php $msg = session()->getFlashdata('msg'); if ($msg): ?>
            <div class="alert alert-<?= $msg[0] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show mb-4" role="alert">
                <?= $msg[1] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="paper-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="m-0 fw-bold text-dark">Daftar Startup</h4>
                    <a href="<?= base_url('v_tambah_startup') ?>" class="btn btn-primary btn-modern">
                        <i class="mdi mdi-plus"></i> Tambah Startup
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="tabel_startup" class="table table-hover table-paper align-middle w-100">
                        <thead>
                            <tr>
                                <th width="4%">No</th>
                                <th>Nama Perusahaan</th>
                                <th>Email</th>
                                <th>No WhatsApp</th>
                                <th class="text-center">Tahun Daftar</th>
                                <th class="text-center">Status Startup</th>
                                <th class="text-center">Status Ajuan</th>
                                <th class="text-center" width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($startups)): $no = 1; foreach ($startups as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong style="text-transform:capitalize;"><?= esc($row->nama_perusahaan) ?></strong></td>
                                <td class="text-muted small"><?= esc($row->email_perusahaan) ?></td>
                                <td class="text-muted small"><?= esc($row->nomor_whatsapp) ?></td>
                                <td class="text-center"><?= esc($row->tahun_daftar) ?></td>
                                <td class="text-center"><span class="badge bg-primary px-3 py-2"><?= esc($row->status_startup) ?></span></td>
                                <td class="text-center"><span class="badge bg-success px-3 py-2"><?= esc($row->status_ajuan) ?></span></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?= base_url('v_detail/' . $row->uuid_startup) ?>" class="btn btn-sm btn-info text-white me-1 rounded" title="Detail">
                                            <i class="mdi mdi-eye"></i> Detail
                                        </a>
                                        <button onclick="proses_edit(<?= $row->id_startup ?>)" class="btn btn-sm btn-warning text-white me-1 rounded" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        <button onclick="proses_hapus(<?= $row->id_startup ?>, '<?= esc($row->nama_perusahaan) ?>')" class="btn btn-sm btn-danger rounded" title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data startup</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<form id="post-edit-form" action="<?= base_url('v_edit_startup') ?>" method="post" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="<?= csrf_token() ?>" id="post-edit-csrf" value="<?= csrf_hash() ?>">
    <input type="hidden" name="id_startup" id="post-id-startup">
</form>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    const CSRF_NAME = '<?= csrf_token() ?>';
    const CSRF_HASH = '<?= csrf_hash() ?>';

    $(document).ready(function () {
        $('#tabel_startup').DataTable({
            language: {
                search: "Pencarian:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ startup",
                infoEmpty: "Data tidak tersedia",
                emptyTable: "Belum ada data startup yang terdaftar",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                paginate: { first: "Pertama", last: "Terakhir", next: "Lanjut", previous: "Kembali" }
            }
        });

        <?php $msg = session()->getFlashdata('msg'); if ($msg): ?>
        Swal.fire({
            icon: '<?= $msg[0] ?>',
            title: '<?= $msg[0] === 'success' ? 'Berhasil!' : 'Gagal!' ?>',
            text: '<?= $msg[1] ?>',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        <?php endif; ?>

        var _sm = sessionStorage.getItem('swal_msg');
        if (_sm) { var _sd = JSON.parse(_sm); sessionStorage.removeItem('swal_msg'); Swal.fire({ icon:_sd.icon, title:_sd.title, text:_sd.text, showConfirmButton:false, timer:2000, timerProgressBar:true }); }
    });

    function proses_edit(id_startup) {
        document.getElementById('post-id-startup').value = id_startup;
        document.getElementById('post-edit-csrf').value = CSRF_HASH;
        document.getElementById('post-edit-form').submit();
    }

    function proses_hapus(id_startup, nama) {
        Swal.fire({
            title: 'Hapus Startup?',
            text: 'Anda akan menghapus data ' + nama + ' secara permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('v_hapus_startup') ?>",
                    type: "POST",
                    data: { id_startup: id_startup, [CSRF_NAME]: CSRF_HASH },
                    success: function (res) {
                        var data = typeof res === 'string' ? JSON.parse(res) : res;
                        if (data.status) {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Startup berhasil dihapus', showConfirmButton: false, timer: 1500 })
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan sistem', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                    }
                });
            }
        });
    }
</script>
