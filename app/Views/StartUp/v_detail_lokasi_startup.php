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

    /* Panel Detail */
    #panel-detail {
        position: absolute;
        top: 0; left: 0;
        width: 340px; height: 100%;
        background: #fff;
        border-radius: 0;
        box-shadow: 4px 0 24px rgba(0,0,0,0.12);
        z-index: 999;
        overflow-y: auto;
        display: flex; flex-direction: column;
        transform: translateX(-100%);
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #panel-detail.show { transform: translateX(0); }

    .panel-logo {
        width: 100%; height: 150px;
        object-fit: contain;
        background: var(--slate-50);
        border-bottom: 1px solid var(--slate-100);
        padding: 18px 22px;
    }
    .panel-body { padding: 18px 18px 8px; flex: 1; }
    .panel-nama { font-size: 16px; font-weight: 900; color: var(--slate-900); margin-bottom: 6px; line-height: 1.3; text-align: center; }
    .panel-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; justify-content: center; }
    .panel-badge { padding: 3px 10px; border-radius: 20px; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; }
    .badge-aktif    { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .badge-nonaktif { background: rgba(239,68,68,0.1);  color: #dc2626; }
    .badge-pending  { background: rgba(245,158,11,0.1); color: #d97706; }
    .badge-verified { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .badge-rejected { background: rgba(239,68,68,0.1);  color: #dc2626; }
    .panel-divider { height: 1px; background: var(--slate-100); margin: 4px 0 12px; }
    .panel-row { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 10px; font-size: 13px; color: var(--slate-800); line-height: 1.5; }
    .panel-row i { font-size: 18px; color: var(--slate-800); flex-shrink: 0; width: 20px; text-align: center; line-height: 1.5; }
    .panel-row span { word-break: break-word; flex: 1; }
    .panel-row a { color: var(--slate-800); text-decoration: none; font-weight: 600; }
    .panel-row a:hover { text-decoration: underline; }
    .panel-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 8px; }
    .panel-close {
        position: absolute; top: 10px; right: 10px;
        width: 28px; height: 28px;
        background: rgba(0,0,0,0.35); border: none; border-radius: 50%;
        color: #fff; font-size: 14px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        z-index: 10; line-height: 1; transition: background 0.2s;
    }
    .panel-close:hover { background: rgba(0,0,0,0.65); }
    .panel-footer { padding: 12px 18px 16px; border-top: 1px solid var(--slate-100); }
    .panel-btn-detail {
        display: block; text-align: center; background: var(--primary); color: #fff;
        font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.12em;
        padding: 10px; border-radius: 10px; text-decoration: none; transition: background 0.2s;
    }
    .panel-btn-detail:hover { background: var(--primary-hover); color: #fff; }
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
        <button class="panel-close" onclick="tutupPanel()">&#x2715;</button>
        <img id="panel-logo" src="" alt="Logo" class="panel-logo">
        <div class="panel-body">
            <div class="panel-nama" id="panel-nama"></div>
            <div class="panel-badges" id="panel-badges"></div>
            <div class="panel-divider"></div>
            <div id="panel-rows"></div>
        </div>
        <div class="panel-footer">
            <a id="panel-link" href="#" class="panel-btn-detail"><i class="mdi mdi-eye me-1"></i> Lihat Detail Startup</a>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map-lokasi-all').setView([-6.9175, 107.6191], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    var markers = [];
    var data = <?= json_encode(array_values(array_filter($startups, fn($s) => !empty($s->latitude)))) ?>;
    var baseLogoUrl  = '<?= base_url('uploads/file_startup/logo_startup/') ?>';
    var defaultLogo  = '<?= base_url('img/logo-dkst.png') ?>';
    var baseDetailUrl = '<?= base_url('v_detail/') ?>';

    data.forEach(function(s) {
        var m = L.marker([s.latitude, s.longitude]).addTo(map);
        m.on('click', function() { bukaPanel(s); });
        markers.push(m);
    });

    if (markers.length > 0) {
        map.fitBounds(L.featureGroup(markers).getBounds().pad(0.2));
    }

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

    function bukaPanel(s) {
        document.getElementById('panel-logo').src = s.logo_perusahaan ? baseLogoUrl + s.logo_perusahaan : defaultLogo;
        document.getElementById('panel-nama').textContent = s.nama_perusahaan;

        var statusClass = (s.status_startup && s.status_startup.toLowerCase() === 'aktif') ? 'badge-aktif' : 'badge-nonaktif';
        var ajuanMap = { 'pending': 'badge-pending', 'verified': 'badge-verified', 'rejected': 'badge-rejected' };
        var ajuanClass = ajuanMap[(s.status_ajuan || '').toLowerCase()] || 'badge-pending';
        document.getElementById('panel-badges').innerHTML =
            '<span class="panel-badge ' + statusClass + '">' + s.status_startup + '</span>' +
            '<span class="panel-badge ' + ajuanClass + '">' + s.status_ajuan + '</span>';

        var fullRows = '', gridItems = '';
        if (s.alamat)                fullRows += row('mdi-map-marker',       s.alamat);
        if (s.deskripsi_bidang_usaha) fullRows += row('mdi-text-box-outline', s.deskripsi_bidang_usaha);
        if (s.email_perusahaan)      fullRows += row('mdi-email-outline',    '<a href="mailto:' + s.email_perusahaan + '">' + s.email_perusahaan + '</a>');
        if (s.website_perusahaan)    fullRows += row('mdi-web',              '<a href="' + s.website_perusahaan + '" target="_blank">' + s.website_perusahaan + '</a>');
        if (s.nama_program)          fullRows += row('mdi-school-outline',   s.nama_program);
        if (s.nama_dosen)            fullRows += row('mdi-account-tie',      'Pembina: ' + s.nama_dosen);
        if (s.nomor_whatsapp)        gridItems += gridItem('mdi-whatsapp',   '<a href="https://wa.me/' + s.nomor_whatsapp + '" target="_blank">' + s.nomor_whatsapp + '</a>');
        if (s.instagram_perusahaan)  gridItems += gridItem('mdi-instagram',  '@' + s.instagram_perusahaan);
        if (s.tahun_daftar)          gridItems += gridItem('mdi-calendar-check',  'Daftar ' + s.tahun_daftar);
        if (s.tahun_berdiri)         gridItems += gridItem('mdi-office-building', 'Berdiri ' + s.tahun_berdiri);

        document.getElementById('panel-rows').innerHTML = fullRows + (gridItems ? '<div class="panel-grid">' + gridItems + '</div>' : '');
        document.getElementById('panel-link').href = baseDetailUrl + s.uuid_startup;
        document.getElementById('panel-detail').classList.add('show');
        map.panTo([s.latitude, s.longitude]);
    }

    function row(icon, val) {
        return '<div class="panel-row"><i class="mdi ' + icon + '"></i><span>' + val + '</span></div>';
    }
    function gridItem(icon, val) {
        return '<div class="panel-row"><i class="mdi ' + icon + '"></i><span>' + val + '</span></div>';
    }
    function tutupPanel() {
        document.getElementById('panel-detail').classList.remove('show');
    }
    function fokusMarker(lat, lng) {
        map.setView([lat, lng], 17);
        document.getElementById('ddTerpetakan').style.display = 'none';
        var s = data.find(function(d) {
            return Math.abs(d.latitude - lat) < 0.0001 && Math.abs(d.longitude - lng) < 0.0001;
        });
        if (s) bukaPanel(s);
    }
    function toggleMapDropdown(id) {
        var all = ['ddTerpetakan', 'ddBelumLokasi'];
        all.forEach(function(d) {
            if (d !== id) { var el = document.getElementById(d); if (el) el.style.display = 'none'; }
        });
        var el = document.getElementById(id);
        if (el) el.style.display = el.style.display === 'block' ? 'none' : 'block';
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.map-stat-card') && !e.target.closest('.map-dropdown')) {
            ['ddTerpetakan', 'ddBelumLokasi'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
        }
    });
</script>
