<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Histori Login</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Histori Login <small class="text-muted fs-6 fw-normal">(<?= count($history) ?> data)</small></h4>
                            <div class="d-flex align-items-end justify-content-between mb-2 flex-wrap gap-2">
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
                            </div>
                            <div id="tabel">
                                <div class="table-responsive">
                                    <table id="tabelLogin" class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th class="text-center" style="min-width:40px;">No</th>
                                                <th style="min-width:130px;">Nama Pengguna</th>
                                                <th style="min-width:130px;">Email</th>
                                                <th style="min-width:100px;">IP Address</th>
                                                <th style="min-width:120px;">Nama Perangkat</th>
                                                <th style="min-width:120px;">Web Browser</th>
                                                <th class="text-center" style="min-width:80px;">Status</th>
                                                <th style="min-width:130px;">Tanggal Login</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($history)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center">Belum ada data histori login.</td>
                                            </tr>
                                            <?php else: ?>
                                            <?php foreach ($history as $h): ?>
                                            <tr data-nama="<?= esc($h['nama_pengguna'] ?? '') ?>"
                                                data-tanggal="<?= esc($h['tanggal_login'] ?? '') ?>">
                                                <td style="text-align:center;"></td>
                                                <td><?= esc($h['nama_pengguna'] ?? '-') ?></td>
                                                <td><?= esc($h['email'] ?? '-') ?></td>
                                                <td><code><?= in_array($h['ip_address'], ['::1', '127.0.0.1']) ? 'localhost' : esc($h['ip_address'] ?? '-') ?></code></td>
                                                <td><?= esc($h['nama_perangkat'] ?? '-') ?></td>
                                                <td><?= esc($h['web_browser'] ?? '-') ?></td>
                                                <td style="text-align:center;">
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

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#tabelLogin')) {
        var table = $('#tabelLogin').DataTable({
            pageLength: 10,
            ordering: false,
            destroy: true,
            autoWidth: false,
            language: {
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                paginate: { previous: 'Previous', next: 'Next' }
            },
            columnDefs: [{
                targets: 0,
                render: function(data, type, row, meta) {
                    return type === 'display' ? (meta.row + 1) + '.' : meta.row;
                }
            }]
        });

        $('#select-user').on('change', function() { applyFilters(); });
        $('#select-timeframe').on('change', function() { applyFilters(); });

        function applyFilters() {
            var user      = $('#select-user').val();
            var timeframe = $('#select-timeframe').val();
            var today     = new Date();

            $.fn.dataTable.ext.search.pop();
            $.fn.dataTable.ext.search.pop();

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var row     = table.row(dataIndex).node();
                var rowNama = $(row).data('nama') || '';
                var rowTgl  = $(row).data('tanggal') || '';

                if (user && rowNama !== user) return false;

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
    }
});
</script>
