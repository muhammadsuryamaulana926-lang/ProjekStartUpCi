<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Log Aktivitas</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Log Aktivitas <small class="text-muted fs-6 fw-normal">(<?= count($logs) ?> data terbaru)</small></h4>
                            <div id="tabel">
                                <div class="table-responsive">
                                    <table id="datatable-log" class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th class="text-center" style="min-width:40px;">No</th>
                                                <th style="min-width:130px;">Nama User</th>
                                                <th style="min-width:80px;">Role</th>
                                                <th style="min-width:200px;">Halaman Terakhir Dibuka</th>
                                                <th style="min-width:100px;">IP Address</th>
                                                <th style="min-width:150px;">Browser / Device</th>
                                                <th style="min-width:130px;">Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($logs)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Belum ada data log aktivitas.</td>
                                            </tr>
                                            <?php else: ?>
                                            <?php $no = 1; foreach ($logs as $log): ?>
                                            <tr>
                                                <td style="text-align:center;"><?= $no++ ?>.</td>
                                                <td><?= esc($log['nama_user'] ?? '-') ?></td>
                                                <td>
                                                    <?php
                                                    $badge = match($log['role'] ?? '') {
                                                        'admin'           => 'bg-danger',
                                                        'pemilik_startup' => 'bg-primary',
                                                        default           => 'bg-secondary',
                                                    };
                                                    ?>
                                                    <span class="badge <?= $badge ?>"><?= esc($log['role'] ?? '-') ?></span>
                                                </td>
                                                <td><small class="text-muted"><?= esc($log['halaman'] ?? '-') ?></small></td>
                                                <td><code><?= in_array($log['ip_address'], ['::1', '127.0.0.1']) ? 'localhost' : esc($log['ip_address'] ?? '-') ?></code></td>
                                                <td><small class="text-muted"><?= esc(substr($log['user_agent'] ?? '-', 0, 60)) ?>...</small></td>
                                                <td><small><?= date('d M Y H:i:s', strtotime($log['dibuat_pada'])) ?></small></td>
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
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#datatable-log')) {
        $('#datatable-log').DataTable({
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
    }
});
</script>
