<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <div class="card border">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0 fw-bold"><i class="mdi mdi-login me-2 text-primary"></i>Histori Login</h5>
                        <span class="text-muted small"><?= count($history) ?> data</span>
                    </div>
                    <div class="d-flex align-items-end justify-content-between gap-3 flex-wrap">
                        <div class="d-flex align-items-end gap-3 flex-wrap">
                            <div>
                                <label class="form-label small fw-semibold mb-1">Rentang Waktu</label>
                                <select id="select-timeframe" class="form-select form-select-sm" style="min-width:140px;">
                                    <option value="">Semua</option>
                                    <option value="today">Hari Ini</option>
                                    <option value="month">Bulan Ini</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label small fw-semibold mb-1">Pengguna</label>
                                <select id="select-user" class="form-select form-select-sm" style="min-width:180px;">
                                    <option value="">Semua Pengguna</option>
                                    <?php foreach ($users as $user): ?>
                                    <option value="<?= esc($user['nama_lengkap']) ?>">
                                        <?= esc($user['nama_lengkap']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label small fw-semibold mb-0">Search:</label>
                            <input type="text" id="customSearch" class="form-control form-control-sm" style="min-width:200px;">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tabelLogin" class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width:50px;">No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>IP Address</th>
                                    <th>Nama Perangkat</th>
                                    <th>Web Browser</th>
                                    <th>Status</th>
                                    <th>Tanggal Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($history)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada data histori login.</td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($history as $h): ?>
                                <tr data-nama="<?= esc($h['nama_pengguna'] ?? '') ?>"
                                    data-tanggal="<?= esc($h['tanggal_login'] ?? '') ?>">
                                    <td class="text-center"></td>
                                    <td><?= esc($h['nama_pengguna'] ?? '-') ?></td>
                                    <td><?= esc($h['email'] ?? '-') ?></td>
                                    <td><code><?= in_array($h['ip_address'], ['::1', '127.0.0.1']) ? 'localhost' : esc($h['ip_address'] ?? '-') ?></code></td>
                                    <td><?= esc($h['nama_perangkat'] ?? '-') ?></td>
                                    <td><?= esc($h['web_browser'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($h['status'] === 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><small><?= date('d-m-Y H:i:s', strtotime($h['tanggal_login'])) ?></small></td>
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
$(document).ready(function() {
    // Destroy DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#tabelLogin')) {
        $('#tabelLogin').DataTable().destroy();
    }
    
    var table = $('#tabelLogin').DataTable({
        pageLength: 10,
        ordering: false,
        dom: '<"d-flex align-items-center justify-content-between px-3 py-2"l>rt<"d-flex align-items-center justify-content-between px-3 py-2"ip>',
        language: {
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: { previous: 'Previous', next: 'Next' }
        },
        columnDefs: [{ targets: 0, render: function(data, type, row, meta) { return type === 'display' ? meta.row + 1 + '.' : meta.row; } }]
    });

    // Custom search
    $('#customSearch').on('keyup', function() {
        table.search($(this).val()).draw();
    });

    // Filter pengguna (kolom 1)
    $('#select-user').on('change', function() {
        applyFilters();
    });

    // Filter rentang waktu
    $('#select-timeframe').on('change', function() {
        applyFilters();
    });

    function applyFilters() {
        var user     = $('#select-user').val();
        var timeframe = $('#select-timeframe').val();
        var today    = new Date();

        $.fn.dataTable.ext.search.pop();
        $.fn.dataTable.ext.search.pop();

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var row      = table.row(dataIndex).node();
            var rowNama  = $(row).data('nama') || '';
            var rowTgl   = $(row).data('tanggal') || '';

            // Filter pengguna
            if (user && rowNama !== user) return false;

            // Filter rentang waktu
            if (timeframe && rowTgl) {
                var tgl = new Date(rowTgl);
                if (timeframe === 'today') {
                    if (tgl.toDateString() !== today.toDateString()) return false;
                } else if (timeframe === 'month') {
                    if (tgl.getMonth() !== today.getMonth() || tgl.getFullYear() !== today.getFullYear()) return false;
                }
            }

            return true;
        });

        table.draw();
    }
});
</script>
