<?php /* View: Detail Full Video (YouTube Clone Layout) */ ?>
<style>
body, #content-wrapper, #content, .container-fluid, .app-content {
    background-color: #ffffff !important;
}
.app-content { padding: 24px; }
.yt-layout { display: flex; gap: 24px; max-width: 1600px; margin: 0 auto; }
.yt-main { flex: 1; min-width: 0; }
.yt-sidebar { width: 400px; flex-shrink: 0; }
@media (max-width: 1024px) {
    .yt-layout { flex-direction: column; }
    .yt-sidebar { width: 100%; }
}
.yt-player-container {
    width: 100%; aspect-ratio: 16/9; background: #000;
    border-radius: 12px; overflow: hidden; margin-bottom: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08); position: relative;
}
/* Overlay hitung mundur */
#overlay_hitung_mundur {
    display: none;
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.85);
    z-index: 30;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    border-radius: 12px;
}
#overlay_hitung_mundur.tampil { display: flex; }
#overlay_hitung_mundur .angka { font-size: 64px; font-weight: 800; color: #fff; line-height: 1; }
#overlay_hitung_mundur .teks  { font-size: 14px; color: rgba(255,255,255,0.8); }
#overlay_hitung_mundur .btn-batal { font-size: 12px; color: rgba(255,255,255,0.6); background: none; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 6px 16px; cursor: pointer; }
#overlay_hitung_mundur .btn-batal:hover { color: #fff; border-color: #fff; }
.plyr--full-ui.plyr--video { --plyr-color-main: #8B7355; height: 100%; width: 100%; }
.yt-player-container .plyr__video-wrapper { height: 100% !important; padding-bottom: 0 !important; background: #000 !important; overflow: hidden !important; }
.plyr__video-embed iframe { transform: scale(1.05); transform-origin: center center; pointer-events: none; user-select: none; }
.plyr__controls { z-index: 20 !important; }
.plyr--video .plyr__video-wrapper { z-index: 1; position: relative; }
.plyr__video-wrapper::after { content:''; position:absolute; bottom:0; right:0; width:120px; height:48px; background:linear-gradient(135deg,transparent 20%,rgba(0,0,0,0.95) 100%); z-index:10; pointer-events:none; border-radius:12px 0 0 0; }
.plyr__video-wrapper::before { content:''; position:absolute; top:0; left:0; right:0; height:90px; background:linear-gradient(180deg,rgba(0,0,0,1) 0%,rgba(0,0,0,0.8) 40%,transparent 100%); z-index:15; pointer-events:none; opacity:0; transition:opacity 0.3s; }
.plyr.plyr--paused .plyr__video-wrapper::before, .plyr.plyr--stopped .plyr__video-wrapper::before { opacity:1; }

.yt-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 12px; line-height: 1.4; text-transform: capitalize; }
.yt-meta-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:16px; }
.yt-channel-info { display:flex; align-items:center; gap:12px; }
.yt-channel-avatar { width:40px; height:40px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:bold; color:#0f172a; overflow:hidden; border:1px solid #e2e8f0; }
.yt-channel-avatar img { width:100%; height:100%; object-fit:cover; }
.yt-channel-name { font-size:15px; font-weight:700; color:#0f172a; line-height:1.2; }
.yt-channel-subs { font-size:12px; color:#64748b; margin-top:2px; }
.yt-actions { display:flex; align-items:center; gap:8px; }
.yt-btn { display:flex; align-items:center; gap:6px; background:#f1f5f9; border:none; padding:8px 16px; font-size:14px; font-weight:600; color:#0f172a; cursor:pointer; transition:background 0.2s; border-radius:20px; }
.yt-btn:hover { background:#e2e8f0; }
.yt-btn svg { width:20px; height:20px; }
.yt-desc-box { background:#f1f5f9; border-radius:12px; padding:20px; font-size:15px; color:#0f172a; line-height:1.7; margin-bottom:24px; cursor:pointer; transition:background 0.2s; }
.yt-desc-box:hover { background:#e2e8f0; }
.yt-desc-meta { font-weight:700; margin-bottom:8px; display:flex; gap:8px; }
.yt-desc-content { white-space:pre-wrap; }
.yt-more-wrap { position:relative; }
.yt-dropdown { display:none; position:absolute; right:0; top:calc(100% + 6px); background:#fff; border:1px solid #e2e8f0; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.12); min-width:200px; z-index:999; overflow:hidden; }
.yt-dropdown.show { display:block; }
.yt-dropdown-item { display:flex; align-items:center; gap:10px; padding:12px 16px; font-size:14px; font-weight:500; color:#0f172a; cursor:pointer; transition:background 0.15s; border:none; background:none; width:100%; text-align:left; }
.yt-dropdown-item:hover { background:#f1f5f9; }
.yt-dropdown-item svg { width:18px; height:18px; flex-shrink:0; }
.yt-queue-box { display:none; border:1.5px solid #e2e8f0; border-radius:12px; padding:14px 16px; margin-bottom:20px; background:#f8fafc; }
.yt-queue-box.show { display:block; }
.yt-queue-header { display:flex; justify-content:space-between; align-items:center; font-size:13px; font-weight:700; color:#0f172a; margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #e2e8f0; }
.yt-queue-header button { font-size:11px; color:#ef4444; background:none; border:none; cursor:pointer; font-weight:600; padding:0; }
.yt-queue-item { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #e2e8f0; }
.yt-queue-item:last-child { border-bottom:none; }
.yt-queue-item-thumb { width:80px; height:45px; border-radius:6px; object-fit:cover; flex-shrink:0; background:#000; }
.yt-queue-item-title { font-size:12px; font-weight:600; color:#0f172a; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; line-height:1.4; }
.yt-queue-item-info { flex:1; display:flex; flex-direction:column; gap:3px; overflow:hidden; }
.yt-queue-item-desc { font-size:11px; color:#64748b; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; line-height:1.4; }
.yt-queue-item button { background:none; border:none; cursor:pointer; color:#94a3b8; font-size:18px; line-height:1; padding:0 2px; flex-shrink:0; }
.yt-queue-item button:hover { color:#ef4444; }
.yt-filter-chips { display:flex; gap:8px; overflow-x:auto; margin-bottom:16px; scrollbar-width:none; }
.yt-filter-chips::-webkit-scrollbar { display:none; }
.yt-chip { padding:6px 12px; background:#f1f5f9; color:#0f172a; border-radius:8px; font-size:14px; font-weight:500; cursor:pointer; white-space:nowrap; border:none; transition:background 0.2s; }
.yt-chip.active { background:#0f172a; color:#fff; }
.yt-chip:hover:not(.active) { background:#e2e8f0; }
.yt-rel-card { display:flex; gap:10px; margin-bottom:16px; cursor:pointer; text-decoration:none; align-items:flex-start; padding:10px; border-radius:10px; transition:background 0.15s; }
.yt-rel-card:hover { background:#f8fafc; }
.yt-rel-card:hover .yt-rel-title { color:#3b82f6; }
.yt-rel-thumb { width:168px; height:94px; border-radius:8px; background:#000; flex-shrink:0; position:relative; overflow:hidden; }
.yt-rel-thumb img { width:100%; height:100%; object-fit:cover; transition:transform 0.3s; }
.yt-rel-card:hover .yt-rel-thumb img { transform:scale(1.05); }
.yt-rel-info { flex:1; display:flex; flex-direction:column; }
.yt-rel-title { font-size:14px; font-weight:600; color:#0f172a; line-height:1.4; margin-bottom:4px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; transition:color 0.2s; }
.yt-rel-views { font-size:12px; color:#64748b; }
</style>

<div class="app-content">
    <div class="yt-layout">

        <div class="yt-main">
            <div class="yt-player-container">
                <div id="yt-player-placeholder"
                     data-yt-id="<?= esc($video->youtube_id) ?>"
                     data-vid-id="<?= esc($video->id_konten_video) ?>"
                     data-uuid="<?= esc($video->uuid_konten_video) ?>"
                     style="width:100%;height:100%;"></div>
                <div id="overlay_hitung_mundur">
                    <div class="teks">Video dimulai dalam</div>
                    <div class="angka" id="angka_mundur">5</div>
                    <button class="btn-batal" onclick="batal_putar()">Tonton Nanti</button>
                </div>
            </div>

            <h1 class="yt-title"><?= esc($video->judul_video) ?></h1>
            <div class="text-muted mb-3" style="font-size:13px;">
                <i class="mdi mdi-eye-outline me-1"></i><?= number_format($video->jumlah_ditonton) ?> kali ditonton
            </div>

            <div class="yt-meta-row">
                <div></div>
                <div class="yt-actions"></div>
            </div>

            <?php if ($video->deskripsi_video): ?>
            <div class="yt-desc-box">
                <div class="yt-desc-meta">Deskripsi</div>
                <div class="yt-desc-content"><?= esc($video->deskripsi_video) ?></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="yt-sidebar">
            <div class="yt-filter-chips" style="margin-bottom:24px;">
                <button class="yt-chip active">Rekomendasi Video</button>
            </div>

            <div class="yt-queue-box" id="queueBox">
                <div class="yt-queue-header">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14" style="vertical-align:middle; margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10"/></svg>
                        Tonton Setelah Ini
                    </span>
                    <button onclick="clearQueue()">Hapus Semua</button>
                </div>
                <div id="queueList"></div>
            </div>

            <?php if (!empty($rekomendasi)): ?>
                <?php foreach ($rekomendasi as $rel): ?>
                <a href="<?= base_url('perpustakaan/full_vidio/' . $rel->uuid_konten_video) ?>" class="yt-rel-card">
                    <div class="yt-rel-thumb">
                        <img src="https://img.youtube.com/vi/<?= esc($rel->youtube_id) ?>/mqdefault.jpg" alt="<?= esc($rel->judul_video) ?>">
                    </div>
                    <div class="yt-rel-info">
                        <div class="yt-rel-title"><?= esc($rel->judul_video) ?></div>
                        <?php if ($rel->deskripsi_video): ?>
                        <div class="yt-rel-views" style="margin-top:4px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;"><?= esc($rel->deskripsi_video) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="yt-more-wrap" style="flex-shrink:0; align-self:flex-start;">
                        <button class="yt-btn" onclick="event.preventDefault(); toggleRelDropdown('rel_<?= $rel->uuid_konten_video ?>')" style="padding:4px; background:transparent;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5h.01M12 12h.01M12 19h.01M12 6a1 1 0 11-2 0 1 1 0 012 0zm0 7a1 1 0 11-2 0 1 1 0 012 0zm0 7a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                        </button>
                        <div class="yt-dropdown" id="rel_<?= $rel->uuid_konten_video ?>">
                            <button class="yt-dropdown-item" onclick="event.preventDefault(); addToQueue('<?= $rel->uuid_konten_video ?>', '<?= esc($rel->judul_video) ?>', '<?= esc($rel->youtube_id) ?>', '<?= esc(mb_substr($rel->deskripsi_video ?? '', 0, 100)) ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                                Tonton Setelah Ini
                            </button>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="font-size:13px; color:#64748b; padding:20px; text-align:center; background:#f8fafc; border-radius:12px;">
                    Tidak ada saran video lain saat ini.
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Hitung mundur auto-play dari antrian
    if (sessionStorage.getItem('auto_play') === '1') {
        sessionStorage.removeItem('auto_play');
        var overlay = document.getElementById('overlay_hitung_mundur');
        var angka   = document.getElementById('angka_mundur');
        var sisa    = 5;
        overlay.classList.add('tampil');
        var timer = setInterval(function() {
            sisa--;
            angka.textContent = sisa;
            if (sisa <= 0) {
                clearInterval(timer);
                overlay.classList.remove('tampil');
                if (window.globalPlayerInstance) window.globalPlayerInstance.play();
            }
        }, 1000);
        window.batal_putar = function() {
            clearInterval(timer);
            overlay.classList.remove('tampil');
        };
    }
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.yt-more-wrap')) {
        document.querySelectorAll('.yt-dropdown').forEach(d => d.classList.remove('show'));
    }
});

function toggleRelDropdown(id) {
    const el = document.getElementById(id);
    const wasOpen = el.classList.contains('show');
    document.querySelectorAll('.yt-dropdown').forEach(d => d.classList.remove('show'));
    if (!wasOpen) el.classList.add('show');
}

function addToQueue(uuid, judul, ytId, deskripsi) {
    const queue = JSON.parse(localStorage.getItem('tonton_setelah_ini') || '[]');
    if (!queue.find(q => q.uuid === uuid)) {
        queue.push({ uuid, judul, ytId, deskripsi });
        localStorage.setItem('tonton_setelah_ini', JSON.stringify(queue));
    }
    document.querySelectorAll('.yt-dropdown').forEach(d => d.classList.remove('show'));
    renderQueue();
}

function removeFromQueue(uuid) {
    Swal.fire({
        title: 'Hapus dari antrian?', icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#d33', cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) {
            let queue = JSON.parse(localStorage.getItem('tonton_setelah_ini') || '[]');
            queue = queue.filter(q => q.uuid !== uuid);
            localStorage.setItem('tonton_setelah_ini', JSON.stringify(queue));
            renderQueue();
        }
    });
}

function clearQueue() {
    Swal.fire({
        title: 'Hapus semua antrian?', icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#d33', cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Semua!', cancelButtonText: 'Batal'
    }).then(result => {
        if (result.isConfirmed) {
            localStorage.removeItem('tonton_setelah_ini');
            renderQueue();
        }
    });
}

function renderQueue() {
    const queue = JSON.parse(localStorage.getItem('tonton_setelah_ini') || '[]');
    const box  = document.getElementById('queueBox');
    const list = document.getElementById('queueList');
    if (queue.length === 0) { box.classList.remove('show'); list.innerHTML = ''; return; }
    box.classList.add('show');
    list.innerHTML = queue.map(v =>
        `<div class="yt-queue-item">
            <img class="yt-queue-item-thumb" src="https://img.youtube.com/vi/${v.ytId}/mqdefault.jpg" alt="${v.judul}">
            <div class="yt-queue-item-info">
                <div class="yt-queue-item-title">${v.judul}</div>
                ${v.deskripsi ? `<div class="yt-queue-item-desc">${v.deskripsi}</div>` : ''}
            </div>
            <button onclick="removeFromQueue('${v.uuid}')" title="Hapus">&times;</button>
        </div>`
    ).join('');
}

renderQueue();

document.addEventListener('keydown', function(e) {
    if (e.code === 'Space' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA' && e.target.tagName !== 'BUTTON') {
        e.preventDefault();
        player.togglePlay();
    }
});
</script>
