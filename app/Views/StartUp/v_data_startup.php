<?php /* View: Data Startup — menampilkan tabel semua startup dengan aksi detail, edit, dan hapus */ ?>
<style>
    .app-content { background-color: #F3F4F4 !important; }

    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_filter { margin-bottom: 12px; }
    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label { font-size: 13px; color: #64748b; }
    div.dataTables_wrapper div.dataTables_length select,
    div.dataTables_wrapper div.dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 13px;
        outline: none;
    }
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_paginate { margin-top: 12px; font-size: 13px; color: #64748b; }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        font-size: 13px;
    }
    /* Hapus semua border biru bawaan DataTables */
    table.dataTable thead th,
    table.dataTable thead td { border-bottom: 1px solid #e2e8f0 !important; }
    table.dataTable.no-footer { border-bottom: 1px solid #e2e8f0 !important; }
    .dataTables_scrollHeadInner, .dataTables_scrollHead { border-bottom: none !important; }
    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_desc { outline: none !important; }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button.current,
    div.dataTables_wrapper div.dataTables_paginate .paginate_button.current:hover {
        background: #0061FF !important;
        color: #fff !important;
        border: none !important;
        border-radius: 6px !important;
    }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover {
        background: #f1f5f9 !important;
        color: #334155 !important;
        border: none !important;
    }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button {
        border: none !important;
    }
</style>

<div class="app-content">
    <div class="page-header">
        <div>
            <h2>Data Startup</h2>
            <p class="subtitle">Manajemen Data Startup</p>
        </div>
    </div>

    <div class="card-premium">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span class="section-title mb-0">Daftar Startup</span>
            <a href="<?= base_url('v_tambah_startup') ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-plus me-1"></i> Tambah Startup</a>
        </div>
        <div class="p-4">
            <table id="tabel_startup" class="table-premium w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Perusahaan</th>
                        <th>Email</th>
                        <th>No WhatsApp</th>
                        <th>Tahun Daftar</th>
                        <th>Status Startup</th>
                        <th>Status Ajuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($startups)): $no = 1; foreach ($startups as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="company-name"><?= esc($row->nama_perusahaan) ?></td>
                        <td class="cell-text"><?= esc($row->email_perusahaan) ?></td>
                        <td class="cell-text"><?= esc($row->nomor_whatsapp) ?></td>
                        <td class="cell-text"><?= esc($row->tahun_daftar) ?></td>
                        <td><span class="badge-custom badge-blue"><?= esc($row->status_startup) ?></span></td>
                        <td><span class="badge-custom badge-green"><?= esc($row->status_ajuan) ?></span></td>
                        <td>
                            <a href="<?= base_url('v_detail/' . $row->uuid_startup) ?>" class="btn-action" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <button onclick="proses_edit(<?= $row->id_startup ?>)" class="btn-action" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button onclick="proses_hapus(<?= $row->id_startup ?>, '<?= esc($row->nama_perusahaan) ?>')" class="btn-action btn-danger-hover" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="8" class="text-center p-4">Data belum tersedia</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Form tersembunyi untuk redirect ke halaman edit dengan metode POST (membawa id_startup) -->
<form id="post-edit-form" action="<?= base_url('v_edit_startup') ?>" method="post" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="<?= csrf_token() ?>" id="post-edit-csrf" value="<?= csrf_hash() ?>">
    <input type="hidden" name="id_startup" id="post-id-startup">
</form>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
    // Variabel CSRF untuk digunakan pada setiap request AJAX
    const CSRF_NAME  = '<?= csrf_token() ?>';
    const CSRF_HASH  = '<?= csrf_hash() ?>';

    $(document).ready(function () {
        // Inisialisasi DataTables pada tabel startup
        $('#tabel_startup').DataTable();

        // Tampilkan notifikasi SweetAlert dari flashdata session (setelah tambah/edit/hapus)
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

        // Tampilkan notifikasi dari sessionStorage (digunakan setelah redirect antar halaman)
        var _sm = sessionStorage.getItem('swal_msg');
        if (_sm) { var _sd = JSON.parse(_sm); sessionStorage.removeItem('swal_msg'); Swal.fire({ icon:_sd.icon, title:_sd.title, text:_sd.text, showConfirmButton:false, timer:2000, timerProgressBar:true }); }
    });

    // Redirect ke halaman edit startup menggunakan form POST (membawa id_startup)
    function proses_edit(id_startup) {
        document.getElementById('post-id-startup').value = id_startup;
        document.getElementById('post-edit-csrf').value = CSRF_HASH;
        document.getElementById('post-edit-form').submit();
    }

    // Tampilkan konfirmasi hapus, lalu kirim request AJAX hapus startup jika dikonfirmasi
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
