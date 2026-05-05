<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Izin Akses</h4>
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h4 class="header-title mb-0">Izin Akses per Role</h4>
                                <a href="<?= base_url('manajemen_user') ?>" class="btn btn-sm btn-secondary waves-effect waves-light">
                                    <i class="mdi mdi-account-group"></i> Manajemen User
                                </a>
                            </div>

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <label class="mb-0 small fw-semibold text-nowrap">Per Role:</label>
                                <select id="selectRole" class="form-select form-select-sm" style="min-width:180px;"
                                    onchange="window.location.href='<?= base_url('izin_akses') ?>?role='+this.value">
                                    <?php foreach ($daftar_role as $role_key => $role_label): ?>
                                    <option value="<?= $role_key ?>" <?= $role_aktif === $role_key ? 'selected' : '' ?>>
                                        <?= $role_label ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <form action="<?= base_url('izin_akses/simpan_izin') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="role" value="<?= esc($role_aktif) ?>">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th class="text-center" style="min-width:40px;">No</th>
                                                <th style="min-width:200px;">Akses Halaman</th>
                                                <th class="text-center" style="min-width:80px;"><i class="mdi mdi-eye text-info"></i> Lihat</th>
                                                <th class="text-center" style="min-width:80px;"><i class="mdi mdi-plus-circle text-success"></i> Tambah</th>
                                                <th class="text-center" style="min-width:80px;"><i class="mdi mdi-pencil text-warning"></i> Edit</th>
                                                <th class="text-center" style="min-width:80px;"><i class="mdi mdi-delete text-danger"></i> Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach ($daftar_modul as $modul_key => $modul_label): ?>
                                                <?php $izin = $izin_per_modul[$modul_key] ?? []; ?>
                                                <tr>
                                                    <td style="text-align:center;"><?= $no++ ?>.</td>
                                                    <td><b><?= $modul_label ?></b></td>
                                                    <td style="text-align:center;">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="izin[<?= $modul_key ?>][bisa_lihat]" value="1"
                                                            <?= !empty($izin['bisa_lihat']) ? 'checked' : '' ?>>
                                                    </td>
                                                    <td style="text-align:center;">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="izin[<?= $modul_key ?>][bisa_tambah]" value="1"
                                                            <?= !empty($izin['bisa_tambah']) ? 'checked' : '' ?>>
                                                    </td>
                                                    <td style="text-align:center;">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="izin[<?= $modul_key ?>][bisa_edit]" value="1"
                                                            <?= !empty($izin['bisa_edit']) ? 'checked' : '' ?>>
                                                    </td>
                                                    <td style="text-align:center;">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="izin[<?= $modul_key ?>][bisa_hapus]" value="1"
                                                            <?= !empty($izin['bisa_hapus']) ? 'checked' : '' ?>>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-md-end mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save"></i> Simpan Izin Akses
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->
