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
#kalender { min-height: 500px; }
.fc-event { cursor: pointer; font-size: 11px; }
.table-paper th { background-color: #f8f9fa; font-weight: 600; border-bottom: 2px solid #dee2e6; }
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }

/* Hari ini warna abu */
.fc .fc-day-today { background: #f1f5f9 !important; }
.fc .fc-day-today .fc-daygrid-day-number { 
    background: #94a3b8 !important; 
    color: #fff !important;
    border-radius: 50%;
    width: 24px; height: 24px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
}
/* Kotak hari lebih compact */
.fc .fc-daygrid-day { min-height: 60px !important; }
.fc .fc-daygrid-day-frame { min-height: 60px !important; padding: 2px !important; }
.fc .fc-daygrid-day-number { font-size: 12px; padding: 2px 4px; }
.fc .fc-col-header-cell-cushion { font-size: 12px; padding: 4px; }
/* Event text italic */
.fc-event-title { font-style: italic; }
/* Header toolbar select style */
.fc .fc-button { font-size: 12px; padding: 4px 10px; }
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-11">

            <!-- Kalender -->
            <div class="paper-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="m-0 font-weight-bold text-dark">Kalender Jadwal Kelas</h4>
                    <div class="d-flex flex-column align-items-end gap-2">
                        <div class="d-flex gap-2">
                            <span class="badge" style="background:#3b82f6;">Aktif</span>
                            <span class="badge" style="background:#22c55e;">Selesai</span>
                            <span class="badge" style="background:#ef4444;">Dibatalkan</span>
                        </div>
                        <div id="kalender-view-wrap"></div>
                    </div>
                </div>
                <div id="kalender"></div>
            </div>

            <!-- Tabel Semua Jadwal -->
            <div class="paper-card">
                <h5 class="font-weight-bold text-dark mb-4">Semua Jadwal Kelas</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-paper align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kelas</th>
                                <th>Program</th>
                                <th>Pemateri</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($semua_kelas)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Belum ada jadwal kelas.</td>
                            </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($semua_kelas as $k): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= esc($k['nama_kelas']) ?></strong></td>
                                    <td><?= esc($k['nama_program']) ?></td>
                                    <td><?= esc($k['nama_dosen'] ?? '-') ?></td>
                                    <td><?= date('d M Y', strtotime($k['tanggal'])) ?></td>
                                    <td><?= date('H:i', strtotime($k['jam_mulai'])) ?> - <?= date('H:i', strtotime($k['jam_selesai'])) ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $k['status_kelas'] == 'aktif' ? 'bg-primary' : ($k['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?>">
                                            <?= ucfirst($k['status_kelas']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-info text-white rounded" title="Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function startKalender() {
    if (window.jadwalKelasCalendar) {
        window.jadwalKelasCalendar.destroy();
    }

    var kalenderEl = document.getElementById('kalender');
    if (!kalenderEl) return;

    var calendar = new FullCalendar.Calendar(kalenderEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: false
        },
        buttonText: { today: 'Hari Ini' },

        events: '<?= base_url('jadwal_kelas/get_events') ?>',
        eventClick: function(info) {
            var url = '<?= base_url('presensi_kelas/detail_kelas/') ?>' + info.event.extendedProps.id_kelas + '?from=kalender';
            window.location.href = url;
        },
        eventDidMount: function(info) {
            info.el.title = info.event.title + ' — ' + info.event.extendedProps.nama_program;
            info.el.style.fontStyle = 'italic';
        }
    });
    calendar.render();
    window.jadwalKelasCalendar = calendar;

    // Inject select ke sebelah kanan toolbar kalender
    var toolbar = document.querySelector('.fc-header-toolbar');
    if (toolbar) {
        var rightSection = toolbar.querySelector('.fc-toolbar-chunk:last-child');
        if (rightSection) {
            var oldSel = document.getElementById('kalender-view');
            if (oldSel) oldSel.remove();
            
            var sel = document.createElement('select');
            sel.id = 'kalender-view';
            sel.className = 'form-select form-select-sm';
            sel.style.width = '120px';
            sel.innerHTML = '<option value="dayGridMonth">Bulan</option><option value="timeGridWeek">Minggu</option><option value="listWeek">Daftar</option>';
            sel.addEventListener('change', function() { calendar.changeView(this.value); });
            rightSection.appendChild(sel);
        }
    }
}

function initDependenciesKalender() {
    if (typeof FullCalendar === 'undefined') {
        if (!document.getElementById('fullcalendar-css')) {
            document.head.insertAdjacentHTML('beforeend', '<link id="fullcalendar-css" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">');
        }
        var s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js';
        s.onload = startKalender;
        document.head.appendChild(s);
    } else {
        startKalender();
    }
}

initDependenciesKalender();


</script>
