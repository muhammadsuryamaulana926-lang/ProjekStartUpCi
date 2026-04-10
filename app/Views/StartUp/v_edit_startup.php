<?php /* View: Edit Startup — form ubah data startup yang sudah ada beserta peta lokasi interaktif */ ?>
<style>
    .app-content { background-color: #F3F4F4 !important; }
</style>

<div class="app-content">
    <div class="page-header">
        <div>
            <h2>Edit Startup</h2>
            <p class="subtitle">Ubah data startup</p>
        </div>
    </div>

    <div class="card-premium">
        <div class="card-header-custom">
            <span class="section-title mb-0">Informasi Startup</span>
        </div>
        <div class="p-4">
            <form id="form_ubah" class="form-horizontal" enctype="multipart/form-data" action="" method="POST" novalidate>
                <input type="hidden" name="id_startup" value="<?= $data[0]['id_startup'] ?>">

                <div class="form-row-custom">
                    <label class="form-label-custom">Nama Perusahaan <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="nama_perusahaan" class="form-control-custom" onkeyup="cek_nama_perusahaan()" value="<?= esc($data[0]['nama_perusahaan']) ?>" autocomplete="off" required>
                        <div class="invalid-name" style="display:none;color:#ef4444;font-size:12px;margin-top:4px">Mohon isi nama perusahaan</div>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Deskripsi Bidang Usaha <span class="text-danger">*</span></label>
                    <div>
                        <textarea name="deskripsi_bidang_usaha" class="form-control-custom" rows="4" onkeyup="cek_deskripsi()" required><?= esc($data[0]['deskripsi_bidang_usaha']) ?></textarea>
                        <div class="invalid-deskripsi" style="display:none;color:#ef4444;font-size:12px;margin-top:4px">Mohon isi deskripsi bidang usaha</div>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Klaster <span class="text-danger">*</span></label>
                    <div>
                        <?php
                        $klaster_aktif = [];
                        if (!empty($data[0]['klaster'])) {
                            $klaster_aktif = array_map('trim', explode(',', $data[0]['klaster']));
                        }
                        foreach ($daftar_klaster as $row):
                        ?>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <input class="form-check-input" type="checkbox"
                                id="klaster_<?= $row->id_klaster ?>"
                                value="<?= $row->id_klaster ?>"
                                name="kluster[]"
                                onclick="cek_klaster()"
                                <?= in_array($row->nama_klaster, $klaster_aktif) ? 'checked' : '' ?>>
                            <label class="checkbox-label-custom" for="klaster_<?= $row->id_klaster ?>"><?= esc($row->nama_klaster) ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Tahun Berdiri</label>
                    <div>
                        <select name="tahun_berdiri" class="form-control-custom select2_tahun_berdiri">
                            <option value="">Pilih Tahun Berdiri</option>
                            <?php for ($i = 2000; $i <= date('Y') + 5; $i++): ?>
                            <option value="<?= $i ?>" <?= $data[0]['tahun_berdiri'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Tahun Daftar <span class="text-danger">*</span></label>
                    <div>
                        <select name="tahun_daftar" class="form-control-custom select2_tahun_daftar" required>
                            <option value="">Pilih Tahun Daftar</option>
                            <?php for ($i = 2000; $i <= date('Y') + 5; $i++): ?>
                            <option value="<?= $i ?>" <?= $data[0]['tahun_daftar'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Status Startup <span class="text-danger">*</span></label>
                    <div>
                        <select name="status_startup" class="form-control-custom" required>
                            <?php foreach (['Aktif', 'Tidak Aktif', 'Lulus'] as $s): ?>
                            <option value="<?= $s ?>" <?= $data[0]['status_startup'] == $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Target Pemasaran</label>
                    <input type="text" name="target_pemasaran" class="form-control-custom" value="<?= esc($data[0]['target_pemasaran']) ?>" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Fokus Pelanggan</label>
                    <input type="text" name="fokus_pelanggan" class="form-control-custom" value="<?= esc($data[0]['fokus_pelanggan']) ?>" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Dosen Pembina</label>
                    <div>
                        <select name="id_dosen_pembina" class="form-control-custom">
                            <option value="">Pilih Dosen Pembina</option>
                            <?php foreach ($daftar_anggota as $row): ?>
                            <option value="<?= $row->id_anggota ?>" <?= $data[0]['id_dosen_pembina'] == $row->id_anggota ? 'selected' : '' ?>><?= esc($row->nama_lengkap) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Program Yang Diikuti</label>
                    <div>
                        <select name="id_program_kewirausahaan_startup" class="form-control-custom">
                            <option value="">Pilih Program</option>
                            <?php foreach ($daftar_program_startup as $row): ?>
                            <option value="<?= $row->id_program_kewirausahaan_startup ?>" <?= $data[0]['id_program_kewirausahaan_startup'] == $row->id_program_kewirausahaan_startup ? 'selected' : '' ?>><?= esc($row->nama_program) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Alamat</label>
                    <textarea name="alamat" class="form-control-custom" rows="3"><?= esc($data[0]['alamat']) ?></textarea>
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
                        <div id="map-edit" style="height:300px;border-radius:10px;border:1px solid var(--slate-200);z-index:0;"></div>
                        <input type="hidden" name="latitude" id="input_lat" value="<?= $data[0]['latitude'] ?? '' ?>">
                        <input type="hidden" name="longitude" id="input_lng" value="<?= $data[0]['longitude'] ?? '' ?>">
                        <div id="koordinat-info" style="margin-top:6px;font-size:12px;color:var(--slate-500);">
                            <?php if (!empty($data[0]['latitude'])): ?>
                                <i class="mdi mdi-map-marker" style="color:var(--primary)"></i> Lat: <?= $data[0]['latitude'] ?>, Lng: <?= $data[0]['longitude'] ?>
                            <?php else: ?>
                                Belum ada titik dipilih
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Nomor WhatsApp</label>
                    <input name="no_whatsapp" type="text" class="form-control-custom" value="<?= esc($data[0]['no_whatsapp']) ?>" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Email Perusahaan</label>
                    <input name="email_perusahaan" type="text" class="form-control-custom" value="<?= esc($data[0]['email_perusahaan']) ?>" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Website Perusahaan</label>
                    <input name="website_perusahaan" type="text" class="form-control-custom" value="<?= esc($data[0]['website_perusahaan']) ?>" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">LinkedIn Perusahaan</label>
                    <input name="linkedin_perusahaan" type="text" class="form-control-custom" value="<?= esc($data[0]['linkedin_perusahaan']) ?>" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Instagram Perusahaan</label>
                    <input name="instagram_perusahaan" type="text" class="form-control-custom" value="<?= esc($data[0]['instagram_perusahaan']) ?>" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Logo Perusahaan</label>
                    <div>
                        <input class="form-control-custom" type="file" name="logo_perusahaan" accept=".jpg,.jpeg,.png">
                        <div class="invalid-logo_perusahaan" style="display:none;color:#ef4444;font-size:12px;margin-top:4px"></div>
                        <small class="text-slate-400" style="font-size:11px">Format: .jpg, .jpeg, .png</small>
                        <?php if (!empty($data[0]['logo_perusahaan'])): ?>
                        <div class="mt-2">
                            <img src="<?= base_url('public/uploads/file_startup/logo_startup/' . $data[0]['logo_perusahaan']) ?>" style="height:60px;width:auto;border-radius:8px;border:1px solid var(--slate-100)">
                        </div>
                        <?php endif; ?>
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
    // Set nilai awal semua dropdown sesuai data startup yang sedang diedit
    $('select[name="tahun_berdiri"]').val('<?= $data[0]['tahun_berdiri'] ?>');
    $('select[name="id_dosen_pembina"]').val('<?= $data[0]['id_dosen_pembina'] ?>');
    $('select[name="status_startup"]').val('<?= $data[0]['status_startup'] ?>');
    $('select[name="id_program_kewirausahaan_startup"]').val('<?= $data[0]['id_program_kewirausahaan_startup'] ?>');
    $('select[name="tahun_daftar"]').val('<?= $data[0]['tahun_daftar'] ?>');

    // Inisialisasi Select2 pada dropdown tahun (try-catch agar tidak error jika belum dimuat)
    try { $('.select2_tahun_berdiri').select2(); $('.select2_tahun_daftar').select2(); } catch(e) {}
    cek_klaster();

    // Submit form edit startup via AJAX dengan validasi nama dan logo
    $('#form_ubah').submit(function () {
        var forms = $('#form_ubah');
        var formData = new FormData($('#form_ubah')[0]);
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
                url: "<?= base_url('v_update_startup') ?>",
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
                error: function (xhr) {
                    console.log('status:', xhr.status, 'response:', xhr.responseText);
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

function cek_klaster() {
    var jumlah = $('input[name="kluster[]"]:checked').length;
    $('input[name="kluster[]"]').prop('required', jumlah === 0);
}
</script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Ambil koordinat yang sudah tersimpan sebelumnya (null jika belum ada)
    var existingLat = <?= !empty($data[0]['latitude'])  ? $data[0]['latitude']  : 'null' ?>;
    var existingLng = <?= !empty($data[0]['longitude']) ? $data[0]['longitude'] : 'null' ?>;

    var centerLat = existingLat || -6.9175;
    var centerLng = existingLng || 107.6191;
    var zoomLevel = existingLat ? 15 : 13;

    var mapEdit = L.map('map-edit').setView([centerLat, centerLng], zoomLevel);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(mapEdit);

    // Auto fokus ke lokasi user jika belum ada koordinat
    if (!existingLat && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            mapEdit.setView([pos.coords.latitude, pos.coords.longitude], 15);
        });
    }

    // Tampilkan marker di peta jika koordinat sudah ada
    var marker = null;
    if (existingLat && existingLng) {
        marker = L.marker([existingLat, existingLng]).addTo(mapEdit);
    }

    // Saat peta diklik, pindahkan/pasang marker dan perbarui input koordinat
    mapEdit.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);
        if (marker) marker.setLatLng(e.latlng);
        else marker = L.marker(e.latlng).addTo(mapEdit);
        document.getElementById('input_lat').value = lat;
        document.getElementById('input_lng').value = lng;
        document.getElementById('koordinat-info').innerHTML =
            '<i class="mdi mdi-map-marker" style="color:var(--primary)"></i> Lat: ' + lat + ', Lng: ' + lng;
    });

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

    function pilihLokasi(lat, lng, nama) {
        var latlng = L.latLng(lat, lng);
        if (marker) marker.setLatLng(latlng);
        else marker = L.marker(latlng).addTo(mapEdit);
        mapEdit.setView(latlng, 16);
        document.getElementById('input_lat').value = parseFloat(lat).toFixed(7);
        document.getElementById('input_lng').value = parseFloat(lng).toFixed(7);
        document.getElementById('koordinat-info').innerHTML = '<i class="mdi mdi-map-marker" style="color:var(--primary)"></i> ' + nama;
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
