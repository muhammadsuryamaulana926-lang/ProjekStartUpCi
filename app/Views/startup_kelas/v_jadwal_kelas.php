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
.jadwal-item {
    border-left: 4px solid #3b82f6;
    padding: 12px 16px;
    background: #f8fafc;
    border-radius: 0 8px 8px 0;
    margin-bottom: 10px;
    transition: all 0.2s;
}
.jadwal-item:hover { background: #eff6ff; }
.jadwal-item.selesai { border-left-color: #22c55e; }
.jadwal-item.dibatalkan { border-left-color: #ef4444; opacity: 0.7; }
.badge-status { font-size: 11px; padding: 3px 10px; border-radius: 20px; }
#kalender { min-height: 500px; }
.fc-event { cursor: pointer; font-size: 12px; }
.modal-materi .modal-content { border-radius: 12px; }
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-11">

            <div class="row g-4">
                <!-- Kalender -->
                <div class="col-lg-8">
                    <div class="paper-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="m-0 font-weight-bold text-dark">Kalender Jadwal Kelas</h4>
                            <div class="d-flex gap-2 align-items-center" style="font-size:12px;">
                                <span class="badge" style="background:#3b82f6;">Aktif</span>
                                <span class="badge" style="background:#22c55e;">Selesai</span>
                                <span class="badge" style="background:#ef4444;">Dibatalkan</span>
                            </div>
                        </div>
                        <div id="kalender"></div>
                    </div>
                </div>

                <!-- Jadwal Mendatang -->
                <div class="col-lg-4">
                    <div class="paper-card">
                        <h5 class="font-weight-bold text-dark mb-4">
                            <i class="mdi mdi-calendar-clock text-primary me-2"></i>Jadwal Mendatang
                        </h5>

                        <?php if (empty($kelas_mendatang)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="mdi mdi-calendar-blank" style="font-size:40px; color:#cbd5e1;"></i>
                                <p class="mt-2 small">Tidak ada jadwal mendatang.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($kelas_mendatang as $k): ?>
                            <div class="jadwal-item <?= $k['status_kelas'] ?>">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <strong class="small text-dark" style="line-height:1.3;"><?= esc($k['nama_kelas']) ?></strong>
                                    <span class="badge-status badge <?= $k['status_kelas'] == 'aktif' ? 'bg-primary' : ($k['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?>">
                                        <?= ucfirst($k['status_kelas']) ?>
                                    </span>
                                </div>
                                <div class="text-muted" style="font-size:12px;">
                                    <i class="mdi mdi-book-open-variant me-1"></i><?= esc($k['nama_program']) ?>
                                </div>
                                <div class="text-muted" style="font-size:12px;">
                                    <i class="mdi mdi-calendar me-1"></i><?= date('d M Y', strtotime($k['tanggal'])) ?>
                                    &bull; <?= date('H:i', strtotime($k['jam_mulai'])) ?> - <?= date('H:i', strtotime($k['jam_selesai'])) ?>
                                </div>
                                <?php if (!empty($k['nama_dosen'])): ?>
                                <div class="text-muted" style="font-size:12px;">
                                    <i class="mdi mdi-account-tie me-1"></i><?= esc($k['nama_dosen']) ?>
                                </div>
                                <?php endif; ?>
                                <div class="mt-2 d-flex gap-1">
                                    <a href="<?= base_url('program/detail_program/' . $k['id_program']) ?>" class="btn btn-xs btn-outline-primary" style="font-size:11px; padding:2px 10px; border-radius:4px;">
                                        Lihat Program
                                    </a>
                                    <a href="<?= base_url('materi_kelas/' . $k['id_kelas']) ?>" class="btn btn-xs btn-outline-secondary" style="font-size:11px; padding:2px 10px; border-radius:4px;">
                                        Materi
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Detail Kelas -->
<div class="modal fade" id="modalDetailKelas" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-materi">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalJudulKelas"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <div id="modalIsiKelas"></div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <a id="modalLinkProgram" href="#" class="btn btn-primary btn-sm">Lihat Program</a>
                <a id="modalLinkMateri" href="#" class="btn btn-outline-secondary btn-sm">Lihat Materi</a>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var kalender = document.getElementById('kalender');
    var calendar = new FullCalendar.Calendar(kalender, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            list: 'Daftar'
        },
        events: '<?= base_url('jadwal_kelas/get_events') ?>',
        eventClick: function(info) {
            var p = info.event.extendedProps;
            document.getElementById('modalJudulKelas').textContent = info.event.title;
            document.getElementById('modalIsiKelas').innerHTML =
                '<div class="mb-2"><i class="mdi mdi-book-open-variant text-primary me-2"></i><strong>Program:</strong> ' + p.nama_program + '</div>' +
                '<div class="mb-2"><i class="mdi mdi-account-tie text-primary me-2"></i><strong>Pemateri:</strong> ' + (p.nama_dosen || '-') + '</div>' +
                '<div class="mb-2"><i class="mdi mdi-calendar text-primary me-2"></i><strong>Tanggal:</strong> ' + info.event.startStr.split('T')[0] + '</div>' +
                '<div class="mb-2"><i class="mdi mdi-clock text-primary me-2"></i><strong>Waktu:</strong> ' + info.event.startStr.split('T')[1].substring(0,5) + ' - ' + (info.event.endStr ? info.event.endStr.split('T')[1].substring(0,5) : '-') + '</div>' +
                '<div><i class="mdi mdi-information text-primary me-2"></i><strong>Status:</strong> <span class="badge ' + (p.status == 'aktif' ? 'bg-primary' : p.status == 'selesai' ? 'bg-success' : 'bg-danger') + '">' + p.status + '</span></div>';
            document.getElementById('modalLinkProgram').href = '<?= base_url('program/detail_program/') ?>' + p.id_program;
            document.getElementById('modalLinkMateri').href  = '<?= base_url('materi_kelas/') ?>' + p.id_kelas;
            new bootstrap.Modal(document.getElementById('modalDetailKelas')).show();
        },
        eventDidMount: function(info) {
            info.el.title = info.event.title + ' — ' + info.event.extendedProps.nama_program;
        }
    });
    calendar.render();
});
</script>
