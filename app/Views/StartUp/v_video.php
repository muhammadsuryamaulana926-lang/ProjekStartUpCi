<?php /* View: Section Video — Galeri Video Pembelajaran */ ?>

<!-- Filter Chip Video -->
<div class="filter-chip-bar" id="filterChipVideo" style="justify-content:space-between;">
    <div style="display:flex;align-items:center;flex-wrap:wrap;gap:8px;">
        <span class="filter-chip-label">Filter</span>
        <button class="filter-chip active" onclick="filterVideo('kategori', '', this)">Semua</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Bisnis & Startup', this)">Bisnis &amp; Startup</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Teknologi', this)">Teknologi</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Marketing', this)">Marketing</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Keuangan', this)">Keuangan</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Manajemen', this)">Manajemen</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Hukum & Legalitas', this)">Hukum &amp; Legalitas</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Desain & Produk', this)">Desain &amp; Produk</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Motivasi', this)">Motivasi</button>
        <button class="filter-chip" onclick="filterVideo('kategori', 'Podcast', this)">Podcast</button>
        <div class="filter-chip-divider"></div>
        <button class="filter-chip" onclick="filterVideo('status', 'publik', this)">Publik</button>
        <button class="filter-chip" onclick="filterVideo('status', 'privat', this)">Privat</button>
    </div>
    <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
        <i class="mdi mdi-magnify" style="color:#adb5bd;font-size:18px;"></i>
        <input type="text" id="searchVideo" placeholder="Cari video..." oninput="searchVideos(this.value)"
            style="border:1px solid #dee2e6;border-radius:4px;padding:7px 12px;font-size:13px;outline:none;width:220px;">
    </div>
</div>

<?php if (session()->get('user_role') === 'admin'): ?>
<div class="d-flex justify-content-end" style="padding: 10px 0; margin-bottom: 24px;">
    <button onclick="bukaModalTambahVideo()" class="btn-add-video" style="padding: 8px 16px;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px; margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Video
    </button>
</div>
<?php endif; ?>

<?php if (empty($videos)): ?>
<div class="empty-cinema">
    <div class="empty-cinema-icon">🎬</div>
    <h3>Belum Ada Video</h3>
    <p>Belum ada konten video yang ditambahkan ke galeri pembelajaran.</p>
</div>
<?php else: ?>

<!-- Video Grid -->
<div class="video-grid" id="videoContainer">
    <?php foreach ($videos as $v): ?>
    <div class="vid-card"
         data-title="<?= strtolower(esc($v->judul_video)) ?>"
         data-status="<?= strtolower($v->status_video) ?>"
         data-kategori="<?= esc($v->kategori_video ?? '') ?>"
         data-vid-id="<?= $v->id_konten_video ?>"
         data-yt-id="<?= $v->youtube_id ?>"
         data-uuid="<?= $v->uuid_konten_video ?>">

        <!-- Thumbnail -->
        <div class="vid-thumb" id="thumb_<?= $v->id_konten_video ?>"
             onclick="if(!event.target.closest('.plyr__controls')) { <?= $v->punya_akses ? "bacaVideo('" . $v->uuid_konten_video . "')" : "aksesPrivat('video', " . $v->id_konten_video . ", '" . esc($v->judul_video) . "')" ?> }">
            <img src="https://img.youtube.com/vi/<?= $v->youtube_id ?>/hqdefault.jpg" alt="<?= esc($v->judul_video) ?>">
            <div class="vid-thumb-overlay"></div>
            <div id="player_<?= $v->id_konten_video ?>" class="vid-player-placeholder"
                 data-plyr-provider="youtube"
                 data-plyr-embed-id="<?= $v->youtube_id ?>"></div>
        </div>

        <!-- Body -->
        <div class="vid-body" style="cursor: pointer;"
             onclick="if(!event.target.closest('.vid-actions')) { <?= $v->punya_akses ? "bacaVideo('" . $v->uuid_konten_video . "')" : "aksesPrivat('video', " . $v->id_konten_video . ", '" . esc($v->judul_video) . "')" ?> }">
            <div class="vid-title"><?= strtolower(esc($v->judul_video)) ?></div>
            <?php if ($v->deskripsi_video): ?>
            <div class="vid-desc"><?= esc($v->deskripsi_video) ?></div>
            <?php else: ?>
            <div class="vid-desc" style="color:#D4C4A8; font-style:italic;">Belum ada deskripsi</div>
            <?php endif; ?>

            <?php if ($v->kategori_video): ?>
            <div style="margin-bottom: 10px;">
                <span style="font-size:10px; font-weight:700; padding:3px 10px; border-radius:20px; background:#F0EBE0; color:#8B7355;"><?= esc($v->kategori_video) ?></span>
            </div>
            <?php endif; ?>

            <div class="vid-footer">
                <div class="vid-meta"></div>
                <?php if (session()->get('user_role') === 'admin'): ?>
                <div class="vid-actions">
                    <?php if (strtolower($v->status_video) === 'privat'): ?>
                    <button onclick="event.stopPropagation(); bukaModalAksesVideo(<?= $v->id_konten_video ?>, '<?= esc($v->judul_video) ?>')" class="vid-action-btn" title="Kelola Akses">
                        <i data-lucide="users" style="width:14px;"></i>
                    </button>
                    <?php endif; ?>
                    <button onclick="event.stopPropagation(); bukaModalUbahVideo(<?= $v->id_konten_video ?>)" class="vid-action-btn" title="Edit">
                        <i data-lucide="edit-3" style="width:14px;"></i>
                    </button>
                    <button onclick="event.stopPropagation(); hapusVideo(<?= $v->id_konten_video ?>)" class="vid-action-btn danger" title="Hapus">
                        <i data-lucide="trash-2" style="width:14px;"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- No results -->
<div id="noVideoResults" style="display:none; text-align:center; padding: 60px 20px;">
    <div style="font-size: 48px; margin-bottom: 12px;">🔍</div>
    <h4 style="font-size: 16px; color: #3D3426; font-weight: 700; margin-bottom: 6px;">Tidak ditemukan</h4>
    <p style="font-size: 13px; color: #9C8E7A;">Coba kata kunci lain untuk pencarian Anda.</p>
</div>

<?php endif; ?>

<script>
    var _filterVideoKategori = '';
    var _filterVideoStatus   = '';

    function filterVideo(tipe, val, btn) {
        var bar  = document.getElementById('filterChipVideo');
        var btns = bar.querySelectorAll('button.filter-chip');
        // index: 0=Semua, 1-9=kategori, 10-11=Publik/Privat
        if (tipe === 'kategori') {
            btns.forEach(function(c, i) { if (i <= 9) c.classList.remove('active'); });
        } else {
            btns.forEach(function(c, i) { if (i >= 10) c.classList.remove('active'); });
        }

        if (tipe === 'status' && _filterVideoStatus === val) {
            _filterVideoStatus = '';
        } else if (tipe === 'kategori' && _filterVideoKategori === val) {
            _filterVideoKategori = '';
            btns[0].classList.add('active');
        } else {
            btn.classList.add('active');
            if (tipe === 'kategori') _filterVideoKategori = val;
            else                     _filterVideoStatus   = val;
        }

        applyFilterVideo();
    }

    function applyFilterVideo() {
        var cards = document.querySelectorAll('.vid-card');
        var visible = 0;
        cards.forEach(function(c) {
            var matchKat    = !_filterVideoKategori || c.dataset.kategori === _filterVideoKategori;
            var matchStatus = !_filterVideoStatus   || c.dataset.status   === _filterVideoStatus;
            if (matchKat && matchStatus) { c.style.display = ''; visible++; }
            else                         { c.style.display = 'none'; }
        });
        document.getElementById('noVideoResults').style.display = visible === 0 ? 'block' : 'none';
        var grid = document.querySelector('.video-grid');
        if (grid) grid.style.display = visible === 0 ? 'none' : '';
    }

    function searchVideos(query) {
        var q = query.toLowerCase().trim();
        var cards = document.querySelectorAll('.vid-card');
        var visible = 0;
        cards.forEach(function(c) {
            if (!q || c.dataset.title.includes(q)) { c.style.display = ''; visible++; }
            else                                    { c.style.display = 'none'; }
        });
        document.getElementById('noVideoResults').style.display = visible === 0 ? 'block' : 'none';
        var grid = document.querySelector('.video-grid');
        if (grid) grid.style.display = visible === 0 ? 'none' : '';
    }

    function bacaVideo(uuid) {
        window.location.href = '<?= base_url('perpustakaan/full_vidio/') ?>' + uuid;
    }
</script>
