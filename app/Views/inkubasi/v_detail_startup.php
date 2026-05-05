<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Detail Startup</h4>
                    </div>
                </div>
            </div>

            <!-- Header Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="mt-0">DKStartup</h3>
                                    <p class="text-muted mb-2">
                                        <i class="mdi mdi-email-outline me-1"></i> startup@dkst.co.id 
                                        <i class="mdi mdi-web ms-2 me-1"></i> dkstartup.co.id
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-soft-info text-info border border-info">Klaster: Teknologi Informasi dan Komunikasi</span>
                                        <span class="badge bg-soft-success text-success border border-success">Status: Proposal Startup Diterima</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-info p-2 rounded text-white mb-0" style="background-color: #4fc3f7 !important;">
                                <div class="small opacity-75">Usulan Pendanaan</div>
                                <h4 class="text-white mt-0 mb-0">Rp. 5.000.000,00</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-bordered mb-3">
                                <li class="nav-item">
                                    <a href="#profil-tab" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Profil</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#rab-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="mdi mdi-cash-multiple d-md-none d-block"></i>
                                        <span class="d-none d-md-block">RAB</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#monev-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="mdi mdi-monitor-eye d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Monitoring & Evaluasi</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#keuangan-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="mdi mdi-file-document-outline d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Pelaporan Keuangan</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#aktivitas-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="mdi mdi-history d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Aktivitas</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- TAB PROFIL -->
                                <div class="tab-pane show active" id="profil-tab">
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building me-1"></i> Informasi Profil</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="text-muted mb-1 font-13">Nama Startup</p>
                                            <p class="mb-3 font-14">DKStartup</p>
                                            <p class="text-muted mb-1 font-13">Tanggal Berdiri</p>
                                            <p class="mb-3 font-14">2024-02-11</p>
                                            <p class="text-muted mb-1 font-13">Email Startup</p>
                                            <p class="mb-3 font-14">startup@dkst.co.id</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-muted mb-1 font-13">Klaster</p>
                                            <p class="mb-3 font-14">Teknologi Informasi dan Komunikasi</p>
                                            <p class="text-muted mb-1 font-13">Website</p>
                                            <p class="mb-3 font-14">dkstartup.co.id</p>
                                            <p class="text-muted mb-1 font-13">Badan Hukum</p>
                                            <p class="mb-3 font-14">Sampel Badan Hukum</p>
                                        </div>
                                        <div class="col-12">
                                            <p class="text-muted mb-1 font-13">Logo</p>
                                            <img src="<?= base_url('assets/images/logo-dark.png') ?>" alt="logo" height="40" class="mb-3 border p-1">
                                        </div>
                                    </div>

                                    <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-group me-1"></i> Informasi Tim</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-centered mb-0 font-13">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Alamat</th>
                                                    <th>NIM/NIK</th>
                                                    <th>No Telp</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Dian</td>
                                                    <td>CEO</td>
                                                    <td>Dsn. Terusan Dawuan Barat RT. 02</td>
                                                    <td>1234567890</td>
                                                    <td>08123456789</td>
                                                    <td>dian@dkst.co.id</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Arfan</td>
                                                    <td>CTO</td>
                                                    <td>Dsn. Terusan Dawuan Barat RT. 03</td>
                                                    <td>0987654321</td>
                                                    <td>08987654321</td>
                                                    <td>arfan@dkst.co.id</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- TAB RAB -->
                                <div class="tab-pane" id="rab-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-2 bg-light p-2">
                                        <h5 class="m-0 text-uppercase"><i class="mdi mdi-cash-register me-1"></i> Informasi RAB</h5>
                                        <button class="btn btn-primary btn-xs"><i class="mdi mdi-pencil"></i></button>
                                    </div>
                                    <div class="row font-13">
                                        <div class="col-md-6">
                                            <div class="row mb-1">
                                                <div class="col-6 text-muted">Nilai Kontrak</div>
                                                <div class="col-6">-</div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-6 text-muted">Nilai Tahun yang Disepakati</div>
                                                <div class="col-6">-</div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-6 text-muted">Tanggal Nilai Tukar</div>
                                                <div class="col-6">11-02-2024</div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-6 text-muted">Persentase Termin (%)</div>
                                                <div class="col-6">-</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="mb-3 mt-4 text-uppercase bg-light p-2 font-13"><i class="mdi mdi-file-clock me-1"></i> INFORMASI TERMIN PEMBAYARAN</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-centered mb-0 font-12">
                                            <thead class="table-light">
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th rowspan="2">Persentase</th>
                                                    <th rowspan="2">Nominal</th>
                                                    <th rowspan="2">Periode</th>
                                                    <th colspan="7" class="text-center">Belanja</th>
                                                    <th rowspan="2">Status</th>
                                                    <th rowspan="2">Aksi</th>
                                                </tr>
                                                <tr>
                                                    <th>Pegawai</th>
                                                    <th>Barang Modal</th>
                                                    <th>Barang Non Modal</th>
                                                    <th>Jasa Modal</th>
                                                    <th>Jasa Lainnya</th>
                                                    <th>Jasa Modal</th>
                                                    <th>Lampiran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="13" class="text-center text-muted py-3">Belum ada data</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- TAB MONEV -->
                                <div class="tab-pane" id="monev-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-2 bg-light p-2">
                                        <h5 class="m-0 text-uppercase"><i class="mdi mdi-account-star me-1"></i> DAFTAR MENTOR STARTUP</h5>
                                        <button class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i></button>
                                    </div>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered table-sm table-centered mb-0 font-13">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px;">No</th>
                                                    <th>Nama Mentor</th>
                                                    <th style="width: 100px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>JOKO</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger btn-xs"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h5 class="mb-2 text-uppercase bg-light p-2"><i class="mdi mdi-bullseye-arrow me-1"></i> TARGET LUARAN</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-centered mb-0 font-12">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Deskripsi/Spesifikasi Luaran</th>
                                                    <th>Target Capaian</th>
                                                    <th>Bukti Luaran</th>
                                                    <th>Progress (%)</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-3">Belum ada data</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- TAB KEUANGAN -->
                                <div class="tab-pane" id="keuangan-tab">
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-file-document-edit me-1"></i> PELAPORAN KEUANGAN</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-centered mb-0 font-12">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Belanja</th>
                                                    <th>Kategori</th>
                                                    <th>Uraian</th>
                                                    <th>Satuan</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Jumlah</th>
                                                    <th>Total</th>
                                                    <th>Jenis PPN</th>
                                                    <th>Nilai PPN</th>
                                                    <th>Jenis PPh</th>
                                                    <th>Nilai PPh</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="15" class="text-center text-muted py-3">Belum ada data</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- TAB AKTIVITAS -->
                                <div class="tab-pane" id="aktivitas-tab">
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-history me-1"></i> AKTIVITAS</h5>
                                    <div class="timeline" style="margin-left: 20px;">
                                        <div class="timeline-item pb-3 border-start position-relative ps-4">
                                            <span class="position-absolute start-0 translate-middle-x bg-info rounded-circle" style="width: 12px; height: 12px; left: 0;"></span>
                                            <div class="font-12 text-muted">11-02-2024 09:22:04</div>
                                            <div class="fw-bold">Proposal Startup Diterima</div>
                                            <div class="text-muted font-11">Admin SIMIK</div>
                                            <div class="font-11">Catatan : ya</div>
                                        </div>
                                        <div class="timeline-item pb-3 border-start position-relative ps-4">
                                            <span class="position-absolute start-0 translate-middle-x bg-primary rounded-circle" style="width: 12px; height: 12px; left: 0;"></span>
                                            <div class="font-12 text-muted">11-02-2024 09:17:09</div>
                                            <div class="fw-bold">Pemeriksaan</div>
                                            <div class="text-muted font-11">Admin SIMIK</div>
                                        </div>
                                        <div class="timeline-item pb-3 border-start position-relative ps-4">
                                            <span class="position-absolute start-0 translate-middle-x bg-secondary rounded-circle" style="width: 12px; height: 12px; left: 0;"></span>
                                            <div class="font-12 text-muted">11-02-2024 09:10:05</div>
                                            <div class="fw-bold">Proposal Startup Diajukan</div>
                                        </div>
                                        <div class="timeline-item position-relative ps-4">
                                            <span class="position-absolute start-0 translate-middle-x bg-light border rounded-circle" style="width: 12px; height: 12px; left: 0;"></span>
                                            <div class="font-12 text-muted">11-02-2024 08:58:43</div>
                                            <div class="fw-bold">Draft</div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- tab-content -->
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->

<style>
.font-11 { font-size: 11px; }
.font-12 { font-size: 12px; }
.font-13 { font-size: 13px; }
.font-14 { font-size: 14px; }
.btn-xs { padding: 1px 5px; font-size: 11px; }
.bg-soft-info { background-color: rgba(79, 195, 247, 0.1); }
.bg-soft-success { background-color: rgba(28, 187, 140, 0.1); }
.nav-bordered .nav-link.active { border-bottom: 2px solid #3283f6; color: #3283f6; }
.timeline-item:last-child { border-left: none !important; }
</style>
