<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Inkubasi Bisnis</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Program Kewirausahaan &amp; Inkubasi Bisnis</h4>
                            <div class="text-md-end mt-2 mt-md-0 mb-2">
                                <a href="<?= base_url('inkubasi_bisnis/tambah_program') ?>" class="btn btn-md btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-plus"></i> Tambah Program
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="tabel_inkubasi" class="table table-bordered">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th class="text-center" style="min-width:40px;">No</th>
                                            <th style="min-width:180px;">Nama Program</th>
                                            <th class="text-center" style="min-width:60px;">Tahun</th>
                                            <th style="min-width:100px;">Jenis Program</th>
                                            <th style="min-width:140px;">Periode Pendaftaran</th>
                                            <th style="min-width:120px;">Periode Kegiatan</th>
                                            <th style="min-width:120px;">Penyelenggara</th>
                                            <th class="text-center" style="min-width:80px;">Peserta</th>
                                            <th class="text-center" style="min-width:120px;">Total Anggaran</th>
                                            <th class="text-center" style="min-width:90px;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dummy = [
                                            ['nama' => 'Inkubasi Startup Digital Batch 1', 'tahun' => '2025', 'jenis' => 'Inkubasi', 'daftar' => '01 Jan – 28 Feb 2025', 'kegiatan' => 'Mar – Jun 2025', 'penyelenggara' => 'DKST Kota', 'peserta' => 20, 'anggaran' => 'Rp 50.000.000', 'status' => 'Selesai'],
                                            ['nama' => 'Program Kewirausahaan Muda 2025', 'tahun' => '2025', 'jenis' => 'Kewirausahaan', 'daftar' => '01 Mar – 30 Apr 2025', 'kegiatan' => 'Mei – Agu 2025', 'penyelenggara' => 'Dinas Koperasi', 'peserta' => 35, 'anggaran' => 'Rp 75.000.000', 'status' => 'Berjalan'],
                                            ['nama' => 'Akselerasi Bisnis UMKM', 'tahun' => '2026', 'jenis' => 'Akselerasi', 'daftar' => '01 Jan – 15 Feb 2026', 'kegiatan' => 'Mar – Mei 2026', 'penyelenggara' => 'DKST Kota', 'peserta' => 15, 'anggaran' => 'Rp 30.000.000', 'status' => 'Pendaftaran'],
                                        ];
                                        $status_badge = ['Selesai' => 'bg-success', 'Berjalan' => 'bg-primary', 'Pendaftaran' => 'bg-warning text-dark'];
                                        foreach ($dummy as $i => $row):
                                        ?>
                                        <tr>
                                            <td style="text-align:center;"><?= $i + 1 ?>.</td>
                                            <td>
                                                <b><?= $row['nama'] ?></b>
                                                <br>
                                                <div class="d-flex gap-1 mt-1">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Pilih <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?= base_url('inkubasi_bisnis/edit_program/' . ($i + 1)) ?>"><i class="mdi mdi-pencil"></i> Ubah</a>
                                                        <a class="dropdown-item" href="#"><i class="mdi mdi-trash-can-outline"></i> Hapus</a>
                                                    </div>
                                                </div>
                                                <?php if ($row['jenis'] === 'Inkubasi'): ?>
                                                    <a href="<?= base_url('inkubasi_bisnis/detail_pendaftar/1') ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-eye"></i> Detail Pendaftar</a>
                                                <?php elseif ($row['jenis'] === 'Kewirausahaan'): ?>
                                                    <a href="<?= base_url('inkubasi_bisnis/detail_peserta/1') ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-eye"></i> Detail Peserta</a>
                                                <?php endif; ?>
                                                </div>
                                            </td>
                                            <td style="text-align:center;"><?= $row['tahun'] ?></td>
                                            <td><?= $row['jenis'] ?></td>
                                            <td><?= $row['daftar'] ?></td>
                                            <td><?= $row['kegiatan'] ?></td>
                                            <td><?= $row['penyelenggara'] ?></td>
                                            <td style="text-align:center;"><?= $row['peserta'] ?></td>
                                            <td style="text-align:center;"><?= $row['anggaran'] ?></td>
                                            <td style="text-align:center;">
                                                <span class="badge <?= $status_badge[$row['status']] ?>"><?= $row['status'] ?></span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#tabel_inkubasi')) {
        $('#tabel_inkubasi').DataTable({
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
