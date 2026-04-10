<style>
    /* Fullscreen map — override app-content padding */
    .app-content { padding: 0 !important; background: transparent !important; overflow: hidden !important; }

    #map-fullscreen {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    /* ── Floating Controls ── */
    .map-ctrl {
        position: absolute;
        z-index: 999;
        pointer-events: auto;
    }

    /* Search bar — top center */
    #ctrl-search {
        top: 18px;
        left: 50%;
        transform: translateX(-50%);
        width: 340px;
    }
    #ctrl-search input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--slate-800);
        outline: none;
    }
    #ctrl-search .search-ic {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--slate-400);
        pointer-events: none;
    }
    #search-results {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        margin-top: 6px;
        overflow: hidden;
        display: none;
        max-height: 260px;
        overflow-y: auto;
    }
    #search-results .sr-item {
        padding: 10px 16px;
        font-size: 12px;
        font-weight: 600;
        color: var(--slate-700);
        cursor: pointer;
        border-bottom: 1px solid var(--slate-100);
        transition: background 0.15s;
    }
    #search-results .sr-item:hover { background: var(--slate-50); }
    #search-results .sr-item:last-child { border-bottom: none; }

    /* Stat cards — top left */
    #ctrl-stats {
        top: 18px;
        left: 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        min-width: 190px;
        transition: box-shadow 0.2s;
        position: relative;
    }
    .stat-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.18); }
    .stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue { background: var(--primary-light); }
    .stat-icon.red  { background: rgba(239,68,68,0.08); }
    .stat-icon.blue i { color: var(--primary); font-size: 18px; }
    .stat-icon.red  i { color: #dc2626; font-size: 18px; }
    .stat-num { font-size: 1.4rem; font-weight: 800; line-height: 1; color: var(--slate-900); }
    .stat-lbl { font-size: 10px; font-weight: 700; color: var(--slate-500); }

    /* Dropdown list bawah stat card */
    .stat-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        width: 340px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        z-index: 9999;
        overflow: hidden;
    }
    .stat-dropdown-head {
        padding: 12px 16px;
        background: var(--slate-50);
        border-bottom: 1px solid var(--slate-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-dropdown-head .sdh-title { font-size: 12px; font-weight: 700; color: var(--slate-800); }
    .stat-dropdown-head .sdh-sub   { font-size: 10px; color: var(--slate-500); margin-top: 2px; }
    .stat-dropdown-head .sdh-badge { font-size: 10px; font-weight: 700; padding: 2px 10px; border-radius: 20px; color: #fff; }
    .stat-dropdown-body { max-height: 280px; overflow-y: auto; scrollbar-width: thin; }
    .sd-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 16px; border-bottom: 1px solid var(--slate-100);
        background: #fff; transition: background 0.15s;
    }
    .sd-row:hover { background: var(--slate-50); }
    .sd-row:last-child { border-bottom: none; }
    .sd-name { font-size: 12px; font-weight: 600; color: var(--slate-700); }
    .sd-coords { display: flex; gap: 4px; margin-top: 3px; }
    .sd-coord-tag { font-size: 9px; font-family: monospace; background: var(--slate-100); color: var(--slate-500); padding: 1px 5px; border-radius: 4px; }
    .sd-btn {
        width: 30px; height: 30px; border-radius: 8px; border: 1px solid var(--slate-200);
        background: var(--slate-50); color: var(--primary); display: flex; align-items: center;
        justify-content: center; cursor: pointer; transition: all 0.2s; flex-shrink: 0;
        text-decoration: none;
    }
    .sd-btn:hover { background: var(--primary); color: #fff; }
    .sd-btn.red { color: #dc2626; }
    .sd-btn.red:hover { background: #dc2626; color: #fff; }

    /* Panel Detail — slide dari kiri */
    #panel-detail {
        position: absolute;
        top: 0; left: 0;
        width: 340px;
        height: 100%;
        background: #fff;
        z-index: 998;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        transform: translateX(-100%);
        transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        box-shadow: 4px 0 24px rgba(0,0,0,0.12);
    }
    #panel-detail.show { transform: translateX(0); }

    .panel-logo { width: 100%; height: 150px; object-fit: contain; background: var(--slate-50); border-bottom: 1px solid var(--slate-100); padding: 16px 20px; }
    .panel-body { padding: 16px 18px 8px; flex: 1; }
    .panel-nama { font-size: 16px; font-weight: 900; color: var(--slate-900); margin-bottom: 6px; text-align: center; line-height: 1.3; }
    .panel-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; justify-content: center; }
    .panel-badge { padding: 3px 10px; border-radius: 20px; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; }
    .badge-aktif    { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .badge-nonaktif { background: rgba(239,68,68,0.1);  color: #dc2626; }
    .badge-pending  { background: rgba(245,158,11,0.1); color: #d97706; }
    .badge-verified { background: rgba(34,197,94,0.1);  color: #16a34a; }
    .badge-rejected { background: rgba(239,68,68,0.1);  color: #dc2626; }
    .panel-divider { height: 1px; background: var(--slate-100); margin: 4px 0 12px; }
    .panel-row { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 10px; font-size: 13px; color: var(--slate-800); line-height: 1.5; }
    .panel-row i { font-size: 18px; color: var(--slate-500); flex-shrink: 0; width: 20px; text-align: center; margin-top: 1px; }
    .panel-row span { word-break: break-word; flex: 1; }
    .panel-row a { color: var(--slate-800); text-decoration: none; font-weight: 600; }
    .panel-row a:hover { text-decoration: underline; }
    .panel-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 8px; }
    .panel-close {
        position: absolute; top: 10px; right: 10px;
        width: 28px; height: 28px; background: rgba(0,0,0,0.3);
        border: none; border-radius: 50%; color: #fff; font-size: 13px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        z-index: 10; transition: background 0.2s;
    }
    .panel-close:hover { background: rgba(0,0,0,0.6); }
    .panel-footer { padding: 10px 18px 14px; border-top: 1px solid var(--slate-100); }
    .panel-btn-detail {
        display: block; text-align: center; background: var(--primary); color: #fff;
        font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.12em;
        padding: 10px; border-radius: 10px; text-decoration: none; transition: background 0.2s;
    }
    .panel-btn-detail:hover { background: var(--primary-hover); color: #fff; }
</style>

<div class="app-content" style="position:relative;">
    <div id="map-fullscreen"></div>

    <!-- Search bar -->
    <div class="map-ctrl" id="ctrl-search">
        <div style="position:relative;">
            <svg class="search-ic" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
            <input type="text" id="input-search" placeholder="Cari startup..." autocomplete="off">
        </div>
        <div id="search-results"></div>
    </div>

    <?php if (session()->get('user_role') !== 'pemilik_startup'): ?>
    <!-- Stat cards (admin only) -->
    <div class="map-ctrl" id="ctrl-stats">
        <!-- Terpetakan -->
        <div class="stat-card" onclick="toggleStatDropdown('dd-terpetakan')">
            <div class="stat-icon blue"><i class="mdi mdi-map-marker-multiple"></i></div>
            <div>
                <div class="stat-num"><?= count(array_filter($startups, fn($s) => !empty($s->latitude))) ?></div>
                <div class="stat-lbl">Startup Terpetakan</div>
            </div>
            <div class="stat-dropdown" id="dd-terpetakan">
                <div class="stat-dropdown-head">
                    <div>
                        <div class="sdh-title">Startup Terpetakan</div>
                        <div class="sdh-sub">Lokasi sudah ditentukan</div>
                    </div>
                    <span class="sdh-badge" style="background:var(--primary);"><?= count(array_filter($startups, fn($s) => !empty($s->latitude))) ?></span>
                </div>
                <div class="stat-dropdown-body">
                    <?php $mapped = array_filter($startups, fn($s) => !empty($s->latitude));
                    if (empty($mapped)): ?>
                        <div style="padding:30px;text-align:center;color:var(--slate-400);font-size:12px;">Tidak ada data</div>
                    <?php else: foreach ($mapped as $s): ?>
                    <div class="sd-row">
                        <div style="flex:1;padding-right:10px;">
                            <div class="sd-name"><?= esc($s->nama_perusahaan) ?></div>
                            <div class="sd-coords">
                                <span class="sd-coord-tag">LAT: <?= number_format($s->latitude, 3) ?></span>
                                <span class="sd-coord-tag">LON: <?= number_format($s->longitude, 3) ?></span>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="sd-btn" onclick="fokusMarker(<?= $s->latitude ?>, <?= $s->longitude ?>)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </a>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>

        <!-- Belum Lokasi -->
        <div class="stat-card" onclick="toggleStatDropdown('dd-belum')">
            <div class="stat-icon red"><i class="mdi mdi-map-marker-off"></i></div>
            <div>
                <div class="stat-num"><?= count(array_filter($startups, fn($s) => empty($s->latitude))) ?></div>
                <div class="stat-lbl">Belum Ada Lokasi</div>
            </div>
            <div class="stat-dropdown" id="dd-belum">
                <div class="stat-dropdown-head">
                    <div>
                        <div class="sdh-title">Belum Ada Lokasi</div>
                        <div class="sdh-sub">Startup belum ditentukan lokasinya</div>
                    </div>
                    <span class="sdh-badge" style="background:#dc2626;"><?= count(array_filter($startups, fn($s) => empty($s->latitude))) ?></span>
                </div>
                <div class="stat-dropdown-body">
                    <?php $unmapped = array_filter($startups, fn($s) => empty($s->latitude));
                    if (empty($unmapped)): ?>
                        <div style="padding:30px;text-align:center;color:var(--slate-400);font-size:12px;">Semua startup sudah memiliki lokasi</div>
                    <?php else: foreach ($unmapped as $s): ?>
                    <div class="sd-row">
                        <div style="flex:1;padding-right:10px;">
                            <div class="sd-name"><?= esc($s->nama_perusahaan) ?></div>
                            <div class="sd-coords">
                                <span class="sd-coord-tag" style="background:rgba(239,68,68,0.08);color:#dc2626;">Lokasi belum diisi</span>
                            </div>
                        </div>
                        <a href="<?= base_url('v_edit_startup/' . $s->uuid_startup) ?>" class="sd-btn red">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var map = L.map('map-fullscreen', { zoomControl: false }).setView([-6.9175, 107.6191], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // Zoom control di kanan bawah
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    var data        = <?= json_encode(array_values(array_filter($startups, fn($s) => !empty($s->latitude)))) ?>;
    var allData     = <?= json_encode(array_values($startups)) ?>;
    var baseLogoUrl = '<?= base_url('uploads/file_startup/logo_startup/') ?>';
    var defaultLogo = '<?= base_url('img/logo-dkst.png') ?>';
    var baseDetailUrl = '<?= base_url('v_detail/') ?>';

    var markers = [];
    data.forEach(function(s) {
        var m = L.marker([s.latitude, s.longitude]).addTo(map);
        m.on('click', function() { bukaPanel(s); });
        markers.push(m);
    });

    if (markers.length > 0) {
        map.fitBounds(L.featureGroup(markers).getBounds().pad(0.2));
    }

    // Focus dari URL param
    var urlParams = new URLSearchParams(window.location.search);
    var fLat = parseFloat(urlParams.get('lat'));
    var fLng = parseFloat(urlParams.get('lng'));
    if (fLat && fLng) {
        setTimeout(function() {
            map.setView([fLat, fLng], 17);
            data.forEach(function(s) {
                if (Math.abs(s.latitude - fLat) < 0.0001 && Math.abs(s.longitude - fLng) < 0.0001) bukaPanel(s);
            });
        }, 300);
    }

    function bukaPanel(s) {
        document.getElementById('panel-logo').src = s.logo_perusahaan ? baseLogoUrl + s.logo_perusahaan : defaultLogo;
        document.getElementById('panel-nama').textContent = s.nama_perusahaan;

        var statusClass = (s.status_startup && s.status_startup.toLowerCase() === 'aktif') ? 'badge-aktif' : 'badge-nonaktif';
        var ajuanMap = { pending: 'badge-pending', verified: 'badge-verified', rejected: 'badge-rejected' };
        var ajuanClass = ajuanMap[(s.status_ajuan || '').toLowerCase()] || 'badge-pending';
        document.getElementById('panel-badges').innerHTML =
            '<span class="panel-badge ' + statusClass + '">' + s.status_startup + '</span>' +
            '<span class="panel-badge ' + ajuanClass + '">' + s.status_ajuan + '</span>';

        var fullRows = '', gridItems = '';
        if (s.alamat)                fullRows += row('mdi-map-marker', s.alamat);
        if (s.deskripsi_bidang_usaha) fullRows += row('mdi-text-box-outline', s.deskripsi_bidang_usaha);
        if (s.email_perusahaan)      fullRows += row('mdi-email-outline', '<a href="mailto:' + s.email_perusahaan + '">' + s.email_perusahaan + '</a>');
        if (s.website_perusahaan)    fullRows += row('mdi-web', '<a href="' + s.website_perusahaan + '" target="_blank">' + s.website_perusahaan + '</a>');
        if (s.nama_program)          fullRows += row('mdi-school-outline', s.nama_program);
        if (s.nama_dosen)            fullRows += row('mdi-account-tie', 'Pembina: ' + s.nama_dosen);
        if (s.nomor_whatsapp)        gridItems += row('mdi-whatsapp', '<a href="https://wa.me/' + s.nomor_whatsapp + '" target="_blank">' + s.nomor_whatsapp + '</a>');
        if (s.instagram_perusahaan)  gridItems += row('mdi-instagram', '@' + s.instagram_perusahaan);
        if (s.tahun_daftar)          gridItems += row('mdi-calendar-check', 'Daftar ' + s.tahun_daftar);
        if (s.tahun_berdiri)         gridItems += row('mdi-office-building', 'Berdiri ' + s.tahun_berdiri);

        document.getElementById('panel-rows').innerHTML = fullRows + (gridItems ? '<div class="panel-grid">' + gridItems + '</div>' : '');
        document.getElementById('panel-link').href = baseDetailUrl + s.uuid_startup;
        document.getElementById('panel-detail').classList.add('show');
        map.panTo([s.latitude, s.longitude]);
    }

    function row(icon, val) {
        return '<div class="panel-row"><i class="mdi ' + icon + '"></i><span>' + val + '</span></div>';
    }

    function tutupPanel() {
        document.getElementById('panel-detail').classList.remove('show');
    }

    function fokusMarker(lat, lng) {
        map.setView([lat, lng], 17);
        document.querySelectorAll('.stat-dropdown').forEach(function(d) { d.style.display = 'none'; });
        var s = data.find(function(d) { return Math.abs(d.latitude - lat) < 0.0001 && Math.abs(d.longitude - lng) < 0.0001; });
        if (s) bukaPanel(s);
    }

    function toggleStatDropdown(id) {
        document.querySelectorAll('.stat-dropdown').forEach(function(d) {
            if (d.id !== id) d.style.display = 'none';
        });
        var el = document.getElementById(id);
        el.style.display = el.style.display === 'block' ? 'none' : 'block';
    }

    // Search
    var inputSearch = document.getElementById('input-search');
    var searchResults = document.getElementById('search-results');
    inputSearch.addEventListener('input', function() {
        var q = this.value.trim().toLowerCase();
        if (!q) { searchResults.style.display = 'none'; return; }
        var filtered = allData.filter(function(s) {
            return s.nama_perusahaan.toLowerCase().includes(q);
        });
        if (!filtered.length) { searchResults.style.display = 'none'; return; }
        searchResults.innerHTML = filtered.slice(0, 8).map(function(s) {
            return '<div class="sr-item" onclick="pilihSearch(' + (s.latitude || 0) + ',' + (s.longitude || 0) + ',\'' + s.uuid_startup + '\')">' +
                '<strong>' + s.nama_perusahaan + '</strong>' +
                (s.alamat ? '<div style="font-size:11px;color:var(--slate-400);margin-top:2px;">' + s.alamat + '</div>' : '') +
                '</div>';
        }).join('');
        searchResults.style.display = 'block';
    });

    function pilihSearch(lat, lng, uuid) {
        searchResults.style.display = 'none';
        inputSearch.value = '';
        if (lat && lng) {
            map.setView([lat, lng], 17);
            var s = data.find(function(d) { return Math.abs(d.latitude - lat) < 0.0001 && Math.abs(d.longitude - lng) < 0.0001; });
            if (s) bukaPanel(s);
        }
    }

    // Tutup dropdown & search saat klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#ctrl-stats')) {
            document.querySelectorAll('.stat-dropdown').forEach(function(d) { d.style.display = 'none'; });
        }
        if (!e.target.closest('#ctrl-search')) {
            searchResults.style.display = 'none';
        }
    });
</script>
