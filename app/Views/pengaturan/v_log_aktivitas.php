<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <div class="card border">
                <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold"><i class="mdi mdi-shield-account-outline me-2 text-primary"></i>Log Aktivitas</h5>
                    <span class="text-muted small"><?= count($logs) ?> data terbaru</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width:50px;">No</th>
                                    <th>Nama User</th>
                                    <th>Role</th>
                                    <th>Halaman Terakhir Dibuka</th>
                                    <th>IP Address</th>
                                    <th>Browser / Device</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($logs)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data log aktivitas.</td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($logs as $log): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= esc($log['nama_user'] ?? '-') ?></td>
                                    <td>
                                        <?php
                                        $badge = match($log['role'] ?? '') {
                                            'admin'          => 'bg-danger',
                                            'pemilik_startup'=> 'bg-primary',
                                            default          => 'bg-secondary',
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
