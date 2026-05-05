<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<style>
    .select2-container--open {
        z-index: 9999999; 
    }
</style>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Startup</h4>
                    </div>
                </div>
            </div>

            <?php if (session()->getFlashdata('msg') !== NULL) { ?>
                <div class="alert <?php if (session()->getFlashdata('msg')[0] == "success") {
                    echo "alert-success";
                } else {
                    echo "alert-danger";
                } ?> alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?php echo session()->getFlashdata('msg')[1]; ?>
                </div>
            <?php } ?> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Daftar Startup</h4>
                            <?php if (!empty($status_tambah) && $status_tambah == 1) { ?>
                                <div class="text-md-end mt-2 mt-md-0 mb-2">
                                    <a href="<?php echo base_url('v_tambah_startup'); ?>"
                                        class="btn btn-md btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-plus"></i> Tambah
                                    </a>
                                </div>
                            <?php } ?>
                            <div id="tabel">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered">
                                        <thead> 
                                            <tr>
                                                <th class="text-center" style="min-width: 10px;">No</th>
                                                <th class="text-center" style="min-width: 150px;">Startup</th>
                                                <th class="text-center" style="min-width: 150px;">Klaster</th>
                                                <th class="text-center" style="min-width: 125px;">Email</th>
                                                <th class="text-center" style="min-width: 120px;">Nomor WhatsApp</th>
                                                <th class="text-center" style="min-width: 70px;">Tahun Daftar</th>
                                                <th class="text-center" style="min-width: 70px;">Status Startup</th>
                                                <th class="text-center" style="min-width: 70px;">Status Ajuan</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <?php $no = 1;
                                                if (!empty($startups)) { foreach ($startups as $row) { ?>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <?php echo $no; ?>.
                                                    </td>
                                                    <td>
                                                        <b> <?php echo esc($row->nama_perusahaan); ?> </b> <br>
                                                        <?php if ((!empty($status_ubah) && $status_ubah == 1) || (!empty($status_hapus) && $status_hapus == 1)) { ?>
                                                            <?php if (isset($row->status_ajuan) && $row->status_ajuan == "draf") { ?>
                                                                <div class="btn-group">
                                                                    <button type="button" 
                                                                        class="btn btn-primary btn-sm dropdown-toggle align-items-center"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">Pilih <i
                                                                            class="mdi mdi-chevron-down"></i></button>
                                                                    <div class="dropdown-menu">
                                                                        <a type="submit" class="dropdown-item"
                                                                                onclick="konfirmasi_pengajuan(<?php echo $row->id_startup; ?>, <?php echo $_SESSION['id_pengguna'] ?? 0; ?>)"><i
                                                                                    class="mdi mdi-file-document"></i> Ajukan Permohonan</a>
                                                                        <a class="dropdown-item" href="<?php echo base_url('v_detail/' . ($row->uuid_startup ?? $row->kode_url ?? '')); ?>"><i
                                                                                    class="mdi mdi-eye"></i> Detail</a>
                                                                        <?php if (!empty($status_ubah) && $status_ubah == 1) { ?>
                                                                            <a class="dropdown-item" onclick="proses_edit(<?php echo $row->id_startup; ?>)"><i
                                                                                    class="mdi mdi-pencil"></i> Ubah</a>
                                                                        <?php } ?>
                                                                        <?php 
                                                                            if (!empty($status_hapus) && $status_hapus == 1) { 
                                                                        ?>
                                                                            <a type="submit" class="dropdown-item"
                                                                                onclick="konfirmasi_hapus(<?php echo $row->id_startup; ?>)"><i
                                                                                    class="mdi mdi-trash-can-outline"></i> Hapus</a>
                                                                        <?php }?>
                                                                    </div>
                                                                </div>
                                                            <?php }else{ ?>
                                                                <div class="btn-group">
                                                                    <button type="button" 
                                                                        class="btn btn-primary btn-sm dropdown-toggle align-items-center"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">Pilih <i
                                                                            class="mdi mdi-chevron-down"></i></button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="<?php echo base_url('v_detail/' . ($row->uuid_startup ?? $row->kode_url ?? '')); ?>"><i
                                                                                    class="mdi mdi-eye"></i> Detail</a>
                                                                        <?php if (!empty($status_ubah) && $status_ubah == 1) { ?>
                                                                            <a class="dropdown-item" onclick="proses_edit(<?php echo $row->id_startup; ?>)"><i
                                                                                    class="mdi mdi-pencil"></i> Ubah</a>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                        <?php } } ?>                                                        
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $klaster_val = $row->klaster ?? '';
                                                        if (!empty($klaster_val) && str_contains($klaster_val, ',')) {
                                                            $pisah_klaster = explode(',', $klaster_val);
                                                            foreach ($pisah_klaster as $key => $klaster) {
                                                                if ($key === array_key_last($pisah_klaster)) {
                                                                    echo esc(trim($klaster)) . '<br>';
                                                                } else {
                                                                    echo esc(trim($klaster)) . ',<br>';
                                                                }
                                                            }
                                                        } else {
                                                            echo esc($klaster_val ?: '-');
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo esc($row->email_perusahaan ?? ''); ?></td>
                                                    <td><?php echo esc($row->nomor_whatsapp ?? $row->no_whatsapp ?? ''); ?></td>
                                                    <td style="text-align: center;">
                                                        <?php echo esc($row->tahun_daftar ?? ''); ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if (($row->status_startup ?? '') == "aktif") { ?>
                                                            <span class="badge bg-success">Aktif</span>
                                                        <?php } else { ?>
                                                            <span class="badge bg-danger">Tidak Aktif</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if (($row->status_ajuan ?? '') == "draf") { ?>
                                                            <span class="badge bg-dark">Draf</span>
                                                        <?php } else if (($row->status_ajuan ?? '') == "ajuan") { ?>
                                                            <span class="badge bg-info">Ajuan</span>
                                                        <?php } else if (($row->status_ajuan ?? '') == "verifikasi") { ?>
                                                            <span class="badge bg-success">Verifikasi</span>
                                                        <?php } else if (($row->status_ajuan ?? '') == "tolak") { ?>
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php $no++; } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Modal Pengajuan -->
    <div class="modal fade" id="modal_pengajuan" aria-hidden="true" aria-labelledby="modal_konfirmasi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Pengajuan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan mengajukan Startup ini?
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary submit" onclick="proses_pengajuan()"><i class="mdi mdi-check"></i> Ya</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal Hapus -->
    <div class="modal fade" id="modal_konfirmasi" aria-hidden="true" aria-labelledby="modal_konfirmasi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin data ini akan dihapus?
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary submit" onclick="hapus()"><i class="mdi mdi-check"></i> Ya</a>
                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                            class="mdi mdi-close"></i> Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div><!-- content-page -->

<form id="post-edit-form" action="<?= base_url('v_edit_startup') ?>" method="post" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="<?= csrf_token() ?>" id="post-edit-csrf" value="<?= csrf_hash() ?>">
    <input type="hidden" name="id_startup" id="post-id-startup">
</form>

<script>
    var temp_id_startup;
    var temp_id_pengguna;
    var CSRF_NAME = '<?= csrf_token() ?>';
    var CSRF_HASH = '<?= csrf_hash() ?>';

    function konfirmasi_hapus(id_startup) {
        temp_id_startup = id_startup;
        $("#modal_konfirmasi").modal('show');
    }

    function konfirmasi_pengajuan(id_startup, id_pengguna) {
        temp_id_startup = id_startup;
        temp_id_pengguna = id_pengguna;
        $("#modal_pengajuan").modal('show');
    }

    function hapus() {
        $(".submit").prop("disabled", true);
        $(".submit").html('<i class="mdi mdi-spin mdi-loading"></i> Loading...');
        $.ajax({
            url: '<?php echo base_url('v_hapus_startup'); ?>',
            type: 'post',
            data: { id_startup: temp_id_startup, [CSRF_NAME]: CSRF_HASH },
            success: function (msg) {
                var data = typeof msg === 'string' ? jQuery.parseJSON(msg) : msg;
                if (data.status) {
                    $("#modal_konfirmasi").modal('hide');
                    setTimeout(function () {
                        window.location.href = "<?php echo base_url('v_data_startup') ?>";
                    }, 1000);
                } else {
                    $("#modal_konfirmasi").modal('hide');
                    setTimeout(function () {
                        window.location.href = "<?php echo base_url('v_data_startup') ?>";
                    }, 1000);
                }
            }
        }); 
    }

    function proses_pengajuan() {
        $(".submit").prop("disabled", true);
        $(".submit").html('<i class="mdi mdi-spin mdi-loading"></i> Loading...');
        $.ajax({
            url: '<?php echo base_url('startup/proses_pengajuan_startup'); ?>',
            type: 'post',
            data: { id_startup: temp_id_startup, id_pengguna: temp_id_pengguna, [CSRF_NAME]: CSRF_HASH },
            success: function (msg) {
                var data = typeof msg === 'string' ? jQuery.parseJSON(msg) : msg;
                if (data.status) {
                    $("#modal_pengajuan").modal('hide');
                    setTimeout(function () {
                        window.location.href = "<?php echo base_url('v_data_startup') ?>";
                    }, 1000);
                } else {
                    $("#modal_pengajuan").modal('hide');
                    setTimeout(function () {
                        window.location.href = "<?php echo base_url('v_data_startup') ?>";
                    }, 1000);
                }
            }
        });
    }

    function proses_edit(id_startup) {
        var csrf = getCsrfToken();
        document.getElementById('post-id-startup').value = id_startup;
        var csrfInput = document.getElementById('post-edit-csrf');
        csrfInput.name = csrf.name;
        csrfInput.value = csrf.hash;
        document.getElementById('post-edit-form').submit();
    }

    // Init DataTable
    function initDataStartup() {
        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable().destroy();
        }
        $('#datatable').DataTable({
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

    document.addEventListener('DOMContentLoaded', initDataStartup);
</script>
