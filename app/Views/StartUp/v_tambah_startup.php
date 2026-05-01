<style>
body { background-color: #f5f5f5 !important; }
.paper-wrapper { max-width: 900px; margin: 40px auto; }
.paper-form {
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 40px;
}
.paper-title {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    margin-bottom: 25px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}
.form-label { font-weight: 600; color: #555; margin-bottom: 8px; }
.form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 10px 15px;
    transition: all 0.3s;
}
.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
.btn-modern { padding: 10px 24px; border-radius: 6px; font-weight: 600; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
</style>

<div class="container-fluid" style="background-color:#f5f5f5;padding-bottom:50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title">Tambah Startup</h2>

            <form id="form_tambah" enctype="multipart/form-data" action="" method="POST" novalidate>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perusahaan" class="form-control" style="text-transform:capitalize;" onkeyup="cek_nama_perusahaan()" autocomplete="off" required>
                        <div class="invalid-name text-danger" style="display:none;font-size:12px;margin-top:4px">Mohon isi nama perusahaan</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tahun Berdiri</label>
                        <select name="tahun_berdiri" class="form-select select2_tahun_berdiri">
                            <option value="">Pilih Tahun</option>
                            <?php for ($i = 2000; $i <= date('Y') + 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tahun Daftar <span class="text-danger">*</span></label>
                        <select name="tahun_daftar" class="form-select select2_tahun_daftar" required>
                            <option value="">Pilih Tahun</option>
                            <?php for ($i = 2000; $i <= date('Y') + 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Bidang Usaha <span class="text-danger">*</span></label>
                    <textarea name="deskripsi_bidang_usaha" class="form-control" rows="4" onkeyup="cek_deskripsi()" required></textarea>
                    <div class="invalid-deskripsi text-danger" style="display:none;font-size:12px;margin-top:4px">Mohon isi deskripsi bidang usaha</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Klaster</label>
                    <div class="d-flex flex-wrap gap-2 mt-1">
                        <?php foreach ($klasters as $row): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_klaster[]" id="klaster_<?= $row->id_klaster ?>" value="<?= $row->id_klaster ?>">
                            <label class="form-check-label" for="klaster_<?= $row->id_klaster ?>"><?= esc($row->nama_klaster) ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status Startup <span class="text-danger">*</span></label>
                        <select name="status_startup" class="form-select" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Lulus">Lulus</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Target Pemasaran</label>
                        <input type="text" name="target_pemasaran" class="form-control" style="text-transform:capitalize;" autocomplete="off">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fokus Pelanggan</label>
                        <input type="text" name="fokus_pelanggan" class="form-control" style="text-transform:capitalize;" autocomplete="off">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dosen Pembina</label>
                        <select name="id_dosen_pembina" class="form-select select2-dosen">
                            <option value="">Pilih Dosen Pembina</option>
                            <?php foreach ($dosens as $row): ?>
                            <option value="<?= $row->id_dosen_pembina ?>"><?= esc($row->nama_lengkap) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Program Yang Diikuti</label>
                        <select name="id_program" class="form-select select2-program">
                            <option value="">Pilih Program</option>
                            <?php foreach ($programs as $row): ?>
                            <option value="<?= $row->id_program ?>"><?= esc($row->nama_program) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" style="text-transform:capitalize;" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Titik Lokasi</label>
                    <small class="d-block text-muted mb-2">Ketik alamat untuk mencari lokasi, atau klik langsung pada peta</small>
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" id="search-lokasi" class="form-control" placeholder="Cari alamat atau nama tempat...">
                        <button type="button" onclick="cariLokasi()" class="btn btn-primary btn-modern" style="white-space:nowrap;"><i class="mdi mdi-magnify"></i> Cari</button>
                    </div>
                    <div id="search-result" style="display:none;background:#fff;border:1px solid #e2e8f0;border-radius:6px;max-height:180px;overflow-y:auto;margin-bottom:8px;z-index:999;position:relative;"></div>
                    <div id="map-tambah" style="height:300px;border-radius:6px;border:1px solid #cbd5e1;z-index:0;"></div>
                    <input type="hidden" name="latitude" id="input_lat">
                    <input type="hidden" name="longitude" id="input_lng">
                    <div id="koordinat-info" class="mt-2 text-muted" style="font-size:13px;">Belum ada titik dipilih</div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input name="nomor_whatsapp" type="text" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Perusahaan</label>
                        <input name="email_perusahaan" type="text" class="form-control" style="text-transform:lowercase;" autocomplete="off">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Website Perusahaan</label>
                        <input name="website_perusahaan" type="text" class="form-control" style="text-transform:lowercase;" autocomplete="off">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">LinkedIn Perusahaan</label>
                        <input name="linkedin_perusahaan" type="text" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Instagram Perusahaan</label>
                        <input name="instagram_perusahaan" type="text" class="form-control" autocomplete="off">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Logo Perusahaan</label>
                    <input class="form-control" type="file" name="logo_perusahaan" accept=".jpg,.jpeg,.png">
                    <div class="invalid-logo_perusahaan text-danger" style="display:none;font-size:12px;margin-top:4px"></div>
                    <small class="text-muted">Format: .jpg, .jpeg, .png</small>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('v_data_startup') ?>" class="btn btn-light btn-modern border">Batal</a>
                    <button type="submit" class="submit btn btn-primary btn-modern">Simpan Data</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.select2_tahun_berdiri').select2();
    $('.select2_tahun_daftar').select2();
    $('.select2-dosen').select2({ placeholder: '-- Pilih Dosen Pembina --', allowClear: true });
    $('.select2-program').select2({ placeholder: '-- Pilih Program --', allowClear: true });

    $('#form_tambah').submit(function () {
        var forms = $('#form_tambah');
        var formData = new FormData($('#form_tambah')[0]);
        $('.submit').prop('disabled', true).html('<i class="mdi mdi-spin mdi-loading"></i> Loading...');
        $('body').css('cursor', 'wait');

        var nama = $('input[name="nama_perusahaan"]').val().replace(/^\s+|\s+$/gm, '');
        $('input[name="nama_perusahaan"]').val(nama);
        cek_nama_perusahaan();

        var desk = $('textarea[name="deskripsi_bidang_usaha"]').val().replace(/^\s+|\s+$/gm, '');
        $('textarea[name="deskripsi_bidang_usaha"]').val(desk);
        cek_deskripsi();

        if (forms[0].checkValidity()) {
            $.ajax({
                url: "<?= base_url('v_simpan_startup') ?>",
                type: 'post',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status) {
                        window.location.href = "<?= base_url('v_data_startup') ?>";
                    } else {
                        forms.addClass('was-validated');
                        if (data.status_nama_perusahaan) {
                            $('input[name="nama_perusahaan"]').val('').focus();
                            $('.invalid-name').html(data.msg_nama_perusahaan).css('display', 'block');
                        }
                        if (data.status_logo_perusahaan) {
                            $('input[name="logo_perusahaan"]').val('').focus();
                            $('.invalid-logo_perusahaan').html(data.msg_logo_perusahaan).css('display', 'block');
                        }
                        $('.submit').prop('disabled', false).html('<i class="mdi mdi-content-save"></i> Simpan');
                        $('body').css('cursor', 'default');
                    }
                },
                error: function () {
                    $('.submit').prop('disabled', false).html('<i class="mdi mdi-content-save"></i> Simpan');
                    $('body').css('cursor', 'default');
                }
            });
        } else {
            forms.addClass('was-validated');
            $('.submit').prop('disabled', false).html('<i class="mdi mdi-content-save"></i> Simpan');
            $('body').css('cursor', 'default');
        }

        return false;
    });
});

function cek_nama_perusahaan() {
    var val = $('input[name="nama_perusahaan"]').val().replace(/^\s+|\s+$/gm, '');
    if (val == '' && $('form').hasClass('was-validated')) {
        $('.invalid-name').html('Mohon isi nama perusahaan').css('display', 'block');
    } else if ($('form').hasClass('was-validated')) {
        $('.invalid-name').css('display', 'none');
    }
}

function cek_deskripsi() {
    var val = $('textarea[name="deskripsi_bidang_usaha"]').val().replace(/^\s+|\s+$/gm, '');
    if (val == '' && $('form').hasClass('was-validated')) {
        $('.invalid-deskripsi').html('Mohon isi deskripsi bidang usaha').css('display', 'block');
    } else if ($('form').hasClass('was-validated')) {
        $('.invalid-deskripsi').css('display', 'none');
    }
}
</script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map-tambah').setView([-6.9175, 107.6191], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            map.setView([pos.coords.latitude, pos.coords.longitude], 15);
        });
    }

    var marker = null;
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);
        if (marker) marker.setLatLng(e.latlng);
        else marker = L.marker(e.latlng).addTo(map);
        document.getElementById('input_lat').value = lat;
        document.getElementById('input_lng').value = lng;
        document.getElementById('koordinat-info').innerHTML = '<i class="mdi mdi-map-marker"></i> Lat: ' + lat + ', Lng: ' + lng;
    });

    function cariLokasi() {
        var q = document.getElementById('search-lokasi').value.trim();
        if (!q) return;
        fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(q) + '&limit=5&addressdetails=1')
            .then(r => r.json())
            .then(results => {
                var box = document.getElementById('search-result');
                if (!results.length) { box.style.display='block'; box.innerHTML='<div style="padding:10px;font-size:13px;color:#94a3b8;">Lokasi tidak ditemukan</div>'; return; }
                box.style.display = 'block';
                box.innerHTML = results.map(function(r) {
                    return '<div onclick="pilihLokasi(' + r.lat + ',' + r.lon + ',\'' + r.display_name.replace(/'/g,"\\'") + '\')" style="padding:10px 14px;font-size:13px;cursor:pointer;border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background=\'#f1f5f9\'" onmouseout="this.style.background=\'#fff\'">' + r.display_name + '</div>';
                }).join('');
            });
    }

    function pilihLokasi(lat, lng, nama) {
        var latlng = L.latLng(lat, lng);
        if (marker) marker.setLatLng(latlng);
        else marker = L.marker(latlng).addTo(map);
        map.setView(latlng, 16);
        document.getElementById('input_lat').value = parseFloat(lat).toFixed(7);
        document.getElementById('input_lng').value = parseFloat(lng).toFixed(7);
        document.getElementById('koordinat-info').innerHTML = '<i class="mdi mdi-map-marker"></i> ' + nama;
        document.getElementById('search-result').style.display = 'none';
        document.getElementById('search-lokasi').value = '';
    }

    var debounceTimer;
    document.getElementById('search-lokasi').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        var q = this.value.trim();
        if (!q) { document.getElementById('search-result').style.display = 'none'; return; }
        debounceTimer = setTimeout(cariLokasi, 400);
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#search-result') && e.target.id !== 'search-lokasi') {
            document.getElementById('search-result').style.display = 'none';
        }
    });
</script>
