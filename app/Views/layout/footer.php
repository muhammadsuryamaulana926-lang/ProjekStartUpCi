<?php
// Partial: Footer — SIMIK-style footer
?>

<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <script>document.write(new Date().getFullYear())</script> &copy; SIMIK DKST - Manajemen Startup Terpadu
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-sm-block">
                    <span id="clock-display"></span>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Global Miniplayer: Persistent across page navigation -->
<div id="global-miniplayer" style="display: none;">
    <button class="mini-close-btn" id="close-miniplayer">&times;</button>
    <div class="plyr-container">
        <div id="global-plyr" data-plyr-provider="youtube" data-plyr-embed-id=""></div>
    </div>
    <a class="mini-info-bar" id="mini-back-btn" href="#">
        <span class="mini-info-title" id="mini-info-title"></span>
        <span class="mini-info-desc" id="mini-info-desc"></span>
    </a>
</div>

<style>
#global-miniplayer {
    display: none;
    transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    will-change: transform, width, height;
}
#global-miniplayer.is-maximized {
    display: block !important;
    position: absolute;
    z-index: 10;
    border-radius: 12px;
    overflow: hidden;
    background: #000;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
#global-miniplayer.is-mini {
    display: flex !important;
    flex-direction: column;
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 420px;
    height: auto;
    z-index: 999999;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,255,255,0.06);
    overflow: hidden;
    background: #181818;
    user-select: none;
}
#global-miniplayer.is-mini.is-dragging {
    transition: none !important;
    opacity: 0.92;
    box-shadow: 0 16px 56px rgba(0,0,0,0.7), 0 0 0 2px rgba(59,130,246,0.4);
    cursor: grabbing !important;
}
#global-miniplayer.is-mini .plyr-container {
    cursor: grab;
    width: 100%;
    aspect-ratio: 16 / 9;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    background: #000;
}
#global-miniplayer.is-mini.is-dragging .plyr-container { cursor: grabbing; }
#global-miniplayer .plyr-container { width: 100%; height: 100%; }
.mini-info-bar { display: none; text-decoration: none; color: inherit; }
#global-miniplayer.is-mini .mini-info-bar {
    display: flex;
    flex-direction: column;
    gap: 2px;
    padding: 10px 14px;
    cursor: pointer;
    background: #212121;
    border-top: 1px solid rgba(255,255,255,0.08);
    transition: background 0.2s;
}
#global-miniplayer.is-mini .mini-info-bar:hover { background: #2a2a2a; }
.mini-info-title { display: block; font-size: 13px; font-weight: 600; color: #f1f5f9; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.4; }
.mini-info-desc { display: block; font-size: 12px; color: #aaaaaa; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.4; }
#global-miniplayer .mini-close-btn {
    display: none; position: absolute; top: 8px; right: 8px;
    background: rgba(0,0,0,0.7); color: white; border: none; border-radius: 50%;
    width: 28px; height: 28px; font-size: 18px; line-height: 1; z-index: 100000;
    cursor: pointer; align-items: center; justify-content: center;
    transition: background 0.2s; backdrop-filter: blur(4px);
}
#global-miniplayer .mini-close-btn:hover { background: rgba(220,38,38,0.9); }
#global-miniplayer.is-mini .mini-close-btn { display: flex; }
#global-miniplayer .plyr__video-wrapper iframe,
#global-miniplayer iframe { transform: scale(1.05) !important; transform-origin: center center !important; pointer-events: none !important; }
#global-miniplayer .plyr__controls { z-index: 20 !important; }
#global-miniplayer.is-mini .plyr__controls { padding: 4px 8px !important; font-size: 12px !important; }
#global-miniplayer.is-mini .plyr__control { padding: 4px !important; }
</style>

<script>
// ═══ MINIPLAYER ═══
window.globalPlayerInstance = window.globalPlayerInstance || null;
window.currentGlobalYtId = window.currentGlobalYtId || null;
window.currentVidId = window.currentVidId || null;
window.currentVideoUuid = window.currentVideoUuid || null;
window.currentVideoJudul = window.currentVideoJudul || null;
window.currentVideoDeskripsi = window.currentVideoDeskripsi || null;
window.playerObserver = window.playerObserver || null;
window.miniDragPos = window.miniDragPos || null;

function updateMiniInfoBar() {
    document.getElementById('mini-info-title').textContent = window.currentVideoJudul || '';
    document.getElementById('mini-info-desc').textContent = window.currentVideoDeskripsi || '';
    document.getElementById('mini-back-btn').href = '<?= base_url('perpustakaan/full_vidio/') ?>' + (window.currentVideoUuid || '');
}

function syncPlayerPosition() {
    const placeholder = document.getElementById('yt-player-placeholder');
    const mini = document.getElementById('global-miniplayer');
    if (placeholder && mini && mini.classList.contains('is-maximized')) {
        const rect = placeholder.getBoundingClientRect();
        mini.style.position = 'absolute';
        mini.style.top = (window.scrollY + rect.top) + 'px';
        mini.style.left = (window.scrollX + rect.left) + 'px';
        mini.style.width = rect.width + 'px';
        mini.style.height = rect.height + 'px';
        mini.style.margin = '0';
        mini.style.bottom = 'auto';
        mini.style.right = 'auto';
    } else if (mini && mini.classList.contains('is-mini') && !window.miniDragPos) {
        mini.style.position = 'fixed';
        mini.style.top = 'auto'; mini.style.left = 'auto';
        mini.style.bottom = '24px'; mini.style.right = '24px';
        mini.style.width = '420px'; mini.style.height = 'auto';
    }
}

window.addEventListener('resize', syncPlayerPosition);
window.addEventListener('scroll', syncPlayerPosition);

// Drag support
(function() {
    let isDragging = false, dragStartX = 0, dragStartY = 0, elemStartX = 0, elemStartY = 0, hasMoved = false;
    function onPointerDown(e) {
        const mini = document.getElementById('global-miniplayer');
        if (!mini || !mini.classList.contains('is-mini')) return;
        const plyrContainer = mini.querySelector('.plyr-container');
        if (!plyrContainer || !plyrContainer.contains(e.target)) return;
        if (e.target.closest('.mini-close-btn')) return;
        isDragging = true; hasMoved = false;
        dragStartX = e.clientX; dragStartY = e.clientY;
        const rect = mini.getBoundingClientRect();
        elemStartX = rect.left; elemStartY = rect.top;
        mini.classList.add('is-dragging'); e.preventDefault();
    }
    function onPointerMove(e) {
        if (!isDragging) return;
        const dx = e.clientX - dragStartX, dy = e.clientY - dragStartY;
        if (!hasMoved && Math.abs(dx) < 4 && Math.abs(dy) < 4) return;
        hasMoved = true;
        const mini = document.getElementById('global-miniplayer');
        if (!mini) return;
        let newX = Math.max(0, Math.min(elemStartX + dx, window.innerWidth - mini.offsetWidth));
        let newY = Math.max(0, Math.min(elemStartY + dy, window.innerHeight - mini.offsetHeight));
        mini.style.left = newX + 'px'; mini.style.top = newY + 'px';
        mini.style.right = 'auto'; mini.style.bottom = 'auto';
    }
    function onPointerUp() {
        if (!isDragging) return;
        isDragging = false;
        const mini = document.getElementById('global-miniplayer');
        if (mini) { mini.classList.remove('is-dragging'); if (hasMoved) window.miniDragPos = { left: mini.style.left, top: mini.style.top }; }
    }
    document.addEventListener('pointerdown', onPointerDown);
    document.addEventListener('pointermove', onPointerMove);
    document.addEventListener('pointerup', onPointerUp);
})();

function initGlobalPlayer() {
    const placeholder = document.getElementById('yt-player-placeholder');
    const miniplayerContainer = document.getElementById('global-miniplayer');
    const closeBtn = document.getElementById('close-miniplayer');
    let targetYtId = null, targetVidId = null;

    if (placeholder) {
        const ytId = placeholder.getAttribute('data-yt-id');
        const vidId = placeholder.getAttribute('data-vid-id');
        const uuid = placeholder.getAttribute('data-uuid');
        const judul = placeholder.getAttribute('data-judul') || '';
        const deskripsi = placeholder.getAttribute('data-deskripsi') || '';
        if (uuid) {
            let queue = JSON.parse(localStorage.getItem('tonton_setelah_ini') || '[]');
            if (queue.length > 0 && queue[0].uuid === uuid) { queue.shift(); localStorage.setItem('tonton_setelah_ini', JSON.stringify(queue)); }
        }
        if (ytId && ytId !== 'null' && ytId.trim() !== '') {
            targetYtId = ytId; targetVidId = vidId;
            window.currentVideoUuid = uuid; window.currentVideoJudul = judul; window.currentVideoDeskripsi = deskripsi;
            miniplayerContainer.style.display = 'block';
            miniplayerContainer.classList.remove('is-mini'); miniplayerContainer.classList.add('is-maximized');
            syncPlayerPosition();
            if (!window.playerObserver) window.playerObserver = new ResizeObserver(syncPlayerPosition);
            window.playerObserver.disconnect(); window.playerObserver.observe(placeholder); window.playerObserver.observe(document.body);
        }
    } else {
        if (window.playerObserver) window.playerObserver.disconnect();
        if (window.currentGlobalYtId && window.globalPlayerInstance) {
            miniplayerContainer.style.display = 'block';
            miniplayerContainer.classList.remove('is-maximized'); miniplayerContainer.classList.add('is-mini');
            if (window.miniDragPos) {
                miniplayerContainer.style.left = window.miniDragPos.left; miniplayerContainer.style.top = window.miniDragPos.top;
                miniplayerContainer.style.right = 'auto'; miniplayerContainer.style.bottom = 'auto';
                miniplayerContainer.style.width = '420px'; miniplayerContainer.style.height = 'auto';
            } else { syncPlayerPosition(); }
            updateMiniInfoBar();
        }
    }

    if (targetYtId) {
        if (!window.globalPlayerInstance) {
            const plyrDiv = document.getElementById('global-plyr');
            plyrDiv.setAttribute('data-plyr-provider', 'youtube');
            plyrDiv.setAttribute('data-plyr-embed-id', targetYtId);
            window.globalPlayerInstance = new Plyr('#global-plyr', {
                controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'fullscreen'],
                youtube: { noCookie: true, rel: 0, showinfo: 0, ivory: 1, modestbranding: 1 }
            });
            window.currentGlobalYtId = targetYtId; window.currentVidId = targetVidId;
            window.globalPlayerInstance.on('ready', () => {
                fetch('<?= base_url('riwayat/get_durasi_video') ?>', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: `id_video=${targetVidId}&<?= csrf_token() ?>=<?= csrf_hash() ?>` })
                .then(r => r.json()).then(data => { const d = parseInt(data.durasi) || 0; if (d > 5) window.globalPlayerInstance.currentTime = d; window.globalPlayerInstance.play().catch(e => {}); }).catch(() => { window.globalPlayerInstance.play().catch(e => {}); });
            });
            window.globalPlayerInstance.on('timeupdate', () => {
                const ct = Math.floor(window.globalPlayerInstance.currentTime);
                if (ct > 0 && ct % 10 === 0 && window.globalPlayerInstance.playing && window.currentVidId) {
                    fetch('<?= base_url('riwayat/update_video') ?>', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: `id_video=${window.currentVidId}&durasi=${ct}&<?= csrf_token() ?>=<?= csrf_hash() ?>` }).catch(e => {});
                }
            });
            window.globalPlayerInstance.on('ended', () => {
                const queue = JSON.parse(localStorage.getItem('tonton_setelah_ini') || '[]');
                if (queue.length > 0) { const next = queue.shift(); localStorage.setItem('tonton_setelah_ini', JSON.stringify(queue)); window.location.href = '<?= base_url('perpustakaan/full_vidio/') ?>' + next.uuid; }
            });
            if (closeBtn) {
                closeBtn.onclick = () => {
                    if (window.globalPlayerInstance) window.globalPlayerInstance.stop();
                    miniplayerContainer.style.display = 'none'; miniplayerContainer.classList.remove('is-mini');
                    window.currentGlobalYtId = null; window.currentVidId = null; window.miniDragPos = null;
                };
            }
        } else if (window.currentGlobalYtId !== targetYtId) {
            window.globalPlayerInstance.source = { type: 'video', sources: [{ src: targetYtId, provider: 'youtube' }] };
            window.currentGlobalYtId = targetYtId; window.currentVidId = targetVidId;
            window.globalPlayerInstance.once('ready', () => {
                fetch('<?= base_url('riwayat/get_durasi_video') ?>', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: `id_video=${targetVidId}&<?= csrf_token() ?>=<?= csrf_hash() ?>` })
                .then(r=>r.json()).then(data => { const d = parseInt(data.durasi) || 0; if (d > 5) window.globalPlayerInstance.currentTime = d; window.globalPlayerInstance.play().catch(e=>{}); }).catch(e => {});
            });
        } else {
            if (!window.globalPlayerInstance.playing) window.globalPlayerInstance.play().catch(e => {});
        }
    }
}

document.addEventListener('DOMContentLoaded', initGlobalPlayer);
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

<script>
// DataTable default init
$(document).ready(function() {
    if ($('#datatable').length && !$.fn.DataTable.isDataTable('#datatable')) {
        $('#datatable').DataTable();
    }
});

// Clock display
function showClock() {
    var now = new Date();
    var days = ['Minggu,', 'Senin,', 'Selasa,', 'Rabu,', 'Kamis,', "Jum'at,", 'Sabtu,'];
    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'];
    var h = String(now.getHours()).padStart(2, '0');
    var m = String(now.getMinutes()).padStart(2, '0');
    var s = String(now.getSeconds()).padStart(2, '0');
    var el = document.getElementById('clock-display');
    if (el) el.innerHTML = days[now.getDay()] + ' ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear() + ' Jam ' + h + ':' + m + ':' + s + ' WIB';
}
setInterval(showClock, 1000);
showClock();

// Fullscreen toggle
$('[data-toggle="fullscreen"]').on("click", function(e) {
    e.preventDefault();
    if (!document.fullscreenElement) { document.documentElement.requestFullscreen(); }
    else { if (document.exitFullscreen) document.exitFullscreen(); }
});

// Global CSRF helper
function getCsrfToken() {
    const meta = document.querySelector('meta[name^="csrf"]');
    if (meta) return { name: meta.getAttribute('name'), hash: meta.getAttribute('content') };
    return { name: '', hash: '' };
}

// Notification helpers
const NOTIF_CSRF = '<?= csrf_hash() ?>';
const NOTIF_CSRF_NAME = '<?= csrf_token() ?>';

function bukaNotif(id, url) {
    fetch('<?= base_url('notifikasi/tandai_dibaca') ?>', {
        method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id_notifikasi=' + id + '&' + NOTIF_CSRF_NAME + '=' + NOTIF_CSRF
    }).then(function() {
        var el = document.getElementById('notif-' + id);
        if (el) el.remove();
        var remaining = document.querySelectorAll('.notify-item[id^="notif-"]').length;
        if (remaining === 0) {
            var badge = document.querySelector('.noti-icon-badge');
            if (badge) badge.remove();
            document.getElementById('notifList').innerHTML = '<div class="text-center text-muted py-4"><i class="mdi mdi-bell-off-outline d-block mb-2" style="font-size:28px;"></i><small>Tidak ada notifikasi baru</small></div>';
        }
        if (url) window.location.href = url;
    });
}

function tandaiSemuaDibaca() {
    fetch('<?= base_url('notifikasi/tandai_semua') ?>', {
        method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: NOTIF_CSRF_NAME + '=' + NOTIF_CSRF
    }).then(function() {
        var badge = document.querySelector('.noti-icon-badge');
        if (badge) badge.remove();
        document.getElementById('notifList').innerHTML = '<div class="text-center text-muted py-4"><i class="mdi mdi-bell-off-outline d-block mb-2" style="font-size:28px;"></i><small>Tidak ada notifikasi baru</small></div>';
    });
}
</script>

<!-- Session Timeout Modal -->
<div class="modal fade" id="sessionModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center" style="border-radius:4px;">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                <div id="sessionCountdown" class="text-danger fw-bold"></div>
            </div>
            <div class="modal-body">
                Apakah Anda masih ingin berada di laman ini?
            </div>
            <div class="modal-footer">
                <a href="javascript:keepAlive()" class="btn btn-primary"><i class="mdi mdi-check"></i> Ya</a>
                <a href="<?= base_url('logout') ?>" class="btn btn-secondary"><i class="mdi mdi-logout"></i> Logout</a>
            </div>
        </div>
    </div>
</div>

<script>
// Session timeout
var IDLE_LIMIT = 5 * 60; // 5 menit
var WARNING_SECS = 10 * 60; // 10 menit countdown
var idleTimer, countdownTimer, secondsLeft;

document.onmousemove = resetIdle;
document.onkeydown = resetIdle;
document.onclick = resetIdle;

function resetIdle() {
    var modalEl = document.getElementById('sessionModal');
    if (modalEl && !modalEl.classList.contains('show')) {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(showSessionModal, IDLE_LIMIT * 1000);
    }
}

function showSessionModal() {
    secondsLeft = WARNING_SECS;
    var modal = new bootstrap.Modal(document.getElementById('sessionModal'));
    modal.show();
    updateSessionCountdown();
    countdownTimer = setInterval(() => {
        secondsLeft--;
        updateSessionCountdown();
        if (secondsLeft <= 0) { clearInterval(countdownTimer); window.location.href = '<?= base_url('logout') ?>'; }
    }, 1000);
}

function updateSessionCountdown() {
    const m = String(Math.floor(secondsLeft / 60)).padStart(2, '0');
    const s = String(secondsLeft % 60).padStart(2, '0');
    var el = document.getElementById('sessionCountdown');
    if (el) el.textContent = 'Logout otomatis : ' + m + ':' + s;
}

function keepAlive() {
    clearInterval(countdownTimer);
    bootstrap.Modal.getInstance(document.getElementById('sessionModal')).hide();
    fetch('<?= base_url('keep-alive') ?>', { method: 'POST', headers: { 'X-CSRF-TOKEN': '<?= csrf_hash() ?>' } });
    resetIdle();
}

idleTimer = setTimeout(showSessionModal, IDLE_LIMIT * 1000);
</script>

</body>
</html>
