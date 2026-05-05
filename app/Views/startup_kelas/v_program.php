<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Program</h4>
                    </div>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <?php if (in_array(session()->get('user_role'), ['admin', 'superadmin'])): ?>
                <!-- TAMPILAN ADMIN (TABEL) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mb-3">Daftar Program</h4>
                                <div class="text-md-end mt-2 mt-md-0 mb-2">
                                    <a href="<?= base_url('program/tambah_program') ?>" class="btn btn-md btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-plus"></i> Tambah Program
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table id="datatable-program" class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th class="text-center" style="min-width:40px;">No</th>
                                                <th class="text-center" style="min-width:200px;">Nama Program</th>
                                                <th class="text-center" style="min-width:100px;">Total Kelas</th>
                                                <th class="text-center" style="min-width:100px;">Total Peserta</th>
                                                <th class="text-center" style="min-width:80px;">Status</th>
                                                <th class="text-center" style="min-width:120px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(empty($program)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Belum ada data program</td>
                                            </tr>
                                            <?php else: ?>
                                                <?php $no = 1; foreach($program as $p): ?>
                                                <tr>
                                                    <td style="text-align:center;"><?= $no++ ?>.</td>
                                                    <td>
                                                        <b><?= esc($p['nama_program']) ?></b><br>
                                                        <small class="text-muted"><?= esc(mb_strimwidth($p['deskripsi'], 0, 80, '...')) ?></small>
                                                    </td>
                                                    <td style="text-align:center;"><?= $p['jumlah_kelas'] ?> Kelas</td>
                                                    <td style="text-align:center;"><?= $p['jumlah_peserta'] ?> Orang</td>
                                                    <td style="text-align:center;">
                                                        <?php
                                                            $sp = $p['status_program'] ?? 'aktif';
                                                            $badge = $sp == 'aktif' ? 'bg-success' : ($sp == 'selesai' ? 'bg-primary' : 'bg-danger');
                                                        ?>
                                                        <span class="badge <?= $badge ?>"><?= ucfirst($sp) ?></span>
                                                    </td>
                                                    <td style="text-align:center;">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih <i class="mdi mdi-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="<?= base_url('program/detail_program/' . $p['id_program']) ?>"><i class="mdi mdi-eye"></i> Detail</a>
                                                                <a class="dropdown-item" href="<?= base_url('program/edit_program/' . $p['id_program']) ?>"><i class="mdi mdi-pencil"></i> Ubah</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="hapusProgram('<?= $p['id_program'] ?>')"><i class="mdi mdi-trash-can-outline"></i> Hapus</a>
                                                            </div>
                                                        </div>
                                                    </td>
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
            <?php else: ?>
                <!-- TAMPILAN PESERTA: semua program tampil, kelas hanya untuk yang sudah join -->
                <div class="row">
                    <div class="col-12">
                        <?php if(empty($program)): ?>
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <i class="mdi mdi-clipboard-text-outline" style="font-size:64px; color:#cbd5e1;"></i>
                                    <p class="mt-3 text-muted">Belum ada program yang tersedia.</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach($program as $p): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="header-title mb-1"><?= esc($p['nama_program']) ?></h5>
                                            <p class="text-muted small mb-0"><?= esc($p['deskripsi']) ?></p>
                                        </div>
                                        <?php if ($p['sudah_join']): ?>
                                            <span class="badge bg-success">Tergabung</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum Tergabung</span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($p['sudah_join']): ?>
                                        <?php if (empty($p['kelas'])): ?>
                                            <p class="text-muted small mt-2 mb-0"><i class="mdi mdi-calendar-blank me-1"></i> Belum ada kelas untuk program ini.</p>
                                        <?php else: ?>
                                            <div class="row g-3 mt-1">
                                            <?php foreach ($p['kelas'] as $k):
                                                $jam_mulai_k   = strtotime($k['tanggal'] . ' ' . $k['jam_mulai']);
                                                $jam_selesai_k = strtotime($k['tanggal'] . ' ' . $k['jam_selesai']);
                                                if ($jam_selesai_k <= $jam_mulai_k) {
                                                    $jam_selesai_k = strtotime('+1 day', $jam_selesai_k);
                                                }
                                                $now_k         = time();
                                                $sudah_selesai = $now_k > $jam_selesai_k;
                                                $bisa_presensi = $now_k >= ($jam_mulai_k - 1800) && $now_k <= $jam_selesai_k;
                                            ?>
                                            <div class="col-md-6">
                                                <div class="border rounded p-3">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <strong><?= esc($k['nama_kelas']) ?></strong>
                                                        <span class="badge <?= $k['status_kelas'] == 'aktif' ? 'bg-primary' : ($k['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?> ms-2">
                                                            <?= ucfirst($k['status_kelas']) ?>
                                                        </span>
                                                    </div>
                                                    <div class="text-muted small mb-3">
                                                        <i class="mdi mdi-calendar me-1"></i><?= date('d M Y', strtotime($k['tanggal'])) ?>
                                                        &nbsp;&middot;&nbsp;
                                                        <i class="mdi mdi-clock me-1"></i><?= date('H:i', strtotime($k['jam_mulai'])) ?> &ndash; <?= date('H:i', strtotime($k['jam_selesai'])) ?>
                                                        <?php if (!empty($k['nama_dosen'])): ?>
                                                        &nbsp;&middot;&nbsp;
                                                        <i class="mdi mdi-account-tie me-1"></i><?= esc($k['nama_dosen']) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if ($sudah_selesai): ?>
                                                        <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-secondary w-100">
                                                            <i class="mdi mdi-play-circle me-1"></i> Lihat Rekaman & Materi
                                                        </a>
                                                    <?php elseif (!empty($k['sudah_presensi'])): ?>
                                                        <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-success w-100">
                                                            <i class="mdi mdi-check-circle me-1"></i> Sudah Presensi — Masuk Kelas
                                                        </a>
                                                    <?php elseif ($bisa_presensi): ?>
                                                        <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-primary w-100">
                                                            <i class="mdi mdi-arrow-right-circle me-1"></i> Masuk Kelas
                                                        </a>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" disabled>
                                                            <i class="mdi mdi-lock-clock me-1"></i> Belum Waktunya
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-muted small mt-2 mb-0"><i class="mdi mdi-lock-outline me-1"></i> Anda belum terdaftar di program ini.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->

<!-- Modal Hapus -->
<div class="modal fade" id="modal_hapus_program" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Apakah Anda yakin program ini akan dihapus?</div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="btn-hapus-program-confirm"><i class="mdi mdi-check"></i> Ya</a>
                <button class="btn btn-danger" data-bs-dismiss="modal"><i class="mdi mdi-close"></i> Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
var _hapusProgramId = null;

function hapusProgram(id) {
    _hapusProgramId = id;
    $('#modal_hapus_program').modal('show');
}

document.getElementById('btn-hapus-program-confirm').addEventListener('click', function() {
    if (_hapusProgramId) {
        window.location.href = '<?= base_url('program/hapus_program/') ?>' + _hapusProgramId;
    }
});

document.addEventListener('DOMContentLoaded', function() {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#datatable-program')) {
        $('#datatable-program').DataTable({
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

