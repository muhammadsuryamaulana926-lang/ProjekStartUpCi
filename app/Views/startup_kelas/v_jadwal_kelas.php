<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Jadwal Kelas</h4>
                    </div>
                </div>
            </div>

            <!-- Kalender -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="header-title mb-0">Kalender Jadwal Kelas</h4>
                                <div class="d-flex gap-2 align-items-center">
                                    <span class="badge" style="background:#3b82f6;">Aktif</span>
                                    <span class="badge" style="background:#22c55e;">Selesai</span>
                                    <span class="badge" style="background:#ef4444;">Dibatalkan</span>
                                </div>
                            </div>
                            <div id="kalender"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Semua Jadwal -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Semua Jadwal Kelas</h4>
                            <div id="tabel">
                                <div class="table-responsive">
                                    <table id="datatable-jadwal" class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th class="text-center" style="min-width:40px;">No</th>
                                                <th style="min-width:150px;">Nama Kelas</th>
                                                <th style="min-width:120px;">Program</th>
                                                <th style="min-width:120px;">Pemateri</th>
                                                <th style="min-width:100px;">Tanggal</th>
                                                <th style="min-width:100px;">Waktu</th>
                                                <th class="text-center" style="min-width:80px;">Status</th>
                                                <th class="text-center" style="min-width:70px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($semua_kelas)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center">Belum ada jadwal kelas.</td>
                                            </tr>
                                            <?php else: ?>
                                                <?php $no = 1; foreach ($semua_kelas as $k): ?>
                                                <tr>
                                                    <td style="text-align:center;"><?= $no++ ?>.</td>
                                                    <td><b><?= esc($k['nama_kelas']) ?></b></td>
                                                    <td><?= esc($k['nama_program']) ?></td>
                                                    <td><?= esc($k['nama_dosen'] ?? '-') ?></td>
                                                    <td><?= date('d M Y', strtotime($k['tanggal'])) ?></td>
                                                    <td><?= date('H:i', strtotime($k['jam_mulai'])) ?> - <?= date('H:i', strtotime($k['jam_selesai'])) ?></td>
                                                    <td style="text-align:center;">
                                                        <span class="badge <?= $k['status_kelas'] == 'aktif' ? 'bg-primary' : ($k['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?>">
                                                            <?= ucfirst($k['status_kelas']) ?>
                                                        </span>
                                                    </td>
                                                    <td style="text-align:center;">
                                                        <a href="<?= base_url('presensi_kelas/detail_kelas/' . $k['id_kelas']) ?>" class="btn btn-sm btn-primary waves-effect waves-light" title="Detail">
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
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
</div><!-- content-page -->

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

    // Inject select view ke toolbar kalender
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
        s.onload = function() {
            startKalender();
            initDataTable();
        };
        document.head.appendChild(s);
    } else {
        startKalender();
        initDataTable();
    }
}

function initDataTable() {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#datatable-jadwal')) {
        $('#datatable-jadwal').DataTable({
            pageLength: 10,
            ordering: false,
            destroy: true,
            autoWidth: false,
            language: {
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                paginate: { previous: 'Previous', next: 'Next' }
            }
        });
    }
}

initDependenciesKalender();
</script>
