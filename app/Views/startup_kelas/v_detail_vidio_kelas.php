<?php
function getYoutubeIdFromUrl($url) {
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\\/))([^\?&\"'>]+)/", $url, $matches);
    return $matches[1] ?? '';
}
$first_video  = $kelas_videos[0] ?? [];
$active_yt_id = getYoutubeIdFromUrl($first_video['link_youtube'] ?? '');
$first_vid_id = $first_video['id_kelas_video'] ?? 0;
$first_chapters = $chapters_map[$first_vid_id] ?? [];
?>
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
.plyr--full-ui.plyr--video { --plyr-color-main: #8B7355; height: 100%; width: 100%; }
.yt-player-container .plyr__video-wrapper { height: 100% !important; padding-bottom: 0 !important; background: #000 !important; overflow: hidden !important; }
.plyr__video-embed iframe { transform: scale(1.05); transform-origin: center center; pointer-events: none; user-select: none; }
.plyr__controls { z-index: 20 !important; }
.plyr--video .plyr__video-wrapper { z-index: 1; position: relative; }
.plyr__video-wrapper::after { content:''; position:absolute; bottom:0; right:0; width:120px; height:48px; background:linear-gradient(135deg,transparent 20%,rgba(0,0,0,0.95) 100%); z-index:10; pointer-events:none; border-radius:12px 0 0 0; }
.plyr__video-wrapper::before { content:''; position:absolute; top:0; left:0; right:0; height:90px; background:linear-gradient(180deg,rgba(0,0,0,1) 0%,rgba(0,0,0,0.8) 40%,transparent 100%); z-index:15; pointer-events:none; opacity:0; transition:opacity 0.3s; }
.plyr.plyr--paused .plyr__video-wrapper::before, .plyr.plyr--stopped .plyr__video-wrapper::before { opacity:1; }

.yt-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 12px; line-height: 1.4; }
.yt-meta-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:16px; }
.yt-channel-info { display:flex; align-items:center; gap:12px; }
.yt-channel-avatar { width:44px; height:44px; border-radius:8px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-size:24px; color:#8B7355; border:1px solid #e2e8f0; }
.yt-channel-name { font-size:15px; font-weight:700; color:#0f172a; }
.yt-channel-subs { font-size:13px; color:#64748b; margin-top:2px; }
.yt-desc-box { background:#f1f5f9; border-radius:12px; padding:20px; font-size:15px; color:#0f172a; line-height:1.7; margin-bottom:24px; }
.yt-desc-meta { font-weight:700; margin-bottom:8px; }

.yt-queue-box { border:1px solid #dee2e6; border-radius:4px; margin-bottom:20px; background:#fff; overflow:hidden; }
.yt-queue-header { background:#f8f9fa; padding:12px 16px; border-bottom:1px solid #dee2e6; }
.yt-queue-header-title { font-size:15px; font-weight:700; color:#212529; margin-bottom:2px; }
.yt-queue-header-subtitle { font-size:12px; color:#6c757d; }
.yt-kelas-header { background:#e9ecef; padding:8px 16px; border-bottom:1px solid #dee2e6; }
.yt-kelas-header-title { font-size:13px; font-weight:600; color:#495057; }
.yt-kelas-header-date { font-size:11px; color:#6c757d; }
.yt-queue-item { display:flex; align-items:center; gap:10px; padding:10px 16px; border-bottom:1px solid #dee2e6; text-decoration:none; color:#212529; cursor:pointer; transition:background 0.15s; }
.yt-queue-item:hover { background:#f8f9fa; color:#212529; }
.yt-queue-item:last-child { border-bottom:none; }
.yt-queue-item.active { background:#cfe2ff; color:#0a58ca; }
.yt-queue-item-icon { font-size:16px; color:#6c757d; flex-shrink:0; }
.yt-queue-item.active .yt-queue-item-icon { color:#0a58ca; }
.yt-queue-item-title { font-size:13px; font-weight:500; }
</style>

<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css"/>

<div class="app-content">
    <div style="max-width:1600px; margin:0 auto;">
        <div class="mb-3">
            <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-sm btn-light border" style="border-radius:8px; font-weight:500;">
                <i class="mdi mdi-arrow-left"></i> Kembali ke Detail Program
            </a>
        </div>

        <div class="yt-layout" style="max-width:100%; margin:0;">

            <!-- Main Player -->
            <div class="yt-main">
                <div class="yt-player-container">
                    <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="<?= esc($active_yt_id) ?>"></div>
                </div>

                <h1 class="yt-title" id="videoTitle"><?= esc($first_video['judul_sesi'] ?? $kelas_aktif['nama_kelas']) ?></h1>

                <div class="yt-meta-row">
                    <div class="yt-channel-info">
                        <div class="yt-channel-avatar"><i class="mdi mdi-school"></i></div>
                        <div>
                            <div class="yt-channel-name"><?= esc($program['nama_program']) ?></div>
                            <div class="yt-channel-subs">Dosen/Pemateri: <?= esc($kelas_aktif['nama_dosen']) ?></div>
                        </div>
                    </div>
                </div>

                <div class="yt-desc-box">
                    <div class="yt-desc-meta">Deskripsi Kelas</div>
                    <div><?= nl2br(esc($kelas_aktif['deskripsi'])) ?></div>
                </div>

                <!-- Card Chapter -->
                <?php
                // Siapkan data chapter semua sesi sebagai JSON untuk JS
                $chapters_js = [];
                foreach ($kelas_videos as $v) {
                    $vid_id = $v['id_kelas_video'] ?? 0;
                    $chapters_js[$vid_id] = $chapters_map[$vid_id] ?? [];
                }
                ?>
                <div id="chapterCard" class="card border mb-3" <?= empty($first_chapters) ? 'style="display:none"' : '' ?>>
                    <div class="card-header bg-light py-2 px-3 d-flex align-items-center gap-2">
                        <i class="mdi mdi-format-list-bulleted text-primary"></i>
                        <span class="fw-semibold small">Chapter</span>
                    </div>
                    <div class="list-group list-group-flush" id="chapterList">
                        <?php foreach ($first_chapters as $ch): ?>
                        <button type="button"
                                class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2"
                                onclick="seekTo(<?= $ch['mulai_detik'] ?>)">
                            <span class="badge bg-primary" style="min-width:52px; font-size:11px; font-weight:600;">
                                <?= sprintf('%d:%02d', floor($ch['mulai_detik']/60), $ch['mulai_detik']%60) ?>
                                <?php if ($ch['selesai_detik'] > 0): ?>
                                – <?= sprintf('%d:%02d', floor($ch['selesai_detik']/60), $ch['selesai_detik']%60) ?>
                                <?php endif; ?>
                            </span>
                            <span class="small"><?= esc($ch['judul_chapter']) ?></span>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar Playlist -->
            <div class="yt-sidebar">
                <div class="yt-queue-box">
                    <div class="yt-queue-header">
                        <div class="yt-queue-header-title">Daftar Rekaman Sesi</div>
                        <div class="yt-queue-header-subtitle"><?= esc($program['nama_program']) ?></div>
                    </div>

                    <?php foreach ($semua_kelas as $k):
                        $isKelasAktif = ($k['id_kelas'] == $kelas_aktif['id_kelas']);

                        // Ambil video untuk kelas ini
                        if ($isKelasAktif) {
                            $vids = $kelas_videos;
                        } elseif (!empty($k['link_youtube'])) {
                            $vids = [['judul_sesi' => 'Sesi 1', 'link_youtube' => $k['link_youtube'], 'link_zoom' => $k['link_zoom']]];
                        } else {
                            $vids = [];
                        }
                        if (empty($vids)) continue;
                    ?>
                    <!-- Header Kelas -->
                    <div class="yt-kelas-header">
                        <div class="yt-kelas-header-title"><i class="mdi mdi-book-open-outline me-1"></i><?= esc($k['nama_kelas']) ?></div>
                        <?php if ($k['tanggal']): ?>
                        <div class="yt-kelas-header-date"><?= date('d M Y', strtotime($k['tanggal'])) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Sesi-sesi dalam kelas ini -->
                    <?php foreach ($vids as $idx => $v):
                        $yt_id = getYoutubeIdFromUrl($v['link_youtube'] ?? '');
                        $isFirst = ($isKelasAktif && $idx === 0);
                    ?>
                    <?php if ($isKelasAktif): ?>
                    <div class="yt-queue-item sesi-item <?= $isFirst ? 'active' : '' ?>"
                         data-yt-id="<?= esc($yt_id) ?>"
                         data-judul="<?= esc($v['judul_sesi']) ?>"
                         data-vid-id="<?= $v['id_kelas_video'] ?? 0 ?>"
                         onclick="gantiFideo(this)">
                        <div class="yt-queue-item-icon">
                            <i class="mdi <?= $isFirst ? 'mdi-play-circle' : 'mdi-play-circle-outline' ?>"></i>
                        </div>
                        <div class="yt-queue-item-title"><?= esc($v['judul_sesi']) ?></div>
                    </div>
                    <?php else: ?>
                    <a href="<?= base_url('program/nonton_kelas/' . $k['id_kelas']) ?>" class="yt-queue-item">
                        <div class="yt-queue-item-icon"><i class="mdi mdi-play-circle-outline"></i></div>
                        <div class="yt-queue-item-title"><?= esc($v['judul_sesi']) ?></div>
                    </a>
                    <?php endif; ?>
                    <?php endforeach; ?>

                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script>
var chaptersData = <?= json_encode($chapters_js) ?>;

document.addEventListener('DOMContentLoaded', function() {
    var player = new Plyr('#player', {
        controls: ['play-large','play','progress','current-time','mute','volume','captions','settings','fullscreen'],
        youtube: { noCookie: true, rel: 0, showinfo: 0, ivory: 1, modestbranding: 1 }
    });

    window.seekTo = function(detik) {
        player.currentTime = detik;
        player.play();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    window.gantiFideo = function(el) {
        var ytId   = el.dataset.ytId;
        var judul  = el.dataset.judul;
        var vidId  = el.dataset.vidId;

        player.source = { type: 'video', sources: [{ src: ytId, provider: 'youtube' }] };
        document.getElementById('videoTitle').textContent = judul;

        // Update active state sidebar
        document.querySelectorAll('.sesi-item').forEach(function(s) {
            s.classList.remove('active');
            s.querySelector('i').className = 'mdi mdi-play-circle-outline';
        });
        el.classList.add('active');
        el.querySelector('i').className = 'mdi mdi-play-circle';

        // Update chapter card
        var chapters = chaptersData[vidId] || [];
        var card     = document.getElementById('chapterCard');
        var list     = document.getElementById('chapterList');
        if (chapters.length === 0) {
            card.style.display = 'none';
        } else {
            card.style.display = '';
            list.innerHTML = chapters.map(function(ch) {
                var mulai   = Math.floor(ch.mulai_detik/60) + ':' + String(ch.mulai_detik%60).padStart(2,'0');
                var selesai = ch.selesai_detik > 0 ? ' – ' + Math.floor(ch.selesai_detik/60) + ':' + String(ch.selesai_detik%60).padStart(2,'0') : '';
                return '<button type="button" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2" onclick="seekTo(' + ch.mulai_detik + ')">' +
                    '<span class="badge bg-primary" style="min-width:52px;font-size:11px;font-weight:600;">' + mulai + selesai + '</span>' +
                    '<span class="small">' + ch.judul_chapter + '</span>' +
                    '</button>';
            }).join('');
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    player.on('ended', function() {
        var items  = Array.from(document.querySelectorAll('.sesi-item'));
        var active = document.querySelector('.sesi-item.active');
        var idx    = items.indexOf(active);
        if (idx !== -1 && idx + 1 < items.length) {
            gantiFideo(items[idx + 1]);
        }
    });
});
</script>
