<style>
    /* Map fullscreen — mengisi sisa ruang setelah topbar */
    .app-content { padding: 0 !important; overflow: hidden !important; }

    #map-lokasi-all {
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    /* Wrapper map fullscreen */
    .map-fullscreen-wrap {
        position: relative;
        flex: 1;
        overflow: hidden;
        height: 100%;
    }

    /* Tombol kontrol kanan atas di dalam map */
    .map-controls-top {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 999;
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-end;
    }

    /* Stat cards di dalam map */
    .map-stat-card {
        background: #fff;
        border-radius: 12px;
        border: 1.5px solid var(--slate-100);
        box-shadow: 0 4px 16px rgba(0,0,0,0.10);
        padding: 10px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        min-width: 190px;
        transition: box-shadow 0.2s;
        position: relative;
    }
    .map-stat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.14); }
    .map-stat-icon {
        width: 38px; height: 38px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .map-stat-icon i { font-size: 20px; }
    .map-stat-val { font-size: 1.6rem; font-weight: 800; line-height: 1; }
    .map-stat-label { font-size: 11px; font-weight: 600; color: var(--slate-500); }

    /* Dropdown di dalam map */
    .map-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 340px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        z-index: 9999;
        overflow: hidden;
    }
    .map-dropdown-header {
        padding: 14px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #edf2f7;
        display: flex; align-items: center; justify-content: space-between;
    }
    .map-dropdown-header .title { font-size: 13px; font-weight: 700; color: #1e293b; }
    .map-dropdown-header .subtitle { font-size: 11px; color: #64748b; margin-top: 2px; }
    .map-dropdown-body { max-height: 300px; overflow-y: auto; scrollbar-width: thin; }
    .map-dropdown-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 18px; border-bottom: 1px solid #f1f5f9;
        background: #fff; transition: background 0.2s;
    }
    .map-dropdown-item:hover { background: #f1f5f9; }

    /* Panel Detail Modern */
    #panel-detail {
        position: absolute;
        top: 0; left: 0;
        width: 360px; height: 100%;
        background: #f8fafc;
        border-radius: 0;
        box-shadow: 10px 0 30px rgba(0,0,0,0.1);
        z-index: 999;
        display: flex; flex-direction: column;
        transform: translateX(-100%);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: 'Inter', sans-serif;
    }
    #panel-detail.show { transform: translateX(0); }

    .panel-cover {
        width: 100%; padding: 16px; min-height: 140px;
        background: #ffffff;
        border-bottom: 1px dashed #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        position: relative;
    }
    .panel-logo-wrap {
        width: 100%; height: 110px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .panel-logo-wrap img { max-width: 100%; height: 100%; object-fit: contain; }

    .panel-close {
        position: absolute; top: 16px; right: 16px;
        width: 32px; height: 32px;
        background: rgba(255,255,255,0.8); border: none; border-radius: 50%;
        color: #0f172a; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        z-index: 10; transition: all 0.2s; backdrop-filter: blur(4px);
    }
    .panel-close:hover { background: #fff; transform: scale(1.1); }

    .panel-body-scroll {
        flex: 1; padding: 24px; overflow-y: auto; scrollbar-width: none;
    }
    .panel-body-scroll::-webkit-scrollbar { display: none; }
    
    .panel-nama { font-size: 18px; font-weight: 900; color: #0f172a; margin-bottom: 8px; line-height: 1.2; letter-spacing: -0.5px; text-align: center; }
    
    .panel-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px; justify-content: center; }
    .panel-badge { padding: 4px 12px; border-radius: 20px; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; border: 1px solid transparent; }
    
    .panel-section { background: #fff; border-radius: 12px; padding: 16px; margin-bottom: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .panel-section-title { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px; display: block; }
    
    .panel-desc { font-size: 13px; color: #475569; line-height: 1.6; margin: 0; }
    
    .panel-info-row { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px; }
    .panel-info-row:last-child { margin-bottom: 0; }
    .panel-info-icon { width: 24px; height: 24px; border-radius: 6px; background: #f1f5f9; color: #64748b; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .panel-info-content { flex: 1; }
    .panel-info-label { font-size: 10px; color: #94a3b8; font-weight: 600; text-transform: uppercase; }
    .panel-info-value { font-size: 13px; color: #334155; font-weight: 500; word-break: break-word; line-height: 1.4; }
    .panel-info-value a { color: #6366f1; text-decoration: none; font-weight: 500; }
    .panel-info-value a:hover { text-decoration: underline; }

    .panel-grid-box { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .grid-box-item { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 8px; padding: 10px; text-align: center; }
    .grid-box-val { font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 2px; }
    .grid-box-lbl { font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }

    .panel-social-link { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; text-decoration: none !important; }

    .panel-footer { padding: 20px 24px; background: #fff; border-top: 1px solid #e2e8f0; }
    .panel-btn-detail {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; background: #6366f1; color: #fff;
        font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;
        padding: 12px 16px; border-radius: 12px; text-decoration: none;
        transition: all 0.2s; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
    }
    .panel-btn-detail:hover { background: #4f46e5; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35); }

    /* Globe Dropdown */
    #ddGlobal { width: 420px; }
    #ddGlobal .map-dropdown-body { max-height: none; overflow: hidden; padding: 0; }
    #globe-container {
        width: 100%; height: 380px;
        background: #000d1a;
        position: relative;
        overflow: hidden;
    }
    #globe-container > div { width: 100% !important; height: 100% !important; }

    /* Custom Cluster Color: Blue (Force with !important) */
    .marker-cluster-small { background-color: rgba(99, 102, 241, 0.4) !important; }
    .marker-cluster-small div { background-color: rgba(99, 102, 241, 0.8) !important; color: #fff !important; }
    .marker-cluster-medium { background-color: rgba(79, 70, 229, 0.4) !important; }
    .marker-cluster-medium div { background-color: rgba(79, 70, 229, 0.8) !important; color: #fff !important; }
    .marker-cluster-large { background-color: rgba(67, 56, 202, 0.4) !important; }
    .marker-cluster-large div { background-color: rgba(67, 56, 202, 0.8) !important; color: #fff !important; }
    .marker-cluster div {
        width: 30px !important;
        height: 30px !important;
        margin-left: 5px !important;
        margin-top: 5px !important;
        text-align: center !important;
        border-radius: 15px !important;
        font-weight: 700 !important;
        font-size: 12px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
</style>

<div class="map-fullscreen-wrap">
    <div id="map-lokasi-all"></div>

    <?php if (session()->get('user_role') !== 'pemilik_startup'): ?>
    <!-- Stat cards di dalam map -->
    <div class="map-controls-top">
        <div class="position-relative">
            <div class="map-stat-card" onclick="toggleMapDropdown('ddTerpetakan')">
                <div class="map-stat-icon" style="background:var(--primary-light);">
                    <i class="mdi mdi-map-marker-multiple" style="color:var(--primary);"></i>
                </div>
                <div>
                    <div class="map-stat-val"><?= count(array_filter($startups, fn($s) => !empty($s->latitude))) ?></div>
                    <div class="map-stat-label">Startup Terpetakan</div>
                </div>
            </div>
            <div id="ddTerpetakan" class="map-dropdown">
                <div class="map-dropdown-header">
                    <div>
                        <div class="title">Startup Terpetakan</div>
                        <div class="subtitle">Lokasi yang sudah ditentukan</div>
                    </div>
                    <span style="background:var(--primary);color:#fff;font-size:11px;font-weight:600;padding:2px 10px;border-radius:20px;"><?= count(array_filter($startups, fn($s) => !empty($s->latitude))) ?></span>
                </div>
                <div class="map-dropdown-body">
                    <?php $mapped = array_filter($startups, fn($s) => !empty($s->latitude));
                    if (empty($mapped)): ?>
                        <div style="padding:30px;text-align:center;color:#94a3b8;font-size:12px;">Data tidak ditemukan</div>
                    <?php else: foreach ($mapped as $s): ?>
                    <div class="map-dropdown-item">
                        <div style="flex:1;padding-right:12px;">
                            <div style="font-size:12px;font-weight:600;color:#334155;margin-bottom:4px;"><?= esc($s->nama_perusahaan) ?></div>
                            <div style="display:flex;gap:6px;">
                                <span style="font-size:9px;font-family:monospace;background:#e2e8f0;color:#475569;padding:1px 5px;border-radius:4px;">LAT: <?= number_format($s->latitude, 3) ?></span>
                                <span style="font-size:9px;font-family:monospace;background:#e2e8f0;color:#475569;padding:1px 5px;border-radius:4px;">LON: <?= number_format($s->longitude, 3) ?></span>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="fokusMarker(<?= $s->latitude ?>, <?= $s->longitude ?>)"
                           style="display:flex;align-items:center;justify-content:center;width:30px;height:30px;background:#f8fafc;color:var(--primary);border-radius:8px;border:1px solid #e2e8f0;transition:all 0.2s;text-decoration:none;"
                           onmouseover="this.style.background='var(--primary)';this.style.color='#fff'" onmouseout="this.style.background='#f8fafc';this.style.color='var(--primary)'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </a>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>

        <div class="position-relative">
            <div class="map-stat-card" onclick="toggleMapDropdown('ddBelumLokasi')">
                <div class="map-stat-icon" style="background:rgba(239,68,68,0.08);">
                    <i class="mdi mdi-map-marker-off" style="color:#dc2626;"></i>
                </div>
                <div>
                    <div class="map-stat-val"><?= count(array_filter($startups, fn($s) => empty($s->latitude))) ?></div>
                    <div class="map-stat-label">Belum Ada Lokasi</div>
                </div>
            </div>
            <div id="ddBelumLokasi" class="map-dropdown">
                <div class="map-dropdown-header">
                    <div>
                        <div class="title">Belum Ada Lokasi</div>
                        <div class="subtitle">Startup yang belum ditentukan lokasinya</div>
                    </div>
                    <span style="background:#dc2626;color:#fff;font-size:11px;font-weight:600;padding:2px 10px;border-radius:20px;"><?= count(array_filter($startups, fn($s) => empty($s->latitude))) ?></span>
                </div>
                <div class="map-dropdown-body">
                    <?php $unmapped = array_filter($startups, fn($s) => empty($s->latitude));
                    if (empty($unmapped)): ?>
                        <div style="padding:30px;text-align:center;color:#94a3b8;font-size:12px;">Semua startup sudah memiliki lokasi</div>
                    <?php else: foreach ($unmapped as $s): ?>
                    <div class="map-dropdown-item">
                        <div style="flex:1;padding-right:12px;">
                            <div style="font-size:12px;font-weight:600;color:#334155;margin-bottom:4px;"><?= esc($s->nama_perusahaan) ?></div>
                            <span style="font-size:9px;background:#fee2e2;color:#dc2626;padding:1px 5px;border-radius:4px;">Lokasi belum diisi</span>
                        </div>
                        <a href="<?= base_url('v_edit_startup/' . $s->uuid_startup) ?>"
                           style="display:flex;align-items:center;justify-content:center;width:30px;height:30px;background:#f8fafc;color:#dc2626;border-radius:8px;border:1px solid #e2e8f0;transition:all 0.2s;text-decoration:none;"
                           onmouseover="this.style.background='#dc2626';this.style.color='#fff'" onmouseout="this.style.background='#f8fafc';this.style.color='#dc2626'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>

    </div>
    <?php endif; ?>

    <!-- Panel Detail Startup -->
    <div id="panel-detail">
        <div class="panel-cover">
            <button class="panel-close" onclick="tutupPanel()"><i data-lucide="x" style="width:16px;"></i></button>
            <div class="panel-logo-wrap">
                <img id="panel-logo" src="" alt="Logo">
            </div>
        </div>
        
        <div class="panel-body-scroll">
            <h3 class="panel-nama" id="panel-nama"></h3>
            <div class="panel-badges" id="panel-badges"></div>
            
            <div id="panel-content-wrapper"></div>
        </div>
        
        <div class="panel-footer">
            <a id="panel-link" href="#" class="panel-btn-detail">
                Lihat Detail Lengkap <i data-lucide="arrow-right" style="width:16px;"></i>
            </a>
        </div>
    </div>
</div>

<script>
function startMapLokasi() {
    if (window.mapLokasiAll) {
        try { window.mapLokasiAll.remove(); } catch(e) {}
        window.mapLokasiAll = null;
    }

    var map = L.map('map-lokasi-all').setView([-2.5, 118.0], 5);
    window.mapLokasiAll = map;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // Inisialisasi Marker Cluster Group
    var markerCluster = L.markerClusterGroup({
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true,
        spiderfyOnMaxZoom: true,
        animate: true,
        animateAddingMarkers: true
    });

    var markers = [];
    var data = <?= json_encode(array_values(array_filter($startups, fn($s) => !empty($s->latitude)))) ?>;
    var baseLogoUrl  = '<?= base_url('uploads/file_startup/logo_startup/') ?>';
    var defaultLogo  = '<?= base_url('img/logo-dkst.png') ?>';
    var baseDetailUrl = '<?= base_url('v_detail/') ?>';

    data.forEach(function(s) {
        var markerHtml = `<div style="background:#6366f1; width:24px; height:24px; border-radius:50%; border:3px solid #fff; box-shadow:0 4px 8px rgba(0,0,0,0.2);"></div>`;
        var customIcon = L.divIcon({ className: 'custom-pin', html: markerHtml, iconSize: [24, 24], iconAnchor: [12, 12] });
        var m = L.marker([s.latitude, s.longitude], {icon: customIcon});
        m.on('click', function() { bukaPanel(s); });
        
        // Simpan marker ke array dan tambahkan ke cluster
        markers.push(m);
        markerCluster.addLayer(m);
    });

    // Tambahkan cluster ke peta
    map.addLayer(markerCluster);

    var urlParams = new URLSearchParams(window.location.search);
    var focusLat  = parseFloat(urlParams.get('lat'));
    var focusLng  = parseFloat(urlParams.get('lng'));
    if (focusLat && focusLng) {
        setTimeout(function() {
            map.setView([focusLat, focusLng], 17);
            data.forEach(function(s) {
                if (Math.abs(s.latitude - focusLat) < 0.0001 && Math.abs(s.longitude - focusLng) < 0.0001) bukaPanel(s);
            });
        }, 300);
    }
    window.startupsData = data;
    window.mapLokasiMain = map;
}

// Fungsi utilitas untuk memformat teks (misal: "DAJA@GMAIL.COM" jadi lowercase)
function sanitizeData(val, mode) {
    if(!val) return '';
    if(mode === 'email' || mode === 'web') return val.toLowerCase();
    if(mode === 'name') return val.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
    return val;
}

window.bukaPanel = function(s) {
    document.getElementById('panel-logo').src = s.logo_perusahaan ? window.baseLogoUrl + s.logo_perusahaan : window.defaultLogo;
    document.getElementById('panel-nama').textContent = s.nama_perusahaan;

    let bgAktif = (s.status_startup && s.status_startup.toLowerCase() === 'aktif') ? '#ecfdf5' : '#fef2f2';
    let colorAktif = (s.status_startup && s.status_startup.toLowerCase() === 'aktif') ? '#059669' : '#dc2626';
    let borderAktif = (s.status_startup && s.status_startup.toLowerCase() === 'aktif') ? '#a7f3d0' : '#fecaca';
    
    let ajuanVal = (s.status_ajuan || '').toLowerCase();
    let bgAjuan = (ajuanVal === 'verified') ? '#eff6ff' : (ajuanVal === 'rejected' ? '#fef2f2' : '#fffbeb');
    let colorAjuan = (ajuanVal === 'verified') ? '#2563eb' : (ajuanVal === 'rejected' ? '#dc2626' : '#d97706');
    let borderAjuan = (ajuanVal === 'verified') ? '#bfdbfe' : (ajuanVal === 'rejected' ? '#fecaca' : '#fde68a');

    document.getElementById('panel-badges').innerHTML =
        `<span class="panel-badge" style="background:${bgAktif}; color:${colorAktif}; border-color:${borderAktif};">${s.status_startup}</span>` +
        `<span class="panel-badge" style="background:${bgAjuan}; color:${colorAjuan}; border-color:${borderAjuan};">${s.status_ajuan}</span>`;

    let contentHtml = '';

    // Tentang Profile
    if(s.deskripsi_bidang_usaha) {
        contentHtml += `
            <div class="panel-section" style="background:transparent; padding:0; border:none; box-shadow:none;">
                <p class="panel-desc" style="font-weight:400;">${s.deskripsi_bidang_usaha}</p>
            </div>
        `;
    }

    // Timeline Grid
    if(s.tahun_berdiri || s.tahun_daftar) {
        contentHtml += `<div class="panel-grid-box mb-3">`;
        if(s.tahun_berdiri) contentHtml += `<div class="grid-box-item"><div class="grid-box-val">${s.tahun_berdiri}</div><div class="grid-box-lbl">Tahun Berdiri</div></div>`;
        if(s.tahun_daftar) contentHtml += `<div class="grid-box-item"><div class="grid-box-val">${s.tahun_daftar}</div><div class="grid-box-lbl">Tahun Daftar</div></div>`;
        contentHtml += `</div>`;
    }

    // Informasi Umum
    contentHtml += `<div class="panel-section">`;
    contentHtml += `<span class="panel-section-title">Informasi Umum</span>`;
    if (s.nama_program) contentHtml += infoRow('graduation-cap', 'Program', sanitizeData(s.nama_program, 'name'));
    if (s.nama_dosen) contentHtml += infoRow('user', 'Pembina', sanitizeData(s.nama_dosen, 'name'));
    if (s.alamat) contentHtml += infoRow('map-pin', 'Alamat', `<span style="text-transform:capitalize;">${s.alamat.toLowerCase()}</span>`);
    contentHtml += `</div>`;

    // Kontak Section
    if(s.email_perusahaan || s.nomor_whatsapp || s.website_perusahaan || s.instagram_perusahaan) {
        contentHtml += `<div class="panel-section">`;
        contentHtml += `<span class="panel-section-title">Kontak & Tautan</span>`;
        
        if (s.email_perusahaan) contentHtml += infoRow('mail', 'Email', `<a href="mailto:${s.email_perusahaan}">${sanitizeData(s.email_perusahaan, 'email')}</a>`);
        if (s.website_perusahaan) contentHtml += infoRow('globe', 'Website', `<a href="${s.website_perusahaan}" target="_blank">${sanitizeData(s.website_perusahaan, 'web')}</a>`);
        
        // Social icons
        let socHtml = `<div class="d-flex gap-2 mt-3 pt-3" style="border-top:1px solid #f1f5f9;">`;
        if (s.nomor_whatsapp) socHtml += `<a href="https://wa.me/${s.nomor_whatsapp}" target="_blank" class="panel-social-link" style="background:#ecfdf5; color:#10b981;"><i class="mdi mdi-whatsapp" style="font-size:18px;"></i></a>`;
        if (s.instagram_perusahaan) socHtml += `<a href="#" class="panel-social-link" style="background:#fdf4ff; color:#d946ef;"><i class="mdi mdi-instagram" style="font-size:18px;"></i></a>`;
        socHtml += `</div>`;
        
        contentHtml += socHtml;
        contentHtml += `</div>`;
    }

    document.getElementById('panel-content-wrapper').innerHTML = contentHtml;
    document.getElementById('panel-link').href = window.baseDetailUrl + s.uuid_startup;
    document.getElementById('panel-detail').classList.add('show');
    
    lucide.createIcons(); // render all lucide icons
    if (window.mapLokasiMain) window.mapLokasiMain.panTo([s.latitude, s.longitude]);
}

window.infoRow = function(icon, label, value) {
    return `
        <div class="panel-info-row">
            <div class="panel-info-icon"><i data-lucide="${icon}" style="width:14px;"></i></div>
            <div class="panel-info-content">
                <div class="panel-info-label">${label}</div>
                <div class="panel-info-value">${value}</div>
            </div>
        </div>
    `;
}

window.tutupPanel = function() {
    var p = document.getElementById('panel-detail');
    if (p) p.classList.remove('show');
}

window.fokusMarker = function(lat, lng) {
    if (window.mapLokasiMain) window.mapLokasiMain.setView([lat, lng], 17);
    var d = document.getElementById('ddTerpetakan');
    if (d) d.style.display = 'none';
    if (window.startupsData) {
        var s = window.startupsData.find(function(d) {
            return Math.abs(d.latitude - lat) < 0.0001 && Math.abs(d.longitude - lng) < 0.0001;
        });
        if (s) window.bukaPanel(s);
    }
}

window.toggleMapDropdown = function(id) {
    var all = ['ddTerpetakan', 'ddBelumLokasi'];
    all.forEach(function(d) {
        if (d !== id) { var el = document.getElementById(d); if (el) el.style.display = 'none'; }
    });
    var el = document.getElementById(id);
    if (el) el.style.display = el.style.display === 'block' ? 'none' : 'block';
}

function initDependenciesLokasi() {
    if (typeof L === 'undefined') {
        if (!document.getElementById('leaflet-css')) {
            document.head.insertAdjacentHTML('beforeend', '<link id="leaflet-css" rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>');
            document.head.insertAdjacentHTML('beforeend', '<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css"/>');
            document.head.insertAdjacentHTML('beforeend', '<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css"/>');
        }
        var s = document.createElement('script');
        s.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        s.onload = function() {
            var sc = document.createElement('script');
            sc.src = 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js';
            sc.onload = startMapLokasi;
            document.head.appendChild(sc);
        };
        document.head.appendChild(s);
    } else if (typeof L.markerClusterGroup === 'undefined') {
        var sc = document.createElement('script');
        sc.src = 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js';
        sc.onload = startMapLokasi;
        document.head.appendChild(sc);
    } else {
        startMapLokasi();
    }
}

initDependenciesLokasi();
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.map-stat-card') && !e.target.closest('.map-dropdown')) {
            ['ddTerpetakan', 'ddBelumLokasi'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
        }
    });

    if (!window.lokasiStartupCleanupBound) {
        document.addEventListener('turbo:before-cache', function() {
            if (window.mapLokasiAll) {
                try { window.mapLokasiAll.remove(); } catch(e) {}
                window.mapLokasiAll = null;
            }
        });
        window.lokasiStartupCleanupBound = true;
    }
</script>
