<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">

            <div class="card border">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0 fw-bold"><i class="mdi mdi-history me-2 text-primary"></i>Riwayat Aktivitas</h5>
                        <span class="text-muted small"><?= count($riwayat) ?> data</span>
                    </div>
                    <form id="filterForm" method="GET" action="<?= base_url('v_riwayat_aktivitas') ?>" class="d-flex align-items-end gap-3 flex-wrap">
                        <input type="hidden" name="timeframe" id="timeframe_input" value="<?= $current_filters['timeframe'] ?? '' ?>">
                        <div>
                            <label class="form-label small fw-semibold mb-1">Rentang Waktu</label>
                            <select name="timeframe_select" id="select-timeframe" class="form-select form-select-sm" style="min-width:150px;">
                                <option value="" <?= empty($current_filters['timeframe']) ? 'selected' : '' ?>>Semua</option>
                                <option value="day"   <?= ($current_filters['timeframe'] ?? '') == 'day'   ? 'selected' : '' ?>>Hari Ini</option>
                                <option value="month" <?= ($current_filters['timeframe'] ?? '') == 'month' ? 'selected' : '' ?>>Bulan Ini</option>
                                <option value="year"  <?= ($current_filters['timeframe'] ?? '') == 'year'  ? 'selected' : '' ?>>Tahun Ini</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label small fw-semibold mb-1">Pengguna</label>
                            <select name="id_user" id="select-user" class="form-select form-select-sm" style="min-width:200px;">
                                <option value="">Semua Pengguna</option>
                                <?php foreach ($users as $user): ?>
                                <option value="<?= base64_encode($user['id_user']) ?>" <?= ($current_filters['raw_id_user'] ?? '') == base64_encode($user['id_user']) ? 'selected' : '' ?>>
                                    <?= esc($user['nama_lengkap']) ?> (<?= esc($user['role']) ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if (!empty($current_filters['timeframe']) || !empty($current_filters['raw_id_user'])): ?>
                        <a href="<?= base_url('v_riwayat_aktivitas') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center" style="width:50px;">No</th>
                                    <th>Nama User</th>
                                    <th>Role</th>
                                    <th>Jenis</th>
                                    <th>Judul Konten</th>
                                    <th>Progress</th>
                                    <th>Terakhir Diakses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($riwayat)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data riwayat aktivitas.</td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($riwayat as $r): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= esc($r['nama_lengkap']) ?></td>
                                    <td><span class="badge <?= $r['role'] === 'admin' ? 'bg-danger' : 'bg-primary' ?>"><?= esc($r['role']) ?></span></td>
                                    <td>
                                        <?php if ($r['jenis_item'] === 'video'): ?>
                                        <span class="badge bg-danger"><i class="mdi mdi-play-circle me-1"></i>Video</span>
                                        <?php else: ?>
                                        <span class="badge bg-success"><i class="mdi mdi-book-open me-1"></i>Ebook</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($r['jenis_item'] === 'video'): ?>
                                            <?= esc($r['judul_video'] ?? '-') ?>
                                        <?php else: ?>
                                            <?= esc($r['judul_ebook'] ?? '-') ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($r['jenis_item'] === 'video'): ?>
                                            <small><?= floor($r['durasi'] / 60) . ':' . sprintf('%02d', $r['durasi'] % 60) ?> menit</small>
                                        <?php else: ?>
                                            <small>Halaman <?= $r['halaman_terakhir'] ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><small><?= date('d M Y H:i', strtotime($r['updated_at'])) ?></small></td>
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

<script>
$(document).ready(function() {
    $('#select-timeframe').on('change', function() {
        document.getElementById('timeframe_input').value = $(this).val();
        document.getElementById('filterForm').submit();
    });
    $('#select-user').on('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
