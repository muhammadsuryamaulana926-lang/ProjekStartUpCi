<?php /* View: Dashboard Startup — menampilkan ringkasan total startup dan tabel detail via modal */ ?>
<style>
    .card-startup-hover {
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer;
    }
    .card-startup-hover:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    #datatable-startup td, #datatable-startup th { vertical-align: middle; font-size: 13px; }
    #datatable-startup thead th { background: var(--slate-50); font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.15em; color: var(--slate-500); border-bottom: 2px solid var(--slate-200); }
    div.dataTables_wrapper div.dataTables_filter input,
    div.dataTables_wrapper div.dataTables_length select {
        border: 1px solid var(--slate-200); border-radius: 8px; padding: 4px 10px; font-size: 13px; outline: none;
    }
    div.dataTables_wrapper div.dataTables_filter input:focus { border-color: var(--primary); }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button.current,
    div.dataTables_wrapper div.dataTables_paginate .paginate_button.current:hover {
        background: var(--primary) !important; color: #fff !important; border: none !important; border-radius: 6px !important;
    }
    div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover {
        background: var(--slate-100) !important; color: var(--slate-700) !important; border: none !important; border-radius: 6px !important;
    }
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_paginate { margin-top: 1rem; }
    div.dataTables_wrapper div.dataTables_filter,
    div.dataTables_wrapper div.dataTables_length { margin-bottom: 1rem; }
    .badge-status {
        padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.1em; display: inline-block;
    }
    .badge-aktif    { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .badge-nonaktif { background: rgba(239,68,68,0.1);  color: #dc2626; }
    .badge-pending  { background: rgba(245,158,11,0.1); color: #d97706; }
    .badge-diterima { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .badge-ditolak  { background: rgba(239,68,68,0.1);  color: #dc2626; }
</style>

<div class="app-content">

    <!-- Kartu statistik: klik untuk membuka modal daftar lengkap startup -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card-premium card-startup-hover p-3 d-flex justify-content-between align-items-center"
                 style="border-radius:10px;background-color:#fff;"
                 data-bs-toggle="modal" data-bs-target="#modalDetailStartup">
                <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo DKST" style="height:55px;width:auto;object-fit:contain;">
                <div class="text-end">
                    <div style="font-size:2rem;font-weight:800;line-height:1;"><?= $total_startup ?></div>
                    <div class="text-muted" style="font-size:13px;font-weight:600;">Total Startup</div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal popup berisi tabel lengkap semua data startup -->
<div class="modal fade" id="modalDetailStartup" tabindex="-1" aria-hidden="true" style="padding-top:100px;">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width:1100px;">
        <div class="modal-content" style="border-radius:16px;border:1.5px solid var(--slate-100);">
            <div class="modal-header" style="border-bottom:1.5px solid var(--slate-100);padding:1.25rem 1.75rem;">
                <div>
                    <h5 class="modal-title mb-0" style="font-weight:900;font-size:14px;text-transform:uppercase;letter-spacing:0.1em;color:var(--slate-900);">Daftar Startup</h5>
                    <p class="mb-0 mt-1" style="font-size:10px;color:var(--slate-400);font-weight:700;text-transform:uppercase;letter-spacing:0.15em;">Total <?= $total_startup ?> startup terdaftar</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:1.5rem 1.75rem;">
                <div class="table-responsive">
                    <table id="datatable-startup" class="table table-hover w-100">
                        <thead>
                            <tr>
                                <th style="width:48px;">No</th>
                                <th>Nama Perusahaan</th>
                                <th>Email</th>
                                <th>No WhatsApp</th>
                                <th class="text-center" style="width:110px;">Tahun Daftar</th>
                                <th class="text-center" style="width:130px;">Status Startup</th>
                                <th class="text-center" style="width:130px;">Status Ajuan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS dan JS DataTables untuk tabel interaktif dengan fitur pencarian dan paginasi -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTables pada tabel startup di dalam modal
    var tableStartup = $('#datatable-startup').DataTable({
        "autoWidth": false,
        "destroy": true,
        "language": {
            "emptyTable": "Tidak ada data startup",
            "processing": "Memuat data...",
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_-_END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data",
            "paginate": { "previous": "‹", "next": "›" }
        },
        "columns": [
            { "data": null, "className": "text-center", "width": "48px",
              "render": function(data, type, row, meta) { return '<span style="font-weight:700;color:var(--slate-400);">' + (meta.row + 1) + '</span>'; } },
            { "data": "nama_perusahaan", "render": function(data) {
                return '<span style="font-weight:700;color:var(--slate-800);">' + data + '</span>';
            }},
            { "data": "email_perusahaan", "render": function(data) {
                return '<span style="color:var(--slate-500);">' + data + '</span>';
            }},
            { "data": "nomor_whatsapp", "render": function(data) {
                return '<span style="color:var(--slate-500);">' + data + '</span>';
            }},
            { "data": "tahun_daftar", "className": "text-center", "render": function(data) {
                return '<span style="font-weight:700;">' + data + '</span>';
            }},
            { "data": "status_startup", "className": "text-center", "render": function(data) {
                var cls = data && data.toLowerCase() === 'aktif' ? 'badge-aktif' : 'badge-nonaktif';
                return '<span class="badge-status ' + cls + '">' + data + '</span>';
            }},
            { "data": "status_ajuan", "className": "text-center", "render": function(data) {
                var map = { 'pending': 'badge-pending', 'diterima': 'badge-diterima', 'ditolak': 'badge-ditolak' };
                var cls = map[(data || '').toLowerCase()] || 'badge-pending';
                return '<span class="badge-status ' + cls + '">' + data + '</span>';
            }}
        ]
    });

    // Saat modal dibuka, ambil data startup via AJAX lalu isi ke tabel
    $('#modalDetailStartup').on('shown.bs.modal', function() {
        tableStartup.clear().draw();
        $.ajax({
            url: "<?= base_url('v_dashboard/get_data_startup') ?>",
            type: "POST",
            dataType: "JSON",
            data: { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' },
            success: function(response) {
                if (response && response.length > 0) {
                    tableStartup.rows.add(response).draw();
                }
            },
            error: function() {
                alert('Gagal mengambil data dari server.');
            }
        });
    });
});
</script>
