<?php /* View: Tambah Startup — form input data startup baru beserta peta lokasi interaktif */ ?>
<style>
    .app-content { background-color: #F3F4F4 !important; }
</style>

<div class="app-content">
    <div class="page-header">
        <div>
            <h2>Tambah Startup</h2>
            <p class="subtitle">Isi data startup baru</p>
        </div>
    </div>

    <div class="card-premium">
        <div class="card-header-custom">
            <span class="section-title mb-0">Informasi Startup</span>
        </div>
        <div class="p-4">
            <form id="form_tambah" class="form-horizontal" enctype="multipart/form-data" action="" method="POST" novalidate>

                <div class="form-row-custom">
                    <label class="form-label-custom">Nama Perusahaan <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="nama_perusahaan" class="form-control-custom" onkeyup="cek_nama_perusahaan()" autocomplete="off" required>
                        <div class="invalid-name" style="display:none;color:#ef4444;font-size:12px;margin-top:4px">Mohon isi nama perusahaan</div>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Deskripsi Bidang Usaha <span class="text-danger">*</span></label>
                    <div>
                        <textarea name="deskripsi_bidang_usaha" class="form-control-custom" rows="4" onkeyup="cek_deskripsi()" required></textarea>
                        <div class="invalid-deskripsi" style="display:none;color:#ef4444;font-size:12px;margin-top:4px">Mohon isi deskripsi bidang usaha</div>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Klaster <span class="text-danger">*</span></label>
                    <div>
                        <?php foreach ($klasters as $row): ?>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <input class="form-check-input" type="checkbox" id="klaster_<?= $row->id_klaster ?>" value="<?= $row->id_klaster ?>" name="kluster[]" onclick="cek_klaster()">
                            <label class="checkbox-label-custom" for="klaster_<?= $row->id_klaster ?>"><?= esc($row->nama_klaster) ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Tahun Berdiri</label>
                    <div>
                        <select name="tahun_berdiri" class="form-control-custom">
                            <option value="">Pilih Tahun Berdiri</option>
                            <?php for ($i = 2000; $i <= date('Y') + 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Tahun Daftar <span class="text-danger">*</span></label>
                    <div>
                        <select name="tahun_daftar" class="form-control-custom" required>
                            <option value="">Pilih Tahun Daftar</option>
                            <?php for ($i = 2000; $i <= date('Y') + 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Status Startup <span class="text-danger">*</span></label>
                    <div>
                        <select name="status_startup" class="form-control-custom" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Lulus">Lulus</option>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Target Pemasaran</label>
                    <input type="text" name="target_pemasaran" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Fokus Pelanggan</label>
                    <input type="text" name="fokus_pelanggan" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Dosen Pembina</label>
                    <div>
                        <select name="id_dosen_pembina" class="form-control-custom">
                            <option value="">Pilih Dosen Pembina</option>
                            <?php foreach ($dosens as $row): ?>
                            <option value="<?= $row->id_dosen_pembina ?>"><?= esc($row->nama_lengkap) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Program Yang Diikuti</label>
                    <div>
                        <select name="id_program" class="form-control-custom">
                            <option value="">Pilih Program</option>
                            <?php foreach ($programs as $row): ?>
                            <option value="<?= $row->id_program ?>"><?= esc($row->nama_program) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Alamat</label>
                    <textarea name="alamat" class="form-control-custom" rows="3"></textarea>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Titik Lokasi</label>
                    <div>
                        <div style="font-size:12px;color:var(--slate-400);margin-bottom:8px;">Ketik alamat untuk mencari lokasi, atau klik langsung pada peta</div>
                        <div class="d-flex gap-2 mb-2">
                            <input type="text" id="search-lokasi" class="form-control-custom" placeholder="Cari alamat atau nama tempat..." style="flex:1;">
                            <button type="button" onclick="cariLokasi()" class="btn-submit-primary" style="padding:10px 16px;white-space:nowrap;"><i class="mdi mdi-magnify"></i> Cari</button>
                        </div>
                        <div id="search-result" style="display:none;background:#fff;border:1px solid var(--slate-200);border-radius:8px;max-height:180px;overflow-y:auto;margin-bottom:8px;z-index:999;position:relative;"></div>
                        <div id="map-tambah" style="height:300px;border-radius:10px;border:1px solid var(--slate-200);z-index:0;"></div>
                        <input type="hidden" name="latitude" id="input_lat">
                        <input type="hidden" name="longitude" id="input_lng">
                        <div id="koordinat-info" style="margin-top:6px;font-size:12px;color:var(--slate-500);">Belum ada titik dipilih</div>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Nomor WhatsApp</label>
                    <input name="nomor_whatsapp" type="text" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Email Perusahaan</label>
                    <input name="email_perusahaan" type="text" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Website Perusahaan</label>
                    <input name="website_perusahaan" type="text" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">LinkedIn Perusahaan</label>
                    <input name="linkedin_perusahaan" type="text" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Instagram Perusahaan</label>
                    <input name="instagram_perusahaan" type="text" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Logo Perusahaan</label>
                    <div>
                        <input class="form-control-custom" type="file" name="logo_perusahaan" accept=".jpg,.jpeg,.png">
                        <div class="invalid-logo_perusahaan" style="display:none;color:#ef4444;font-size:12px;margin-top:4px"></div>
                        <small class="text-slate-400" style="font-size:11px">Format: .jpg, .jpeg, .png</small>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4 pt-4" style="border-top:1px solid var(--slate-100)">
                    <button type="submit" class="submit btn-submit-primary">Simpan</button>
                    <a href="<?= base_url('v_data_startup') ?>" class="btn-submit-primary" style="background:var(--slate-200);color:var(--slate-700);text-decoration:none">Kembali</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Inisialisasi Select2 pada dropdown tahun
    $('.select2_tahun_berdiri').select2();
    $('.select2_tahun_daftar').select2();

    // Submit form tambah startup via AJAX dengan validasi nama dan logo
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

// Validasi input nama perusahaan: tampilkan pesan error jika kosong
function cek_nama_perusahaan() {
    var val = $('input[name="nama_perusahaan"]').val().replace(/^\s+|\s+$/gm, '');
    if (val == '' && $('form').hasClass('was-validated')) {
        $('.invalid-name').html('Mohon isi nama perusahaan').css('display', 'block');
    } else if ($('form').hasClass('was-validated')) {
        $('.invalid-name').css('display', 'none');
    }
}

// Validasi textarea deskripsi: tampilkan pesan error jika kosong
function cek_deskripsi() {
    var val = $('textarea[name="deskripsi_bidang_usaha"]').val().replace(/^\s+|\s+$/gm, '');
    if (val == '' && $('form').hasClass('was-validated')) {
        $('.invalid-deskripsi').html('Mohon isi deskripsi bidang usaha').css('display', 'block');
    } else if ($('form').hasClass('was-validated')) {
        $('.invalid-deskripsi').css('display', 'none');
    }
}

// Validasi checkbox klaster: wajib pilih minimal satu klaster
function cek_klaster() {
    var jumlah = $('input[name="kluster[]"]:checked').length;
    $('input[name="kluster[]"]').prop('required', jumlah === 0);
}
</script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Inisialisasi peta Leaflet dengan titik awal Bandung
    var map = L.map('map-tambah').setView([-6.9175, 107.6191], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Auto fokus ke lokasi user jika browser mendukung geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            map.setView([pos.coords.latitude, pos.coords.longitude], 15);
        });
    }

    // Saat peta diklik, pasang/pindahkan marker dan simpan koordinat ke input hidden
    var marker = null;
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);
        if (marker) marker.setLatLng(e.latlng);
        else marker = L.marker(e.latlng).addTo(map);
        document.getElementById('input_lat').value = lat;
        document.getElementById('input_lng').value = lng;
        document.getElementById('koordinat-info').innerHTML =
            '<i class="mdi mdi-map-marker" style="color:var(--primary)"></i> Lat: ' + lat + ', Lng: ' + lng;
    });

    // Cari lokasi berdasarkan teks menggunakan Nominatim OpenStreetMap API
    function cariLokasi() {
        var q = document.getElementById('search-lokasi').value.trim();
        if (!q) return;
        fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(q) + '&limit=5&addressdetails=1')
            .then(r => r.json())
            .then(results => {
                var box = document.getElementById('search-result');
                if (!results.length) { box.style.display='block'; box.innerHTML='<div style="padding:10px;font-size:13px;color:var(--slate-400);">Lokasi tidak ditemukan</div>'; return; }
                box.style.display = 'block';
                box.innerHTML = results.map(function(r) {
                    return '<div onclick="pilihLokasi(' + r.lat + ',' + r.lon + ',\'' + r.display_name.replace(/'/g,"\\'") + '\')" style="padding:10px 14px;font-size:13px;cursor:pointer;border-bottom:1px solid var(--slate-100);" onmouseover="this.style.background=\'#f1f5f9\'" onmouseout="this.style.background=\'#fff\'">' + r.display_name + '</div>';
                }).join('');
            });
    }

    // Pilih lokasi dari hasil pencarian: pindahkan marker dan simpan koordinat
    function pilihLokasi(lat, lng, nama) {
        var latlng = L.latLng(lat, lng);
        if (marker) marker.setLatLng(latlng);
        else marker = L.marker(latlng).addTo(map);
        map.setView(latlng, 16);
        document.getElementById('input_lat').value = parseFloat(lat).toFixed(7);
        document.getElementById('input_lng').value = parseFloat(lng).toFixed(7);
        document.getElementById('koordinat-info').innerHTML = '<i class="mdi mdi-map-marker" style="color:var(--primary)"></i> ' + nama;
        document.getElementById('search-result').style.display = 'none';
        document.getElementById('search-lokasi').value = '';
    }

    // Debounce pencarian otomatis saat user mengetik di kolom pencarian lokasi
    var debounceTimer;
    document.getElementById('search-lokasi').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        var q = this.value.trim();
        if (!q) { document.getElementById('search-result').style.display = 'none'; return; }
        debounceTimer = setTimeout(cariLokasi, 400);
    });

    // Tutup dropdown hasil pencarian jika user klik di luar area pencarian
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#search-result') && e.target.id !== 'search-lokasi') {
            document.getElementById('search-result').style.display = 'none';
        }
    });
</script>
