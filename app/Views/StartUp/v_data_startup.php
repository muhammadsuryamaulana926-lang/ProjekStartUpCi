<?php /* View: Data Startup — menampilkan tabel semua startup dengan aksi detail, edit, dan hapus */ ?>
<!-- Import Font Inter & Lucide Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    /* Global Typography & Background */
    .app-content {
        font-family: 'Inter', sans-serif !important;
        background-color: #f8fafc !important;
        padding: 32px 28px;
    }
    .page-header {
        margin-bottom: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-header h2 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }
    .page-header .subtitle {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        margin: 0;
    }

    /* Card Data Table */
    .card-premium {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }
    .card-header-custom {
        padding: 24px 32px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
    }
    .section-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.3px;
    }

    /* Button Primary */
    .btn-submit-primary, .btn-primary {
        background: #6366f1;
        border: 1.5px solid #6366f1;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 24px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 6px rgba(99, 102, 241, 0.2);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit-primary:hover, .btn-primary:hover {
        background: #4f46e5;
        border-color: #4f46e5;
        box-shadow: 0 6px 12px rgba(99, 102, 241, 0.3);
        transform: translateY(-1px);
    }

    /* Datatable styling modern */
    #tabel_startup { font-family: 'Inter', sans-serif; width: 100% !important; margin-bottom: 1rem; }
    #tabel_startup td, #tabel_startup th { vertical-align: middle; font-size: 14px; color: #334155; }
    #tabel_startup thead th { 
        background: #f8fafc; 
        font-size: 11px; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.1em; 
        color: #64748b; 
        border-bottom: 2px solid #e2e8f0 !important; 
        padding: 14px 16px; 
    }
    #tabel_startup tbody td {
        border-bottom: 1px solid #f1f5f9;
        padding: 14px 16px;
    }
    
    div.dataTables_wrapper div.dataTables_filter input,
    div.dataTables_wrapper div.dataTables_length select {
        border: 1.5px solid #e2e8f0; 
        border-radius: 8px; 
        padding: 8px 14px; 
        font-size: 13px; 
        outline: none; 
        transition: all 0.2s;
        font-family: inherit;
        color: #0f172a;
    }
    div.dataTables_wrapper div.dataTables_filter input:focus,
    div.dataTables_wrapper div.dataTables_length select:focus { 
        border-color: #6366f1; 
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); 
    }
    
    div.dataTables_wrapper div.dataTables_paginate .paginate_button.current,
    div.dataTables_wrapper div.dataTables_paginate .paginate_button.current:hover {
        background: #6366f1 !important; 
        color: #fff !important; 
        border: none !important; 
        border-radius: 8px !important; 
        font-weight: 600;
    }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover {
        background: #f1f5f9 !important; 
        color: #334155 !important; 
        border: none !important; 
        border-radius: 8px !important;
    }
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_paginate { margin-top: 1.5rem; font-size: 13px; color: #64748b; }
    div.dataTables_wrapper div.dataTables_filter,
    div.dataTables_wrapper div.dataTables_length { margin-bottom: 1.5rem; font-size: 13px; color: #64748b; }

    table.dataTable { clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; border-collapse: collapse !important; }
    table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc { outline: none !important; }
    
    /* Aksi Buttons */
    .btn-action {
        background: transparent;
        border: none;
        color: #94a3b8;
        padding: 8px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-action:hover {
        background: #f1f5f9;
        color: #6366f1;
    }
    .btn-action.btn-danger-hover:hover {
        background: #fef2f2;
        color: #ef4444;
    }
    .btn-action svg {
        width: 18px;
        height: 18px;
    }

    /* Badges */
    .badge-custom {
        padding: 6px 14px; 
        border-radius: 24px; 
        font-size: 11px; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.05em; 
        display: inline-block;
    }
    .badge-blue { background: rgba(99,102,241,0.1); color: #6366f1; }
    .badge-green { background: rgba(34,197,94,0.1); color: #16a34a; }
</style>

<div class="app-content">
    <div class="card-premium">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span class="section-title mb-0">Data Startup</span>
            <a href="<?= base_url('v_tambah_startup') ?>" class="btn-submit-primary btn-sm"><i data-lucide="plus" style="width: 18px; height: 18px;"></i> Tambah Startup</a>
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
                        <td class="company-name" style="text-transform: capitalize; font-weight: 500;"><?= strtolower(esc($row->nama_perusahaan)) ?></td>
                        <td class="cell-text" style="text-transform: lowercase; font-weight: 400;"><?= esc($row->email_perusahaan) ?></td>
                        <td class="cell-text" style="font-weight: 400;"><?= esc($row->nomor_whatsapp) ?></td>
                        <td class="cell-text" style="font-weight: 400;"><?= esc($row->tahun_daftar) ?></td>
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
        lucide.createIcons();
        // Inisialisasi DataTables pada tabel startup dengan pengaturan bahasa dan empty state kustom
        $('#tabel_startup').DataTable({
            processing: true,
            language: {
                processing: `<div style="display:flex;align-items:center;justify-content:center;gap:8px;padding:24px;color:#6366f1;">
                                <i data-lucide="loader-circle" style="animation: spin 1s linear infinite;"></i> Memuat Data...
                             </div>`,
                emptyTable: `<div class="empty-state">
                                <i data-lucide="inbox" class="empty-state-icon" style="width:48px;height:48px;stroke-width:1.5"></i>
                                <div class="empty-state-text">Belum ada data startup yang terdaftar</div>
                            </div>`,
                zeroRecords: `<div class="empty-state">
                                <i data-lucide="search-x" class="empty-state-icon" style="width:48px;height:48px;stroke-width:1.5"></i>
                                <div class="empty-state-text">Tidak ditemukan data yang sesuai dengan pencarian</div>
                            </div>`,
                search: "Pencarian:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari total _TOTAL_ startup",
                infoEmpty: "Data tidak tersedia",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            },
            drawCallback: function() {
                lucide.createIcons();
            }
        });

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

</div><!-- end app-content -->
