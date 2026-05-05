<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">

            <div class="card border">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold"><i class="mdi mdi-briefcase-outline me-2 text-primary"></i>Program Kewirausahaan &amp; Inkubasi Bisnis</h5>
                        <a href="<?= base_url('inkubasi_bisnis/tambah_program') ?>" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Tambah Program
                        </a>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <div class="d-flex align-items-center gap-2">
                            <label class="fw-semibold text-muted mb-0 text-nowrap" style="font-size:13px;">Cari : </label>
                            <input type="text" id="cari_program" class="form-control form-control-sm"  style="width:260px;">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tabel_inkubasi" class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width:45px;">No</th>
                                    <th>Nama Program</th>
                                    <th class="text-center">Tahun</th>
                                    <th>Jenis Program</th>
                                    <th>Periode Pendaftaran</th>
                                    <th>Periode Kegiatan</th>
                                    <th>Penyelenggara</th>
                                    <th class="text-center">Jumlah Peserta</th>
                                    <th class="text-center">Total Anggaran</th>
                                    <th class="text-center">Status Kegiatan</th>
                                    <th class="text-center" style="width:130px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dummy = [
                                    [
                                        'nama'        => 'Inkubasi Startup Digital Batch 1',
                                        'tahun'       => '2025',
                                        'jenis'       => 'Inkubasi',
                                        'daftar'      => '01 Jan – 28 Feb 2025',
                                        'kegiatan'    => 'Mar – Jun 2025',
                                        'penyelenggara' => 'DKST Kota',
                                        'peserta'     => 20,
                                        'anggaran'    => 'Rp 50.000.000',
                                        'status'      => 'Selesai',
                                    ],
                                    [
                                        'nama'        => 'Program Kewirausahaan Muda 2025',
                                        'tahun'       => '2025',
                                        'jenis'       => 'Kewirausahaan',
                                        'daftar'      => '01 Mar – 30 Apr 2025',
                                        'kegiatan'    => 'Mei – Agu 2025',
                                        'penyelenggara' => 'Dinas Koperasi',
                                        'peserta'     => 35,
                                        'anggaran'    => 'Rp 75.000.000',
                                        'status'      => 'Berjalan',
                                    ],
                                    [
                                        'nama'        => 'Akselerasi Bisnis UMKM',
                                        'tahun'       => '2026',
                                        'jenis'       => 'Akselerasi',
                                        'daftar'      => '01 Jan – 15 Feb 2026',
                                        'kegiatan'    => 'Mar – Mei 2026',
                                        'penyelenggara' => 'DKST Kota',
                                        'peserta'     => 15,
                                        'anggaran'    => 'Rp 30.000.000',
                                        'status'      => 'Pendaftaran',
                                    ],
                                ];
                                $status_badge = ['Selesai' => 'bg-success', 'Berjalan' => 'bg-primary', 'Pendaftaran' => 'bg-warning text-dark'];
                                foreach ($dummy as $i => $row):
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td class="text-center"><?= $row['tahun'] ?></td>
                                    <td><?= $row['jenis'] ?></td>
                                    <td class="small text-muted"><?= $row['daftar'] ?></td>
                                    <td class="small text-muted"><?= $row['kegiatan'] ?></td>
                                    <td><?= $row['penyelenggara'] ?></td>
                                    <td class="text-center"><?= $row['peserta'] ?></td>
                                    <td class="text-center"><?= $row['anggaran'] ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $status_badge[$row['status']] ?>"><?= $row['status'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info text-white" title="Detail"><i class="mdi mdi-eye"></i></button>
                                        <a href="<?= base_url('inkubasi_bisnis/edit_program/' . ($i + 1)) ?>" class="btn btn-sm btn-warning text-white" title="Ubah"><i class="mdi mdi-pencil"></i></a>
                                        <button class="btn btn-sm btn-danger" title="Hapus"><i class="mdi mdi-delete"></i></button>
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
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var table = $('#tabel_inkubasi').DataTable({
        pageLength: 10,
        ordering: false,
        destroy: true,
        autoWidth: false,
        dom: '<"d-flex align-items-center justify-content-between px-3 py-2"l>rt<"d-flex align-items-center justify-content-between px-3 py-2"ip>',
        language: {
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: { previous: 'Previous', next: 'Next' }
        }
    });

    $('#cari_program').on('input', function() {
        table.search(this.value).draw();
    });
});
</script>
