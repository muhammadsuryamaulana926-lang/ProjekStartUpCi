<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Peserta Kelas</h4>
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

            <!-- Info Kelas -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div>
                                    <h4 class="header-title mb-1"><?= esc($kelas['nama_kelas']) ?></h4>
                                    <p class="text-muted small mb-0">
                                        <i class="mdi mdi-book-open-variant me-1"></i><?= esc($program['nama_program']) ?>
                                        &bull; <i class="mdi mdi-calendar me-1"></i><?= date('d M Y', strtotime($kelas['tanggal'])) ?>
                                        &bull; <i class="mdi mdi-clock me-1"></i><?= date('H:i', strtotime($kelas['jam_mulai'])) ?> - <?= date('H:i', strtotime($kelas['jam_selesai'])) ?>
                                    </p>
                                </div>
                                <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-sm btn-secondary waves-effect waves-light">
                                    <i class="mdi mdi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Peserta -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">
                                Peserta yang Hadir
                                <span class="badge bg-secondary ms-1"><?= count($peserta_kelas) ?></span>
                            </h4>
                            <div id="tabel">
                                <div class="table-responsive">
                                    <table id="datatable-peserta" class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th class="text-center" style="min-width:40px;">No</th>
                                                <th style="min-width:150px;">Nama Peserta</th>
                                                <th class="text-center" style="min-width:100px;">Kondisi</th>
                                                <th style="min-width:150px;">Waktu Presensi</th>
                                                <th class="text-center" style="min-width:70px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($peserta_kelas)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada peserta yang hadir.</td>
                                            </tr>
                                            <?php else: ?>
                                                <?php $no = 1; foreach ($peserta_kelas as $p): ?>
                                                <tr>
                                                    <td style="text-align:center;"><?= $no++ ?>.</td>
                                                    <td><b><?= esc($p['nama_peserta']) ?></b></td>
                                                    <td style="text-align:center;">
                                                        <?php if (!empty($p['kondisi_hadir'])): ?>
                                                            <span class="badge bg-success"><?= esc($p['kondisi_hadir']) ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= !empty($p['waktu_presensi']) ? date('d M Y, H:i', strtotime($p['waktu_presensi'])) : '-' ?></td>
                                                    <td style="text-align:center;">
                                                        <a href="javascript:void(0)" onclick="konfirmasiHapusPeserta('<?= $p['id_peserta_kelas'] ?>', '<?= $kelas['id_kelas'] ?>')" class="btn btn-sm btn-danger waves-effect waves-light">
                                                            <i class="mdi mdi-trash-can-outline"></i>
                                                        </a>
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
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->

<!-- Modal Hapus -->
<div class="modal fade" id="modal_hapus_peserta" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Apakah Anda yakin data peserta ini akan dihapus?</div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn-hapus-peserta-confirm"><i class="mdi mdi-check"></i> Ya</button>
                <button class="btn btn-danger" data-bs-dismiss="modal"><i class="mdi mdi-close"></i> Batal</button>
            </div>
        </div>
    </div>
</div>

<form id="form-hapus-peserta" action="<?= base_url('peserta_kelas/hapus_peserta') ?>" method="POST" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="id_peserta_kelas" id="hapus-id-peserta-kelas">
    <input type="hidden" name="id_kelas" id="hapus-id-kelas">
</form>

<script>
var _hapusIdPesertaKelas = null;
var _hapusIdKelas = null;

function konfirmasiHapusPeserta(id_peserta_kelas, id_kelas) {
    _hapusIdPesertaKelas = id_peserta_kelas;
    _hapusIdKelas = id_kelas;
    $('#modal_hapus_peserta').modal('show');
}

document.getElementById('btn-hapus-peserta-confirm').addEventListener('click', function() {
    if (_hapusIdPesertaKelas) {
        document.getElementById('hapus-id-peserta-kelas').value = _hapusIdPesertaKelas;
        document.getElementById('hapus-id-kelas').value = _hapusIdKelas;
        document.getElementById('form-hapus-peserta').submit();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#datatable-peserta')) {
        $('#datatable-peserta').DataTable({
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
