<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Detail Peserta</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="header-title">Planned Technopreneurship Coaching</h4>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                        <a href="javascript:void(0);" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <span class="badge bg-light text-dark p-1 px-2 border">Tahun Program : <b>2022</b></span>
                                <span class="badge bg-light text-dark p-1 px-2 border ms-1">Periode Kegiatan : <b>01-10-2024 s/d 01-10-2024</b></span>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0" id="tabel_peserta_detail">
                                    <thead class="table-light">
                                        <tr>
                                            <th colspan="8" class="bg-light">
                                                <i class="mdi mdi-account-group me-1"></i> PESERTA
                                            </th>
                                            <th colspan="2" class="bg-light text-end">
                                                <button class="btn btn-primary btn-sm me-1"><i class="mdi mdi-plus"></i></button>
                                                <button class="btn btn-success btn-sm"><i class="mdi mdi-file-excel"></i> Tambah via Excel</button>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Nama Lengkap</th>
                                            <th>NIM</th>
                                            <th>Program Studi</th>
                                            <th>Fakultas</th>
                                            <th>Nama Perguruan Tinggi</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $peserta_dummy = [
                                            ['nama' => 'Murphy Halim', 'nim' => '13317003', 'prodi' => 'Teknik Fisika', 'fakultas' => 'Fakultas Teknologi Industri', 'univ' => 'Institut Teknologi Bandung', 'jk' => 'Laki-Laki', 'email' => 'halimmurphy@gmail.com', 'status' => 'Alumni'],
                                            ['nama' => 'Hadwika Avila Diva Putri Kuncoro', 'nim' => '19218013', 'prodi' => 'Kewirausahaan', 'fakultas' => 'Sekolah Bisnis dan Manajemen', 'univ' => 'Institut Teknologi Bandung', 'jk' => 'Perempuan', 'email' => 'hadwikaavila@gmail.com', 'status' => 'Alumni'],
                                            ['nama' => 'Fatimah Az-Zahra', 'nim' => '19218047', 'prodi' => 'Kewirausahaan', 'fakultas' => 'Sekolah Bisnis dan Manajemen', 'univ' => 'Institut Teknologi Bandung', 'jk' => 'Perempuan', 'email' => 'fatimahzh@gmail.com', 'status' => 'Alumni'],
                                            ['nama' => 'Reytha Amalia Wahyu', 'nim' => '19218014', 'prodi' => 'Kewirausahaan', 'fakultas' => 'Sekolah Bisnis dan Manajemen', 'univ' => 'Institut Teknologi Bandung', 'jk' => 'Perempuan', 'email' => 'reythamalia@yahoo.com', 'status' => 'Mahasiswa'],
                                            ['nama' => 'Cecilia Susanti Sri Rejeki', 'nim' => '19218035', 'prodi' => 'Kewirausahaan', 'fakultas' => 'Sekolah Bisnis dan Manajemen', 'univ' => 'Institut Teknologi Bandung', 'jk' => 'Perempuan', 'email' => 'cecilrejeki@gmail.com', 'status' => 'Alumni'],
                                            ['nama' => 'Bara Yohantono', 'nim' => '29318424', 'prodi' => 'Administrasi Bisnis (Kampus Jakarta)', 'fakultas' => 'Sekolah Bisnis dan Manajemen', 'univ' => 'Institut Teknologi Bandung', 'jk' => 'Laki-Laki', 'email' => 'barayohantono@gmail.com', 'status' => 'Alumni'],
                                            ['nama' => 'Mohammad Farhan Nurrahman', 'nim' => '12918033', 'prodi' => 'Oseanografi', 'fakultas' => 'Fakultas Ilmu dan Teknologi Kebumian', 'univ' => 'Institut Teknologi Bandung', 'jk' => 'Laki-Laki', 'email' => 'mfarhannan@gmail.com', 'status' => 'Mahasiswa'],
                                        ];
                                        foreach ($peserta_dummy as $idx => $p) :
                                        ?>
                                        <tr>
                                            <td><?= $idx + 1 ?>.</td>
                                            <td><?= $p['nama'] ?></td>
                                            <td><?= $p['nim'] ?></td>
                                            <td><?= $p['prodi'] ?></td>
                                            <td><?= $p['fakultas'] ?></td>
                                            <td><?= $p['univ'] ?></td>
                                            <td><?= $p['jk'] ?></td>
                                            <td><?= $p['email'] ?></td>
                                            <td><?= $p['status'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-sm"><i class="mdi mdi-trash-can-outline"></i></button>
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
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#tabel_peserta_detail')) {
        $('#tabel_peserta_detail').DataTable({
            pageLength: 10,
            ordering: true,
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
