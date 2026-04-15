<?php /* View: Tambah Startup — form input data startup baru beserta peta lokasi interaktif */ ?>
<!-- Import Font Inter & Lucide Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    /* Global Typography & Background */
    .app-content {
        font-family: 'Inter', sans-serif !important;
        background-color: #f8fafc !important;
        padding: 32px 28px;
    }
    .page-header {
        margin-bottom: 32px;
        display: flex;
        justify-content: center;
        text-align: center;
    }
    .page-header h2 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }
    .page-header .subtitle {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        margin: 0;
    }

    /* Card Wrapper Utama */
    .card-premium {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }
    .card-header-custom {
        padding: 24px 32px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
    }
    .section-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.3px;
    }

    /* Modern Layout for Forms Grid */
    .form-horizontal {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px 32px;
    }
    
    @media (max-width: 992px) {
        .form-horizontal { grid-template-columns: 1fr; }
    }
    
    /* Make some inputs span full width */
    .form-horizontal > .form-row-custom.full-width {
        grid-column: 1 / -1;
    }

    .form-row-custom {
        margin-bottom: 0;
        display: flex;
        flex-direction: column;
    }
    .form-label-custom {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }
    .form-label-custom .text-danger {
        color: #ef4444;
    }

    /* Input modern minimalis */
    .form-control-custom {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        color: #0f172a;
        background: #fff;
        transition: all 0.2s;
        outline: none;
        font-family: inherit;
    }
    .form-control-custom:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }
    
    select.form-control-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%2364748b'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 14px;
        padding-right: 36px;
    }

    /* Checkbox list klaster */
    .checkbox-label-custom {
        font-size: 14px;
        color: #475569;
        font-weight: 500;
        cursor: pointer;
    }
    .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 0;
        border: 1.5px solid #cbd5e1;
        border-radius: 4px;
        cursor: pointer;
    }
    .form-check-input:checked {
        background-color: #6366f1;
        border-color: #6366f1;
    }

    /* Action Buttons Area */
    .form-actions {
        grid-column: 1 / -1;
        border-top: 1px solid #f1f5f9;
        padding-top: 24px;
        margin-top: 8px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    
    .btn-submit-primary {
        background: #6366f1;
        border: 1.5px solid #6366f1;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 32px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 6px rgba(99, 102, 241, 0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-submit-primary:hover {
        background: #4f46e5;
        border-color: #4f46e5;
        box-shadow: 0 6px 12px rgba(99, 102, 241, 0.3);
        transform: translateY(-1px);
    }
    
    .btn-secondary-modern {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #475569 !important;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 24px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-secondary-modern:hover {
        background: #f1f5f9;
        color: #0f172a !important;
    }

    /* Map info panel */
    #koordinat-info {
        background: #f8fafc;
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        font-family: inherit;
        font-size: 13px !important;
        color: #64748b !important;
    }

    /* Select2 fixes for modern look */
    .select2-container--default .select2-selection--single {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        height: 42px;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 8px;
    }
</style>

<div class="app-content">
    <div class="page-header">
        <div>
            <h2>Tambah Startup</h2>
            <p class="subtitle">Daftarkan startup baru ke dalam ekosistem</p>
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
                        <input type="text" name="nama_perusahaan" class="form-control-custom" style="text-transform: capitalize;" onkeyup="cek_nama_perusahaan()" autocomplete="off" required>
                        <div class="invalid-name" style="display:none;color:#ef4444;font-size:12px;margin-top:4px">Mohon isi nama perusahaan</div>
                    </div>
                </div>

                <div class="form-row-custom full-width">
                    <label class="form-label-custom">Deskripsi Bidang Usaha <span class="text-danger">*</span></label>
                    <div>
                        <textarea name="deskripsi_bidang_usaha" class="form-control-custom" rows="4" onkeyup="cek_deskripsi()" required></textarea>
                        <div class="invalid-deskripsi" style="display:none;color:#ef4444;font-size:12px;margin-top:4px">Mohon isi deskripsi bidang usaha</div>
                    </div>
                </div>

                <div class="form-row-custom full-width">
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
                    <input type="text" name="target_pemasaran" class="form-control-custom" style="text-transform: capitalize;" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Fokus Pelanggan</label>
                    <input type="text" name="fokus_pelanggan" class="form-control-custom" style="text-transform: capitalize;" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Dosen Pembina</label>
                    <div>
                        <select name="id_dosen_pembina" class="form-control-custom select2-dosen">
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
                        <select name="id_program" class="form-control-custom select2-program">
                            <option value="">Pilih Program</option>
                            <?php foreach ($programs as $row): ?>
                            <option value="<?= $row->id_program ?>"><?= esc($row->nama_program) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-custom full-width">
                    <label class="form-label-custom">Alamat</label>
                    <textarea name="alamat" class="form-control-custom" style="text-transform: capitalize;" rows="3"></textarea>
                </div>

                <div class="form-row-custom full-width">
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
                    <input name="email_perusahaan" type="text" class="form-control-custom" style="text-transform: lowercase;" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Website Perusahaan</label>
                    <input name="website_perusahaan" type="text" class="form-control-custom" style="text-transform: lowercase;" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">LinkedIn Perusahaan</label>
                    <input name="linkedin_perusahaan" type="text" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom">
                    <label class="form-label-custom">Instagram Perusahaan</label>
                    <input name="instagram_perusahaan" type="text" class="form-control-custom" autocomplete="off">
                </div>

                <div class="form-row-custom full-width">
                    <label class="form-label-custom">Logo Perusahaan</label>
                    <div>
                        <input class="form-control-custom" type="file" name="logo_perusahaan" accept=".jpg,.jpeg,.png">
                        <div class="invalid-logo_perusahaan" style="display:none;color:#ef4444;font-size:12px;margin-top:4px"></div>
                        <small class="text-slate-400" style="font-size:11px">Format: .jpg, .jpeg, .png</small>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('v_data_startup') ?>" class="btn-secondary-modern">Batal</a>
                    <button type="submit" class="submit btn-submit-primary">Simpan Data</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    lucide.createIcons();
    // Inisialisasi Select2 pada dropdown tahun
    $('.select2_tahun_berdiri').select2();
    $('.select2_tahun_daftar').select2();
    $('.select2-dosen').select2({ placeholder: '-- Pilih Dosen Pembina --', allowClear: true });
    $('.select2-program').select2({ placeholder: '-- Pilih Program --', allowClear: true });

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
