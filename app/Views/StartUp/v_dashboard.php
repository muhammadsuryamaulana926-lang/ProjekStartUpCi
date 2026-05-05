<style>
body { background-color: #f5f5f5 !important; }
.paper-card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 24px;
}
.stat-card {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px 24px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 20px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    color: inherit;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0,0,0,0.08); border-color: #0d6efd; }
.stat-icon { width: 56px; height: 56px; background: #e7f1ff; color: #0d6efd; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 24px; }
.stat-label { font-size: 12px; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }
.stat-value { font-size: 32px; font-weight: 700; color: #212529; line-height: 1; }
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
#modalDetailStartup div.dataTables_wrapper div.dataTables_filter,
#modalDetailStartup div.dataTables_wrapper div.dataTables_length,
#modalDetailProgram div.dataTables_wrapper div.dataTables_filter,
#modalDetailProgram div.dataTables_wrapper div.dataTables_length,
#modalDetailBuku div.dataTables_wrapper div.dataTables_filter,
#modalDetailBuku div.dataTables_wrapper div.dataTables_length,
#modalDetailVideo div.dataTables_wrapper div.dataTables_filter,
#modalDetailVideo div.dataTables_wrapper div.dataTables_length { margin-bottom: 12px; }
#modalDetailStartup div.dataTables_wrapper div.dataTables_info,
#modalDetailStartup div.dataTables_wrapper div.dataTables_paginate,
#modalDetailProgram div.dataTables_wrapper div.dataTables_info,
#modalDetailProgram div.dataTables_wrapper div.dataTables_paginate,
#modalDetailBuku div.dataTables_wrapper div.dataTables_info,
#modalDetailBuku div.dataTables_wrapper div.dataTables_paginate,
#modalDetailVideo div.dataTables_wrapper div.dataTables_info,
#modalDetailVideo div.dataTables_wrapper div.dataTables_paginate { margin-top: 12px; }
#modalDetailStartup div.dataTables_wrapper,
#modalDetailProgram div.dataTables_wrapper,
#modalDetailBuku div.dataTables_wrapper,
#modalDetailVideo div.dataTables_wrapper { padding: 0 4px; }
</style>

<div class="container-fluid py-4" style="background-color:#f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-11">

            <!-- Stat Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card" data-bs-toggle="modal" data-bs-target="#modalDetailStartup">
                        <div class="stat-icon"><i class="mdi mdi-rocket-launch"></i></div>
                        <div class="ms-auto text-end">
                            <div class="stat-value"><?= $total_startup ?></div>
                            <div class="stat-label">Startup Terdaftar</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card" data-bs-toggle="modal" data-bs-target="#modalDetailProgram">
                        <div class="stat-icon" style="background:#e8f5e9; color:#22c55e;"><i class="mdi mdi-book-open-page-variant"></i></div>
                        <div class="ms-auto text-end">
                            <div class="stat-value"><?= $total_program ?></div>
                            <div class="stat-label">Total Program</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card" data-bs-toggle="modal" data-bs-target="#modalDetailBuku">
                        <div class="stat-icon" style="background:#fff3e0; color:#f97316;"><i class="mdi mdi-book"></i></div>
                        <div class="ms-auto text-end">
                            <div class="stat-value"><?= $total_buku ?></div>
                            <div class="stat-label">Total Buku Digital</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card" data-bs-toggle="modal" data-bs-target="#modalDetailVideo">
                        <div class="stat-icon" style="background:#fce4ec; color:#ef4444;"><i class="mdi mdi-video"></i></div>
                        <div class="ms-auto text-end">
                            <div class="stat-value"><?= $total_video ?></div>
                            <div class="stat-label">Total Video</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="card border">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <h6 class="fw-bold m-0">Startup Terdaftar per Tahun</h6>
                            <div class="d-flex align-items-center gap-1">
                                <input type="text" id="start_year" class="form-control form-control-sm yearpicker-dash" style="width:72px;text-align:center;" value="<?= date('Y') - 4 ?>" readonly>
                                <span class="text-muted">—</span>
                                <input type="text" id="end_year" class="form-control form-control-sm yearpicker-dash" style="width:72px;text-align:center;" value="<?= date('Y') ?>" readonly>
                            </div>
                        </div>
                        <div class="card-body">
                        <div style="height:300px;"><canvas id="chart_per_tahun"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <h6 class="fw-bold m-0">Startup Terdaftar per Bulan</h6>
                            <input type="text" id="year_bulan" class="form-control form-control-sm yearpicker-dash" style="width:80px;text-align:center;" value="<?= date('Y') ?>" readonly>
                        </div>
                        <div class="card-body">
                        <div style="height:300px;"><canvas id="chart_per_bulan"></canvas></div>
                        </div>
                    </div>
                </div>

                <!-- Chart Top Video & Tren Penonton -->
                <div class="col-lg-6">
                    <div class="card border">
                        <div class="card-header bg-white py-3">
                            <h6 class="fw-bold m-0">Top 10 Video Terbanyak Ditonton</h6>
                        </div>
                        <div class="card-body">
                            <div style="height:300px;"><canvas id="chart_top_video"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <h6 class="fw-bold m-0" id="tren_title">Tren Penonton Video per Bulan</h6>
                            <div class="d-flex align-items-center gap-2">
                                <select id="tren_mode_select" class="form-select form-select-sm" style="width:90px;">
                                    <option value="bulan">Bulan</option>
                                    <option value="minggu">Minggu</option>
                                    <option value="tahun">Tahun</option>
                                </select>
                                <input type="text" id="year_tren" class="form-control form-control-sm yearpicker-dash" style="width:80px;text-align:center;" value="<?= date('Y') ?>" readonly>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height:300px;"><canvas id="chart_tren_penonton"></canvas></div>
                        </div>
                    </div>
                </div>

                <!-- Chart Top Ebook & Tren Pembaca -->
                <div class="col-lg-6">
                    <div class="card border">
                        <div class="card-header bg-white py-3">
                            <h6 class="fw-bold m-0">Top 10 Ebook Terbanyak Dibaca</h6>
                        </div>
                        <div class="card-body">
                            <div style="height:300px;"><canvas id="chart_top_ebook"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <h6 class="fw-bold m-0" id="tren_ebook_title">Tren Pembaca Ebook per Bulan</h6>
                            <div class="d-flex align-items-center gap-2">
                                <select id="tren_ebook_mode_select" class="form-select form-select-sm" style="width:90px;">
                                    <option value="bulan">Bulan</option>
                                    <option value="minggu">Minggu</option>
                                    <option value="tahun">Tahun</option>
                                </select>
                                <input type="text" id="year_tren_ebook" class="form-control form-control-sm yearpicker-dash" style="width:80px;text-align:center;" value="<?= date('Y') ?>" readonly>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height:300px;"><canvas id="chart_tren_pembaca_ebook"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Detail Startup -->
<div class="modal fade" id="modalDetailStartup" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Daftar Startup Terdaftar</h5>
                    <small class="text-muted">Total <?= $total_startup ?> startup terdaftar di sistem</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="table-responsive">
                    <table id="datatable-startup" class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width:50px;">No</th>
                                <th>Nama Perusahaan</th>
                                <th>Email</th>
                                <th>No WhatsApp</th>
                                <th class="text-center">Tahun Daftar</th>
                                <th class="text-center">Status Startup</th>
                                <th class="text-center">Status Ajuan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Program -->
<div class="modal fade" id="modalDetailProgram" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Daftar Program</h5>
                    <small class="text-muted">Total <?= $total_program ?> program terdaftar</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <table id="dt-program" class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>No</th><th>Nama Program</th><th>Deskripsi</th><th>Dibuat</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Buku -->
<div class="modal fade" id="modalDetailBuku" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Daftar Buku Digital</h5>
                    <small class="text-muted">Total <?= $total_buku ?> buku</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <table id="dt-buku" class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>No</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Dibuat</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Video -->
<div class="modal fade" id="modalDetailVideo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Daftar Video</h5>
                    <small class="text-muted">Total <?= $total_video ?> video</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <table id="dt-video" class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>No</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Dibuat</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function initDependenciesDashboard() {
    if (typeof Chart === 'undefined' || typeof $.fn.DataTable === 'undefined' || typeof $.fn.datepicker === 'undefined') {
        if (!document.getElementById('dt-css')) {
            document.head.insertAdjacentHTML('beforeend', '<link id="dt-css" rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">');
            document.head.insertAdjacentHTML('beforeend', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">');
        }
        var s1 = document.createElement('script'); s1.src = 'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js';
        var s2 = document.createElement('script'); s2.src = 'https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js';
        var s3 = document.createElement('script'); s3.src = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js';
        var s4 = document.createElement('script'); s4.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        
        s1.onload = function() { document.head.appendChild(s2); };
        s2.onload = function() { document.head.appendChild(s3); };
        s3.onload = function() { document.head.appendChild(s4); };
        s4.onload = initDashboard;
        
        document.head.appendChild(s1);
    } else {
        initDashboard();
    }
}
// Lindungi dari duplikasi listener

function initDashboard() {
    // CountUp animation untuk stat cards
    document.querySelectorAll('.stat-value').forEach(function(el) {
        var target = parseInt(el.textContent) || 0;
        var start = 0, duration = 1000, step = 16;
        var increment = target / (duration / step);
        el.textContent = '0';
        var timer = setInterval(function() {
            start += increment;
            if (start >= target) { el.textContent = target; clearInterval(timer); }
            else { el.textContent = Math.floor(start); }
        }, step);
    });
    // 1. CHART INITIALIZATION (Memori Leak Fix)
    // Gunakan window.* agar bisa diakses dan dihancurkan sebelum dirender ulang
    window.chartTahun = window.chartTahun || null;
    window.chartBulan = window.chartBulan || null;
    window.chartTopVideo = window.chartTopVideo || null;
    window.chartTrenPenonton = window.chartTrenPenonton || null;
    window.chartTopEbook = window.chartTopEbook || null;
    window.chartTrenPembacaEbook = window.chartTrenPembacaEbook || null;
    
    var bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    var trenMode = $('#tren_mode_select').val() || 'bulan';
    var trenEbookMode = $('#tren_ebook_mode_select').val() || 'bulan';

    function loadChartTahun() {
        var start = $('#start_year').val();
        var end   = $('#end_year').val();
        if (start && end && parseInt(start) > parseInt(end)) return;
        if (!$('#chart_per_tahun').length) return;
        
        $.get('<?= base_url('v_dashboard/chart_per_tahun') ?>', { start_year: start, end_year: end }, function(data) {
            if (typeof data === 'string') { try { data = JSON.parse(data); } catch(e) { return; } }
            setTimeout(function() {
                if (!$('#chart_per_tahun').length) return;
                var labels = data.map(d => d.tahun);
                var values = data.map(d => parseInt(d.total));
                if (window.chartTahun) window.chartTahun.destroy();
                var ctx = document.getElementById('chart_per_tahun');
                if (ctx) {
                    window.chartTahun = new Chart(ctx, {
                        type: 'bar',
                        data: { labels: labels, datasets: [{ label: 'Startup', data: values, backgroundColor: 'rgba(13,110,253,0.7)', borderRadius: 6, borderSkipped: false }] },
                        options: { animation: { duration: 800, easing: 'easeOutQuart' }, responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
                    });
                }
            }, 50);
        });
    }

    function loadChartBulan() {
        var tahun = $('#year_bulan').val();
        if (!$('#chart_per_bulan').length) return;
        $.get('<?= base_url('v_dashboard/chart_per_bulan') ?>', { tahun: tahun }, function(data) {
            if (typeof data === 'string') { try { data = JSON.parse(data); } catch(e) { return; } }
            setTimeout(function() {
                if (!$('#chart_per_bulan').length) return;
                var values = Array(12).fill(0);
                data.forEach(d => { values[parseInt(d.bulan) - 1] = parseInt(d.total); });
                if (window.chartBulan) window.chartBulan.destroy();
                var ctx = document.getElementById('chart_per_bulan');
                if (ctx) {
                    window.chartBulan = new Chart(ctx, {
                        type: 'doughnut',
                        data: { labels: bulanLabel, datasets: [{ data: values, backgroundColor: [
                            'rgba(13,110,253,0.8)','rgba(102,16,242,0.8)','rgba(13,202,240,0.8)',
                            'rgba(25,135,84,0.8)','rgba(255,193,7,0.8)','rgba(220,53,69,0.8)',
                            'rgba(214,51,132,0.8)','rgba(32,201,151,0.8)','rgba(111,66,193,0.8)',
                            'rgba(20,108,67,0.8)','rgba(253,126,20,0.8)','rgba(108,117,125,0.8)'
                        ], borderWidth: 2, borderColor: '#fff' }] },
                        options: { animation: { duration: 900, easing: 'easeOutQuart' }, responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 10 } } }, cutout: '60%' }
                    });
                }
            }, 50);
        });
    }

    function loadChartTopVideo() {
        if (!$('#chart_top_video').length) return;
        $.get('<?= base_url('v_dashboard/chart_top_video') ?>', function(data) {
            if (typeof data === 'string') { try { data = JSON.parse(data); } catch(e) { return; } }
            setTimeout(function() {
                if (!$('#chart_top_video').length) return;
                var labels = data.map(d => d.judul_video.length > 25 ? d.judul_video.substring(0, 25) + '...' : d.judul_video);
                var values = data.map(d => parseInt(d.jumlah_ditonton));
                if (window.chartTopVideo) window.chartTopVideo.destroy();
                var ctx = document.getElementById('chart_top_video');
                if (ctx) {
                    window.chartTopVideo = new Chart(ctx, {
                        type: 'bar',
                        data: { labels: labels, datasets: [{ label: 'Ditonton', data: values, backgroundColor: 'rgba(239,68,68,0.7)', borderRadius: 6, borderSkipped: false }] },
                        options: {
                            animation: { duration: 800, easing: 'easeOutQuart' },
                            indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { beginAtZero: true, min: 0, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#f1f5f9' } },
                                y: { grid: { display: false } }
                            }
                        }
                    });
                }
            }, 50);
        });
    }

    function loadChartTrenPenonton() {
        var tahun = $('#year_tren').val();
        var titles = { bulan: 'Tren Penonton Video per Bulan', minggu: 'Tren Penonton Video per Minggu', tahun: 'Tren Penonton Video per Tahun' };
        $('#tren_title').text(titles[trenMode]);
        $('#year_tren').toggle(trenMode !== 'tahun');

        if (!$('#chart_tren_penonton').length) return;
        $.get('<?= base_url('v_dashboard/chart_tren_penonton') ?>', { tahun: tahun, mode: trenMode }, function(data) {
            if (typeof data === 'string') { try { data = JSON.parse(data); } catch(e) { return; } }
            setTimeout(function() {
                if (!$('#chart_tren_penonton').length) return;
                var labels, values;
                if (trenMode === 'bulan') {
                    labels = bulanLabel;
                    values = Array(12).fill(0);
                    data.forEach(d => { values[parseInt(d.periode) - 1] = parseInt(d.total); });
                } else if (trenMode === 'minggu') {
                    labels = data.map(d => 'Minggu ' + d.periode);
                    values = data.map(d => parseInt(d.total));
                } else {
                    labels = data.map(d => d.periode);
                    values = data.map(d => parseInt(d.total));
                }
                if (window.chartTrenPenonton) window.chartTrenPenonton.destroy();
                var ctx = document.getElementById('chart_tren_penonton');
                if (ctx) {
                    window.chartTrenPenonton = new Chart(ctx, {
                        type: 'line',
                        data: { labels: labels, datasets: [{ label: 'Penonton', data: values, borderColor: 'rgba(13,110,253,0.9)', backgroundColor: 'rgba(13,110,253,0.1)', borderWidth: 2, pointRadius: 4, pointBackgroundColor: 'rgba(13,110,253,0.9)', fill: true, tension: 0.4 }] },
                        options: { animation: { duration: 800, easing: 'easeOutQuart' }, responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
                    });
                }
            }, 50);
        });
    }

    function loadChartTopEbook() {
        if (!$('#chart_top_ebook').length) return;
        $.get('<?= base_url('v_dashboard/chart_top_ebook') ?>', function(data) {
            if (typeof data === 'string') { try { data = JSON.parse(data); } catch(e) { return; } }
            setTimeout(function() {
                if (!$('#chart_top_ebook').length) return;
                var labels = data.map(d => d.judul_ebook.length > 25 ? d.judul_ebook.substring(0, 25) + '...' : d.judul_ebook);
                var values = data.map(d => parseInt(d.jumlah_dibaca || 0));
                if (window.chartTopEbook) window.chartTopEbook.destroy();
                var ctx = document.getElementById('chart_top_ebook');
                if (ctx) {
                    window.chartTopEbook = new Chart(ctx, {
                        type: 'bar',
                        data: { labels: labels, datasets: [{ label: 'Dibaca', data: values, backgroundColor: 'rgba(139,115,85,0.7)', borderRadius: 6, borderSkipped: false }] },
                        options: {
                            animation: { duration: 800, easing: 'easeOutQuart' },
                            indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { beginAtZero: true, min: 0, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#f1f5f9' } },
                                y: { grid: { display: false } }
                            }
                        }
                    });
                }
            }, 50);
        });
    }

    function loadChartTrenPembacaEbook() {
        var tahun = $('#year_tren_ebook').val();
        var titles = { bulan: 'Tren Pembaca Ebook per Bulan', minggu: 'Tren Pembaca Ebook per Minggu', tahun: 'Tren Pembaca Ebook per Tahun' };
        $('#tren_ebook_title').text(titles[trenEbookMode]);
        $('#year_tren_ebook').toggle(trenEbookMode !== 'tahun');

        if (!$('#chart_tren_pembaca_ebook').length) return;
        $.get('<?= base_url('v_dashboard/chart_tren_pembaca_ebook') ?>', { tahun: tahun, mode: trenEbookMode }, function(data) {
            if (typeof data === 'string') { try { data = JSON.parse(data); } catch(e) { return; } }
            setTimeout(function() {
                if (!$('#chart_tren_pembaca_ebook').length) return;
                var labels, values;
                if (trenEbookMode === 'bulan') {
                    labels = bulanLabel;
                    values = Array(12).fill(0);
                    data.forEach(d => { values[parseInt(d.periode) - 1] = parseInt(d.total); });
                } else if (trenEbookMode === 'minggu') {
                    labels = data.map(d => 'Minggu ' + d.periode);
                    values = data.map(d => parseInt(d.total));
                } else {
                    labels = data.map(d => d.periode);
                    values = data.map(d => parseInt(d.total));
                }
                if (window.chartTrenPembacaEbook) window.chartTrenPembacaEbook.destroy();
                var ctx = document.getElementById('chart_tren_pembaca_ebook');
                if (ctx) {
                    window.chartTrenPembacaEbook = new Chart(ctx, {
                        type: 'line',
                        data: { labels: labels, datasets: [{ label: 'Pembaca', data: values, borderColor: 'rgba(139,115,85,0.9)', backgroundColor: 'rgba(139,115,85,0.1)', borderWidth: 2, pointRadius: 4, pointBackgroundColor: 'rgba(139,115,85,0.9)', fill: true, tension: 0.4 }] },
                        options: { animation: { duration: 800, easing: 'easeOutQuart' }, responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
                    });
                }
            }, 50);
        });
    }

    // Panggil saat inisialisasi
    loadChartTahun();
    loadChartBulan();
    loadChartTopVideo();
    loadChartTrenPenonton();
    loadChartTopEbook();
    loadChartTrenPembacaEbook();

    // 2. EVENT BINDING UNTUK FORMS & DATEPICKER
    // Harus hancurkan dulu instance lama kalau ada (untuk keamanan SPA)
    $('.yearpicker-dash').datepicker('destroy').datepicker({ format: 'yyyy', viewMode: 'years', minViewMode: 'years', autoclose: true });

    $('#start_year, #end_year').off('changeDate').on('changeDate', loadChartTahun);
    $('#year_bulan').off('changeDate').on('changeDate', loadChartBulan);
    $('#year_tren').off('changeDate').on('changeDate', loadChartTrenPenonton);
    $('#year_tren_ebook').off('changeDate').on('changeDate', loadChartTrenPembacaEbook);

    $('#tren_mode_select').off('change').on('change', function() { trenMode = $(this).val(); loadChartTrenPenonton(); });
    $('#tren_ebook_mode_select').off('change').on('change', function() { trenEbookMode = $(this).val(); loadChartTrenPembacaEbook(); });

    // 3. DATATABLES FIX (Hapus pengecekan isDataTable yang menyesatkan di Turbo)
    var dtOptions = {
        pageLength: 10,
        ordering: false,
        destroy: true, // Wajib di SPA
        autoWidth: false,
        dom: '<"d-flex align-items-center justify-content-between px-3 py-2"l>rt<"d-flex align-items-center justify-content-between px-3 py-2"ip>',
        language: {
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: { previous: 'Previous', next: 'Next' }
        }
    };

    var tableStartup = $('#datatable-startup').DataTable($.extend({}, dtOptions, {
        columns: [
            { data: null, className: 'text-center', render: function(d, t, r, meta) { return meta.row + 1; } },
            { data: 'nama_perusahaan' },
            { data: 'email_perusahaan' },
            { data: 'nomor_whatsapp' },
            { data: 'tahun_daftar', className: 'text-center' },
            { data: 'status_startup', className: 'text-center', render: function(d) {
                var cls = d && d.toLowerCase() === 'aktif' ? 'bg-success' : 'bg-secondary';
                return '<span class="badge ' + cls + '">' + d + '</span>';
            }},
            { data: 'status_ajuan', className: 'text-center', render: function(d) {
                var map = { 'disetujui': 'bg-success', 'ditolak': 'bg-danger', 'pending': 'bg-warning text-dark' };
                var cls = map[(d || '').toLowerCase()] || 'bg-secondary';
                return '<span class="badge ' + cls + '">' + (d || '-') + '</span>';
            }}
        ]
    }));

    $('#modalDetailStartup').off('shown.bs.modal').on('shown.bs.modal', function() {
        tableStartup.clear().draw();
        $.ajax({
            url: "<?= base_url('v_dashboard/get_data_startup') ?>",
            type: "POST", dataType: "JSON",
            data: { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' },
            success: function(response) { if (response && response.length > 0) tableStartup.rows.add(response).draw(); },
            error: function() { alert('Gagal mengambil data dari server.'); }
        });
    });

    $('#modalDetailProgram').off('shown.bs.modal').on('shown.bs.modal', function() {
        $.get('<?= base_url('v_dashboard/get_data_program') ?>', function(res) {
            $('#dt-program').DataTable($.extend({}, dtOptions, {
                data: typeof res === 'string' ? JSON.parse(res) : res,
                columns: [
                    { data: null, render: (d,t,r,m) => m.row+1 },
                    { data: 'nama_program' },
                    { data: 'deskripsi', render: d => d ? d.substring(0,60)+'...' : '-' },
                    { data: 'dibuat_pada', render: d => d ? d.substring(0,10) : '-' }
                ]
            }));
        });
    });

    $('#modalDetailBuku').off('shown.bs.modal').on('shown.bs.modal', function() {
        $.get('<?= base_url('v_dashboard/get_data_buku') ?>', function(res) {
            $('#dt-buku').DataTable($.extend({}, dtOptions, {
                data: typeof res === 'string' ? JSON.parse(res) : res,
                columns: [
                    { data: null, render: (d,t,r,m) => m.row+1 },
                    { data: 'judul_ebook' },
                    { data: 'kategori_ebook', render: d => d || '-' },
                    { data: 'status_ebook', render: d => '<span class="badge '+(d==='Publik'?'bg-success':'bg-secondary')+'">'+d+'</span>' },
                    { data: 'created_at', render: d => d ? d.substring(0,10) : '-' }
                ]
            }));
        });
    });

    $('#modalDetailVideo').off('shown.bs.modal').on('shown.bs.modal', function() {
        $.get('<?= base_url('v_dashboard/get_data_video') ?>', function(res) {
            $('#dt-video').DataTable($.extend({}, dtOptions, {
                data: typeof res === 'string' ? JSON.parse(res) : res,
                columns: [
                    { data: null, render: (d,t,r,m) => m.row+1 },
                    { data: 'judul_video' },
                    { data: 'kategori_video', render: d => d || '-' },
                    { data: 'status_video', render: d => '<span class="badge '+(d==='Publik'?'bg-success':'bg-secondary')+'">'+d+'</span>' },
                    { data: 'created_at', render: d => d ? d.substring(0,10) : '-' }
                ]
            }));
        });
    });
}

// Jalankan saat DOM siap
$(document).ready(function() {
    initDependenciesDashboard();
});
</script>
