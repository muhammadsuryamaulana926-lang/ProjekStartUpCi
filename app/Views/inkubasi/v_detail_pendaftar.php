<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Detail Pendaftar</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="header-title">Percobaan 2</h4>
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
                                <span class="badge bg-light text-dark p-1 px-2 border">Tahun Program : <b>2024</b></span>
                                <span class="badge bg-light text-dark p-1 px-2 border ms-1">Periode Pendaftaran : <b>01-01-2024 s/d 30-01-2024</b></span>
                                <span class="badge bg-light text-dark p-1 px-2 border ms-1">Periode Kegiatan : <b>01-01-2024 s/d 30-01-2024</b></span>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0" id="tabel_pendaftar">
                                    <thead class="table-light">
                                        <tr>
                                            <th colspan="9" class="bg-light">
                                                <i class="mdi mdi-account-group me-1"></i> PENDAFTAR
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Tanggal Berdiri</th>
                                            <th>Email</th>
                                            <th>Website</th>
                                            <th>Nominal Pengajuan</th>
                                            <th>Badan Hukum</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>
                                                <div>DKStartup</div>
                                                <a href="<?= base_url('inkubasi_bisnis/detail_startup/1') ?>" class="btn btn-primary btn-xs mt-1">
                                                    <i class="mdi mdi-eye"></i> Lihat Data Proposal
                                                </a>
                                            </td>
                                            <td>2024-02-11</td>
                                            <td>startup@dkst.co.id</td>
                                            <td>dkstartup.co.id</td>
                                            <td>5.000.000</td>
                                            <td>Sampel Badan Hukum</td>
                                            <td>11-02-2024 10:10:05</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">Diterima</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>
                                                <div>DKST PRO</div>
                                                <a href="<?= base_url('inkubasi_bisnis/detail_startup/1') ?>" class="btn btn-primary btn-xs mt-1">
                                                    <i class="mdi mdi-eye"></i> Lihat Data Proposal
                                                </a>
                                            </td>
                                            <td>2024-03-21</td>
                                            <td>dkstpro@gmail.com</td>
                                            <td>-</td>
                                            <td>2.000.000</td>
                                            <td>PT DKST</td>
                                            <td>21-03-2024 09:10:34</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">Diterima</span>
                                            </td>
                                        </tr>
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

<style>
.btn-xs {
    padding: 1px 5px;
    font-size: 11px;
    line-height: 1.5;
    border-radius: 3px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#tabel_pendaftar')) {
        $('#tabel_pendaftar').DataTable({
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
