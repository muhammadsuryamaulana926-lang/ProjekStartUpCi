<?php /* View: Detail Full Video (YouTube Clone Layout) */ ?>
<style>
/* Reset and Base for this specific view to avoid conflicts but keep consistency */
body, #content-wrapper, #content, .container-fluid, .app-content {
    background-color: #ffffff !important;
}

.app-content {
    padding: 24px;
}

.yt-layout {
    display: flex;
    gap: 24px;
    max-width: 1600px;
    margin: 0 auto;
}

.yt-main {
    flex: 1;
    min-width: 0; /* Prevents flex item overflow */
}

.yt-sidebar {
    width: 400px;
    flex-shrink: 0;
}

@media (max-width: 1024px) {
    .yt-layout {
        flex-direction: column;
    }
    .yt-sidebar {
        width: 100%;
    }
}

/* Video Player */
.yt-player-container {
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08); /* slight premium touch */
    position: relative;
}

.plyr--full-ui.plyr--video { 
    --plyr-color-main: #8B7355; 
    height: 100%;
    width: 100%;
}
.yt-player-container .plyr__video-wrapper {
    height: 100% !important;
    padding-bottom: 0 !important;
    background: #000 !important;
    overflow: hidden !important;
}
/* Minimal scale to crop YT watermark without visible zoom */
.plyr__video-embed iframe { 
    transform: scale(1.05); 
    transform-origin: center center;
}

/* Title */
.yt-title {
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 12px;
    line-height: 1.4;
    text-transform: capitalize;
}

/* Meta Data / Actions Row */
.yt-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 16px;
}

.yt-meta-row {
    display: none;
}

.yt-channel-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.yt-channel-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: bold;
    color: #0f172a;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}
.yt-channel-avatar img {
    width: 100%; height: 100%; object-fit: cover;
}

.yt-channel-text {
    display: flex;
    flex-direction: column;
}

.yt-channel-name {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.2;
}

.yt-channel-subs {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
}

.yt-subscribe-btn {
    background: #0f172a;
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    margin-left: 12px;
    transition: background 0.2s;
}
.yt-subscribe-btn:hover { background: #334155; }

.yt-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.yt-action-btn-group {
    display: flex;
    background: #f1f5f9;
    border-radius: 20px;
    overflow: hidden;
}

.yt-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f1f5f9;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    cursor: pointer;
    transition: background 0.2s;
    border-radius: 20px;
}
.yt-btn:hover { background: #e2e8f0; }

.yt-action-btn-group .yt-btn {
    border-radius: 0;
}
.yt-action-btn-group .yt-btn:first-child {
    border-right: 1px solid #cbd5e1;
    padding-left: 16px;
}
.yt-action-btn-group .yt-btn:last-child {
    padding-right: 16px;
}

.yt-btn svg { width: 20px; height: 20px; }

/* Description Box */
.yt-desc-box {
    background: #f1f5f9;
    border-radius: 12px;
    padding: 16px;
    font-size: 14px;
    color: #0f172a;
    line-height: 1.6;
    margin-bottom: 24px;
    cursor: pointer;
    transition: background 0.2s;
}
.yt-desc-box:hover {
    background: #e2e8f0;
}
.yt-desc-meta {
    font-weight: 700;
    margin-bottom: 8px;
    display: flex;
    gap: 8px;
}
.yt-desc-content {
    white-space: pre-wrap;
}

/* Comments Section Placeholder */
.yt-comments-header {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 16px;
}

.yt-comment-input-row {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}
.yt-comment-input {
    flex: 1;
    border: none;
    border-bottom: 1px solid #cbd5e1;
    background: transparent;
    padding: 8px 0;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}
.yt-comment-input:focus { border-bottom-color: #0f172a; }

.yt-more-wrap {
    position: relative;
}
.yt-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 6px);
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    min-width: 200px;
    z-index: 999;
    overflow: hidden;
}
.yt-dropdown.show { display: block; }
.yt-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 500;
    color: #0f172a;
    cursor: pointer;
    transition: background 0.15s;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}
.yt-dropdown-item:hover { background: #f1f5f9; }
.yt-dropdown-item svg { width: 18px; height: 18px; flex-shrink: 0; }
.yt-queue-box {
    display: none;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 20px;
    background: #f8fafc;
}
.yt-queue-box.show { display: block; }
.yt-queue-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e2e8f0;
}
.yt-queue-header button {
    font-size: 11px;
    color: #ef4444;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    padding: 0;
}
.yt-queue-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #e2e8f0;
}
.yt-queue-item:last-child { border-bottom: none; }
.yt-queue-item-thumb {
    width: 80px;
    height: 45px;
    border-radius: 6px;
    object-fit: cover;
    flex-shrink: 0;
    background: #000;
}
.yt-queue-item-title {
    font-size: 12px;
    font-weight: 600;
    color: #0f172a;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}
.yt-queue-item-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 3px;
    overflow: hidden;
}
.yt-queue-item-desc {
    font-size: 11px;
    color: #64748b;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}
.yt-queue-item button { background: none; border: none; cursor: pointer; color: #94a3b8; font-size: 18px; line-height: 1; padding: 0 2px; flex-shrink:0; }
.yt-queue-item button:hover { color: #ef4444; }

.yt-filter-chips {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    margin-bottom: 16px;
    scrollbar-width: none;
}
.yt-filter-chips::-webkit-scrollbar { display: none; }
.yt-chip {
    padding: 6px 12px;
    background: #f1f5f9;
    color: #0f172a;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    white-space: nowrap;
    border: none;
    transition: background 0.2s;
}
.yt-chip.active {
    background: #0f172a;
    color: #fff;
}
.yt-chip:hover:not(.active) {
    background: #e2e8f0;
}

.yt-rel-card {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
    cursor: pointer;
    text-decoration: none;
    align-items: flex-start;
    padding: 10px;
    border-radius: 10px;
    transition: background 0.15s;
}
.yt-rel-card:hover {
    background: #f8fafc;
}
.yt-rel-card:hover .yt-rel-title {
    color: #3b82f6;
}
.yt-rel-thumb {
    width: 168px;
    height: 94px;
    border-radius: 8px;
    background: #000;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}
.yt-rel-thumb img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.3s;
}
.yt-rel-card:hover .yt-rel-thumb img {
    transform: scale(1.05);
}
.yt-rel-badge {
    position: absolute;
    bottom: 4px;
    right: 4px;
    background: rgba(0,0,0,0.8);
    color: #fff;
    padding: 2px 4px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}
.yt-rel-info {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.yt-rel-title {
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.4;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s;
}
.yt-rel-channel {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 2px;
}
.yt-rel-views {
    font-size: 12px;
    color: #64748b;
}
</style>

<!-- Load Plyr CSS -->
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

<div class="app-content">
    
    <div class="yt-layout">
        
        <!-- Left Sidebar / Main Content -->
        <div class="yt-main">
            <!-- Player -->
            <div class="yt-player-container" id="yt-player-placeholder" data-yt-id="<?= esc($video->youtube_id) ?>" data-vid-id="<?= $video->id_konten_video ?>" data-uuid="<?= esc($video->uuid_konten_video) ?>">
            </div>

            <!-- Title -->
            <h1 class="yt-title"><?= esc($video->judul_video) ?></h1>

            <!-- View Count -->
            <div class="mb-2" style="font-size:14px;color:#64748b;">
                <i class="mdi mdi-eye-outline"></i> <?= number_format($video->jumlah_ditonton ?? 0) ?> kali ditonton
            </div>

            <!-- Actions Row -->
            <div class="yt-meta-row">
                <div></div>
                <div class="yt-actions">
                    <div class="yt-action-btn-group">
                        <button class="yt-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                            Like
                        </button>
                        <button class="yt-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" /></svg>
                        </button>
                    </div>
                    <button class="yt-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg>
                        Bagikan
                    </button>
                    <button class="yt-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Simpan
                    </button>

                </div>
            </div>

            <!-- Description Box -->
            <?php if ($video->deskripsi_video): ?>
            <div class="yt-desc-box">
                <div class="yt-desc-meta">Deskripsi</div>
                <div class="yt-desc-content"><?= esc($video->deskripsi_video) ?></div>
            </div>
            <?php endif; ?>
            
        </div>

        <!-- Right Sidebar (Related Videos) -->
        <div class="yt-sidebar">
            <div class="yt-filter-chips" style="margin-bottom:24px;">
                <button class="yt-chip active">Rekomendasi Video</button>
            </div>

            <!-- Antrian Tonton Setelah Ini -->
            <div class="yt-queue-box" id="queueBox">
                <div class="yt-queue-header">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14" style="vertical-align:middle; margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10" /></svg>
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
                        <button class="yt-btn" onclick="event.preventDefault(); event.stopPropagation(); toggleRelDropdown('rel_<?= $rel->uuid_konten_video ?>')" style="padding:4px; background:transparent;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5h.01M12 12h.01M12 19h.01M12 6a1 1 0 11-2 0 1 1 0 012 0zm0 7a1 1 0 11-2 0 1 1 0 012 0zm0 7a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
                        </button>
                        <div class="yt-dropdown" id="rel_<?= $rel->uuid_konten_video ?>">
                            <button class="yt-dropdown-item" onclick="event.preventDefault(); event.stopPropagation(); addToQueue('<?= $rel->uuid_konten_video ?>', '<?= esc($rel->judul_video) ?>', '<?= esc($rel->youtube_id) ?>', '<?= esc(mb_substr($rel->deskripsi_video ?? '', 0, 100)) ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" /></svg>
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
function toggleDropdown() {
    document.getElementById('moreDropdown').classList.toggle('show');
}

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
        title: 'Hapus dari antrian?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
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
        title: 'Hapus semua antrian?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal'
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
    if (queue.length === 0) {
        box.classList.remove('show');
        list.innerHTML = '';
        return;
    }
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

// Render antrian saat halaman load
renderQueue();

function tontonSetelahIni() {
    const rekomendasi = <?= json_encode(array_map(fn($r) => ['uuid' => $r->uuid_konten_video, 'judul' => $r->judul_video], $rekomendasi)) ?>;
    const queue = JSON.parse(localStorage.getItem('tonton_setelah_ini') || '[]');
    rekomendasi.forEach(v => {
        if (!queue.find(q => q.uuid === v.uuid)) queue.push(v);
    });
    localStorage.setItem('tonton_setelah_ini', JSON.stringify(queue));
    document.getElementById('moreDropdown').classList.remove('show');
    alert('Video rekomendasi akan diputar setelah video ini selesai.');
}
</script>
