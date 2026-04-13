<?php /* View: Dashboard Startup — menampilkan ringkasan total startup dan tabel detail via modal */ ?>
<!-- Import Font Inter & Lucide Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    /* Global Typography & Background */
    .app-content {
        font-family: 'Inter', sans-serif !important;
        background-color: #f8fafc !important; /* Abu sangat muda */
        padding: 32px 28px;
        min-height: 100vh;
    }

    /* Dashboard Header */
    .dashboard-header {
        margin-bottom: 32px;
    }
    .dashboard-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }
    .dashboard-subtitle {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    /* Card Design Minimalis & Clean */
    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px 28px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(99, 102, 241, 0.08), 0 4px 8px rgba(99, 102, 241, 0.04);
        border-color: #e0e7ff;
    }

    /* Icon Container - Primary Soft Blue/Purple */
    .stat-icon {
        width: 64px;
        height: 64px;
        background: rgba(99, 102, 241, 0.1); /* Indigo soft */
        color: #6366f1; /* Indigo primary */
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    .stat-card:hover .stat-icon {
        transform: scale(1.05) rotate(5deg);
    }

    /* Typography di dalam Card */
    .stat-info {
        flex: 1;
    }
    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .stat-value {
        font-size: 36px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        letter-spacing: -1px;
    }

    .stat-action {
        color: #cbd5e1;
        transition: color 0.2s;
    }
    .stat-card:hover .stat-action {
        color: #6366f1;
    }

    /* Datatable styling modern */
    #datatable-startup { font-family: 'Inter', sans-serif; }
    #datatable-startup td, #datatable-startup th { vertical-align: middle; font-size: 14px; color: #334155; }
    #datatable-startup thead th { 
        background: #f8fafc; 
        font-size: 11px; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.1em; 
        color: #64748b; 
        border-bottom: 2px solid #e2e8f0; 
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
    }
    div.dataTables_wrapper div.dataTables_filter input:focus { 
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
    
    .badge-status {
        padding: 6px 14px; 
        border-radius: 24px; 
        font-size: 11px; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.05em; 
        display: inline-block;
    }
    .badge-aktif    { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .badge-nonaktif { background: rgba(239,68,68,0.1);  color: #dc2626; }
    .badge-pending  { background: rgba(245,158,11,0.1); color: #d97706; }
    .badge-diterima { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .badge-ditolak  { background: rgba(239,68,68,0.1);  color: #dc2626; }

    /* Modal Styling Modern - Clean Minimalis */
    .modal-modern .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 24px 48px rgba(0,0,0,0.12);
        overflow: hidden;
        font-family: 'Inter', sans-serif;
    }
    .modal-modern .modal-header {
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 24px 32px;
        align-items: flex-start;
    }
    .modal-modern .modal-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.3px;
    }
    .modal-modern .modal-subtitle {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }
    .modal-modern .btn-close {
        padding: 12px;
        margin-top: -4px;
        opacity: 0.5;
        transition: opacity 0.2s;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230f172a'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }
    .modal-modern .btn-close:hover {
        opacity: 1;
    }
    .modal-modern .modal-body {
        padding: 32px;
        background: #ffffff;
    }
</style>

<div class="app-content">

    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard Utama</h1>
        <p class="dashboard-subtitle">Ringkasan performa dan data pertumbuhan startup dalam ekosistem.</p>
    </div>

    <!-- Kartu statistik: klik untuk membuka modal daftar lengkap startup -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="stat-card" data-bs-toggle="modal" data-bs-target="#modalDetailStartup">
                <div class="stat-icon">
                    <i data-lucide="rocket"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Startup Terdaftar</div>
                    <div class="stat-value"><?= $total_startup ?></div>
                </div>
                <div class="stat-action">
                    <i data-lucide="chevron-right"></i>
                </div>
            </div>
        </div>
        <!-- Ruang untuk kartu lain di masa depan, misal "Total Pengguna Aktif" -->
    </div>

</div>

<!-- Modal popup berisi tabel lengkap semua data startup -->
<div class="modal fade modal-modern" id="modalDetailStartup" tabindex="-1" aria-hidden="true" style="padding-top:20px;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Daftar Startup Terdaftar</h5>
                    <div class="modal-subtitle">Total keseluruhan <?= $total_startup ?> startup terdaftar di dalam sistem saat ini.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="datatable-startup" class="table table-hover w-100 table-borderless align-middle">
                        <thead>
                            <tr>
                                <th style="width:48px; border-bottom: 2px solid #e2e8f0;">No</th>
                                <th style="border-bottom: 2px solid #e2e8f0;">Nama Perusahaan</th>
                                <th style="border-bottom: 2px solid #e2e8f0;">Email</th>
                                <th style="border-bottom: 2px solid #e2e8f0;">No WhatsApp</th>
                                <th class="text-center" style="width:120px; border-bottom: 2px solid #e2e8f0;">Tahun Daftar</th>
                                <th class="text-center" style="width:140px; border-bottom: 2px solid #e2e8f0;">Status Startup</th>
                                <th class="text-center" style="width:140px; border-bottom: 2px solid #e2e8f0;">Status Ajuan</th>
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
// Inisiasi Lucide Icons
lucide.createIcons();

$(document).ready(function() {
    // Inisialisasi DataTables pada tabel startup di dalam modal
    var tableStartup = $('#datatable-startup').DataTable({
        "autoWidth": false,
        "destroy": true,
        "language": {
            "emptyTable": "Tidak ada data startup",
            "processing": "Memuat data...",
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ baris",
            "info": "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
            "infoEmpty": "Tidak ada data yang tersedia",
            "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" }
        },
        "columns": [
            { "data": null, "className": "text-center", "width": "48px",
              "render": function(data, type, row, meta) { return '<span style="font-weight:600;color:#94a3b8;">' + (meta.row + 1) + '</span>'; } },
            { "data": "nama_perusahaan", "render": function(data) {
                return '<span style="font-weight:700;color:#0f172a;">' + data + '</span>';
            }},
            { "data": "email_perusahaan", "render": function(data) {
                return '<span style="color:#64748b;">' + data + '</span>';
            }},
            { "data": "nomor_whatsapp", "render": function(data) {
                return '<span style="color:#64748b;">' + data + '</span>';
            }},
            { "data": "tahun_daftar", "className": "text-center", "render": function(data) {
                return '<span style="font-weight:600;color:#334155;">' + data + '</span>';
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
