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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3 header-title">Tambah Startup</h4>
                            <form id="form_tambah" class="form-horizontal" enctype="multipart/form-data" action="" method="POST" novalidate>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Nama Perusahaan <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="nama_perusahaan" class="form-control"
                                            onkeyup="cek_nama_perusahaan()" autocomplete="off" required>
                                        <div class="invalid-name text-danger" style="display:none;font-size:12px;margin-top:4px">
                                            Mohon isi nama perusahaan
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Deskripsi Bidang Usaha <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" name="deskripsi_bidang_usaha" rows="5"
                                            style="resize: none;" onkeyup="cek_deskripsi()" required></textarea>
                                        <div class="invalid-deskripsi text-danger" style="display:none;font-size:12px;margin-top:4px">
                                            Mohon isi deskripsi bidang usaha
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="example-select" class="col-md-2 col-form-label">Klaster <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <?php foreach ($klasters as $row) { ?>
                                            <div class="form-check form-check-primary mt-1">
                                                <input class="form-check-input" type="checkbox"
                                                    id="klaster_<?php echo $row->id_klaster; ?>"
                                                    value="<?php echo $row->nama_klaster; ?>"
                                                    name="klaster[]" onclick="cek_klaster()" required>
                                                <label class="form-check-label"
                                                    for="klaster_<?php echo $row->id_klaster; ?>">
                                                    <?php echo esc($row->nama_klaster); ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                        <div class="invalid-feedback">
                                            Mohon isi nama klaster
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Status Startup <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select name="status_startup" class="form-control" required>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                            <option value="Lulus">Lulus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Tahun Berdiri</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2_tahun_berdiri" data-toggle="select2"
                                            data-width="100%" name="tahun_berdiri">
                                            <option value="">Pilih Tahun Berdiri</option>
                                            <?php 
                                                $start_year = 2000;
                                                $end_year = date('Y') + 5;
                                                for ($i = $start_year; $i <= $end_year; $i++) {
                                                    echo '<option value="'. $i .'">'. $i .'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Target Pemasaran</label>
                                    <div class="col-md-4">
                                        <input type="text" name="target_pemasaran" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Fokus Pelanggan</label>
                                    <div class="col-md-4">
                                        <input type="text" name="fokus_pelanggan" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Dosen Pembina</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2_dosen_pembina" data-toggle="select2"
                                            data-width="100%" name="id_dosen_pembina">
                                            <option value="">Pilih Dosen Pembina</option>
                                            <?php foreach ($dosens as $row) { ?>
                                                <option value="<?php echo $row->id_dosen_pembina; ?>">
                                                    <?php echo esc($row->nama_lengkap); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Program Yang Diikuti</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2_program_startup" data-toggle="select2"
                                            data-width="100%" name="id_program">
                                            <option value="">Pilih Program Yang Diikuti</option>
                                            <?php foreach ($programs as $row) { ?>
                                                <option value="<?php echo $row->id_program; ?>">
                                                    <?php echo esc($row->nama_program); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Alamat</label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" name="alamat" rows="5"
                                            style="resize: none;"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Titik Lokasi</label>
                                    <div class="col-md-6">
                                        <div class="d-flex gap-2 mb-2">
                                            <input type="text" id="search-lokasi" class="form-control" placeholder="Cari alamat atau nama tempat...">
                                            <button type="button" onclick="cariLokasi()" class="btn btn-primary" style="white-space:nowrap;"><i class="mdi mdi-magnify"></i> Cari</button>
                                        </div>
                                        <div id="search-result" style="display:none;background:#fff;border:1px solid #e2e8f0;border-radius:4px;max-height:180px;overflow-y:auto;margin-bottom:8px;z-index:999;position:relative;"></div>
                                        <div id="map-tambah" style="height:280px;border-radius:4px;border:1px solid #dee2e6;z-index:0;"></div>
                                        <input type="hidden" name="latitude" id="input_lat">
                                        <input type="hidden" name="longitude" id="input_lng">
                                        <div id="koordinat-info" class="mt-1 text-muted" style="font-size:12px;">Belum ada titik dipilih</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Nomor WhatsApp</label>
                                    <div class="col-md-3">
                                        <input name="nomor_whatsapp" type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Email Perusahaan</label>
                                    <div class="col-md-3">
                                        <input name="email_perusahaan" type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Website Perusahaan</label>
                                    <div class="col-md-3">
                                        <input name="website_perusahaan" type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Linkedin Perusahaan</label>
                                    <div class="col-md-3">
                                        <input name="linkedin_perusahaan" type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Instagram Perusahaan</label>
                                    <div class="col-md-3">
                                        <input name="instagram_perusahaan" type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Logo Perusahaan</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="file" name="logo_perusahaan" accept=".jpg, .jpeg, .png">
                                        <div class="invalid-logo_perusahaan text-danger" style="display:none;font-size:12px;margin-top:4px"></div>
                                        <small class="form-text text-muted">Format File : .jpg, .jpeg, .png.</small>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-form-label">Tahun Daftar <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select class="form-control select2_tahun_daftar" data-toggle="select2"
                                            data-width="100%" name="tahun_daftar" required>
                                            <option value="">Pilih Tahun Daftar</option>
                                            <?php 
                                                $start_year = 2000;
                                                $end_year = date('Y') + 5;
                                                for ($i = $start_year; $i <= $end_year; $i++) {
                                                    echo '<option value="'. $i .'">'. $i .'</option>';
                                                }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Mohon pilih tahun daftar
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="submit btn btn-primary" dir="ltr">
                                        <i class="mdi mdi-content-save"></i> Simpan
                                    </button>
                                    <a href="<?php echo base_url('v_data_startup'); ?>"
                                        class="btn btn-white waves-effect waves-light"><i
                                            class="mdi mdi-keyboard-backspace"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->

</div><!-- content-page -->

<script>
    $(document).ready(function () {
        $('.select2_tahun_berdiri').select2();
        $('.select2_dosen_pembina').select2({
            minimumInputLength: 3
        });
        $('.select2_program_startup').select2({
            minimumInputLength: 3
        });
        $('.select2_tahun_daftar').select2();

        $("#form_tambah").submit(function () {
            var forms = $('#form_tambah');
            var formData = new FormData($("#form_tambah")[0]);
            $(".submit").prop("disabled", true);
            $(".submit").html('<i class="mdi mdi-spin mdi-loading"></i> Loading...');
            $("body").css("cursor", "wait");

            var nama_perusahaan = $("input[name='nama_perusahaan']").val().replace(/^\s+|\s+$/gm, '');
            $("input[name='nama_perusahaan']").val(nama_perusahaan);
            cek_nama_perusahaan();

            var deskripsi = $("textarea[name='deskripsi_bidang_usaha']").val().replace(/^\s+|\s+$/gm, '');
            $("textarea[name='deskripsi_bidang_usaha']").val(deskripsi);
            cek_deskripsi();

            if (forms[0].checkValidity()) {
                $.ajax({
                    url: "<?php echo base_url('v_simpan_startup'); ?>",
                    type: "post",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.status) {
                            setTimeout(function () {
                                window.location.href = "<?php echo base_url('v_data_startup') ?>";
                            }, 2000);
                        } else {
                            forms.addClass('was-validated');

                            if (data.status_nama_perusahaan) {
                                $("input[name='nama_perusahaan']").prop('required', true);
                                $("input[name='nama_perusahaan']").val("");
                                $("input[name='nama_perusahaan']").focus();
                                $(".invalid-name").html(data.msg_nama_perusahaan);
                                $(".invalid-name").css('display', 'block');
                            }

                            if (data.status_logo_perusahaan) {
                                $("input[name='logo_perusahaan']").prop('required', true);
                                $("input[name='logo_perusahaan']").val("");
                                $("input[name='logo_perusahaan']").focus();
                                $(".invalid-logo_perusahaan").html(data.msg_logo_perusahaan);
                                $(".invalid-logo_perusahaan").css('display', 'block');
                            }

                            $(".submit").prop("disabled", false);
                            $(".submit").html('<i class="mdi mdi-content-save"></i> Simpan');
                            $("body").css("cursor", "default");
                        }
                    },
                    error: function (xhr, Status, err) {
                        $(".submit").prop("disabled", false);
                        $(".submit").html('<i class="mdi mdi-content-save"></i> Simpan');
                        $("body").css("cursor", "default");
                    }
                });
            } else {
                forms.addClass('was-validated');
                $(".submit").prop("disabled", false);
                $(".submit").html('<i class="mdi mdi-content-save"></i> Simpan');
                $("body").css("cursor", "default");
            }

            return false;
        });

    });

    function cek_nama_perusahaan() {
        var nama_perusahaan = $("input[name='nama_perusahaan']").val().replace(/^\s+|\s+$/gm, '');
        if (nama_perusahaan == "" && $("form").hasClass("was-validated") == true) {
            $("input[name='nama_perusahaan']").val(nama_perusahaan);
            $(".invalid-name").html("Mohon isi nama perusahaan");
            $(".invalid-name").css('display', 'block');
        } else if ($("form").hasClass("was-validated")) {
            $(".invalid-name").css('display', 'none');
        }
    }

    function cek_deskripsi() {
        var deskripsi = $("textarea[name='deskripsi_bidang_usaha']").val().replace(/^\s+|\s+$/gm, '');
        if (deskripsi == "" && $("form").hasClass("was-validated") == true) {
            $("textarea[name='deskripsi_bidang_usaha']").val(deskripsi);
            $(".invalid-deskripsi").html("Mohon isi deskripsi bidang usaha");
            $(".invalid-deskripsi").css('display', 'block');
        } else if ($("form").hasClass("was-validated")) {
            $(".invalid-deskripsi").css('display', 'none');
        }
    }

    function cek_klaster() {
        var jumlah = $('input[name="klaster[]"]:checked').length;
        if (jumlah > 0) {
            $('input[name="klaster[]"]').prop('required', false);
        } else {
            $('input[name="klaster[]"]').prop('required', true);
        }
    }
</script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function initMapTambah() {
    if (!document.getElementById('map-tambah')) return;
    if (window.mapTambahInstance) { window.mapTambahInstance.remove(); window.mapTambahInstance = null; }

    window.mapTambahInstance = L.map('map-tambah').setView([-6.9175, 107.6191], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(window.mapTambahInstance);
    setTimeout(function() { window.mapTambahInstance.invalidateSize(); }, 100);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            window.mapTambahInstance.setView([pos.coords.latitude, pos.coords.longitude], 15);
        });
    }

    window.mapTambahMarker = null;
    window.mapTambahInstance.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7), lng = e.latlng.lng.toFixed(7);
        if (window.mapTambahMarker) window.mapTambahMarker.setLatLng(e.latlng);
        else window.mapTambahMarker = L.marker(e.latlng).addTo(window.mapTambahInstance);
        document.getElementById('input_lat').value = lat;
        document.getElementById('input_lng').value = lng;
        document.getElementById('koordinat-info').innerHTML = '<i class="mdi mdi-map-marker"></i> Lat: ' + lat + ', Lng: ' + lng;
    });
}

function cariLokasi() {
    var q = document.getElementById('search-lokasi').value.trim();
    if (!q) return;
    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(q) + '&limit=5')
        .then(r => r.json())
        .then(results => {
            var box = document.getElementById('search-result');
            if (!results.length) { box.style.display='block'; box.innerHTML='<div style="padding:10px;font-size:13px;color:#94a3b8;">Lokasi tidak ditemukan</div>'; return; }
            box.style.display = 'block';
            box.innerHTML = results.map(function(r) {
                return '<div onclick="pilihLokasi('+r.lat+','+r.lon+',\''+r.display_name.replace(/'/g,"\\'")+'\''+') " style="padding:10px 14px;font-size:13px;cursor:pointer;border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background=\'#f1f5f9\'" onmouseout="this.style.background=\'#fff\'">'+r.display_name+'</div>';
            }).join('');
        });
}

function pilihLokasi(lat, lng, nama) {
    var latlng = L.latLng(lat, lng);
    if (window.mapTambahMarker) window.mapTambahMarker.setLatLng(latlng);
    else window.mapTambahMarker = L.marker(latlng).addTo(window.mapTambahInstance);
    window.mapTambahInstance.setView(latlng, 16);
    document.getElementById('input_lat').value = parseFloat(lat).toFixed(7);
    document.getElementById('input_lng').value = parseFloat(lng).toFixed(7);
    document.getElementById('koordinat-info').innerHTML = '<i class="mdi mdi-map-marker"></i> ' + nama;
    document.getElementById('search-result').style.display = 'none';
    document.getElementById('search-lokasi').value = '';
}

var debounceTimer;
var searchLokasi = document.getElementById('search-lokasi');
if (searchLokasi) {
    searchLokasi.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        var q = this.value.trim();
        if (!q) { document.getElementById('search-result').style.display = 'none'; return; }
        debounceTimer = setTimeout(cariLokasi, 400);
    });
}

if (!window.mapTambahDocClickBound) {
    document.addEventListener('click', function(e) {
        var searchResult = document.getElementById('search-result');
        if (searchResult && !e.target.closest('#search-result') && e.target.id !== 'search-lokasi') {
            searchResult.style.display = 'none';
        }
    });
    window.mapTambahDocClickBound = true;
}

initMapTambah();
</script>
