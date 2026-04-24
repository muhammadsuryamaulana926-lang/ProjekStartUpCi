<style>
/* HVS Paper Style Form & Card */
body {
    background-color: #f5f5f5 !important;
}
.paper-card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 30px;
}
.paper-container {
    max-width: 900px;
    margin: 40px auto;
}
.table-paper th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}
.btn-modern {
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5; min-h-screen">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-10">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (in_array(session()->get('user_role'), ['admin', 'superadmin'])): ?>
                <!-- TAMPILAN ADMIN (TABEL) -->
                <div class="paper-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="m-0 font-weight-bold text-dark">Daftar Program</h4>
                        <a href="<?= base_url('program/tambah_program') ?>" class="btn btn-primary btn-modern">
                            <i class="mdi mdi-plus"></i> Tambah Program
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-paper align-middle">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Nama Program</th>
                                    <th width="15%" class="text-center">Total Kelas</th>
                                    <th width="15%" class="text-center">Total Peserta</th>
                                    <th width="20%">Status</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($program)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data program</td>
                                </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach($program as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= esc($p['nama_program']) ?></strong>
                                            <div class="small text-muted" style="max-width:250px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= esc($p['deskripsi']) ?></div>
                                        </td>
                                        <td class="text-center"><?= $p['jumlah_kelas'] ?> Kelas</td>
                                        <td class="text-center"><?= $p['jumlah_peserta'] ?> Orang</td>
                                        <td>
                                            <?php if($p['sudah_join']): ?>
                                                <span class="badge bg-success px-3 py-2">Tergabung</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary px-3 py-2">Belum Join</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= base_url('program/detail_program/' . $p['id_program']) ?>" class="btn btn-sm btn-info text-white me-1 rounded" title="Lihat Detail">
                                                    <i class="mdi mdi-eye"></i> Detail
                                                </a>
                                                <a href="<?= base_url('program/edit_program/' . $p['id_program']) ?>" class="btn btn-sm btn-warning text-white me-1 rounded" title="Edit Program">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('program/hapus_program/' . $p['id_program']) ?>" class="btn btn-sm btn-danger rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')" title="Hapus Program">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <!-- TAMPILAN USER BIASA (KARTU PROGRAM) -->
                <div class="mb-4">
                    <h2 class="font-weight-bold text-dark m-0" style="font-size:28px;">Program Akselerasi & Kelas</h2>
                    <p class="text-muted mt-2">Temukan dan ikuti program unggulan untuk mengembangkan startup Anda.</p>
                </div>

                <?php if(empty($program)): ?>
                    <div class="text-center py-5">
                        <i class="mdi mdi-clipboard-text-outline" style="font-size: 64px; color: #cbd5e1;"></i>
                        <h4 class="mt-3 text-dark font-weight-bold">Belum Ada Program</h4>
                        <p class="text-muted">Saat ini belum ada program yang bisa diikuti.</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach($program as $p): ?>
                        <div class="col-md-6 mb-4">
                            <div class="paper-card h-100 d-flex flex-column" style="padding: 25px; transition: transform 0.2s, box-shadow 0.2s;">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h4 class="font-weight-bold text-dark m-0" style="line-height: 1.3; max-width: 75%;"><?= esc($p['nama_program']) ?></h4>
                                    <?php if($p['sudah_join']): ?>
                                        <span class="badge bg-success px-3 py-2" style="font-size:12px;">Tergabung</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-secondary border px-3 py-2" style="font-size:12px;">Tersedia</span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-muted" style="font-size:14px; line-height:1.6; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= esc($p['deskripsi']) ?>
                                </p>
                                
                                <div class="d-flex align-items-center gap-4 mb-4 mt-2">
                                    <div class="d-flex align-items-center text-muted" style="font-size:13px;">
                                        <i class="mdi mdi-book-open-page-variant me-1 text-primary" style="font-size:18px;"></i> <?= $p['jumlah_kelas'] ?>  Kelas
                                    </div>
                                    <div class="d-flex align-items-center text-muted" style="font-size:13px;">
                                        <i class="mdi mdi-account-group me-1 text-info" style="font-size:18px;"></i> <?= $p['jumlah_peserta'] ?> Peserta
                                    </div>
                                </div>

                                <a href="<?= base_url('program/detail_program/' . $p['id_program']) ?>" class="btn w-100 btn-modern <?= $p['sudah_join'] ? 'btn-primary' : 'btn-outline-primary' ?>">
                                    <?= $p['sudah_join'] ? 'Akses Kelas Sekarang' : 'Lihat & Gabung Program' ?>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <style>
                    .paper-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
                    }
                </style>
            <?php endif; ?>

        </div>
    </div>
</div>
