<?= view('Partials/v_header') ?>
<?= view('Partials/v_sidebar') ?>
<?= view('Partials/v_topbar') ?>

<style>
    .history-card {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .history-title {
        font-size: 24px;
        font-weight: 800;
        color: #3D3426;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .history-title svg {
        width: 28px;
        height: 28px;
        color: #8B7355;
    }
    .history-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .history-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 16px;
        border-radius: 16px;
        background: #fcfcfc;
        border: 1px solid transparent;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }
    .history-item:hover {
        background: #fff;
        border-color: #E8DFD0;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
    }
    .history-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .history-icon-box.video { background: #fee2e2; color: #ef4444; }
    .history-icon-box.ebook { background: #ecfdf5; color: #10b981; }
    
    .history-info { flex: 1; min-width: 0; }
    .history-item-title {
        font-weight: 700;
        color: #3D3426;
        font-size: 15px;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-transform: capitalize;
    }
    .history-meta {
        display: flex;
        gap: 15px;
        font-size: 13px;
        color: #9C8E7A;
    }
    .history-meta span { display: flex; align-items: center; gap: 4px; }
    .history-meta svg { width: 14px; height: 14px; }

    .history-time {
        font-size: 12px;
        color: #B8A990;
        font-weight: 600;
        text-align: right;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state svg {
        width: 64px;
        height: 64px;
        color: #E8DFD0;
        margin-bottom: 16px;
    }
    .empty-state h3 {
        font-size: 18px;
        color: #3D3426;
        margin-bottom: 8px;
    }
    .empty-state p {
        color: #9C8E7A;
        font-size: 14px;
    }

    /* Sampul ebook kecil */
    .history-thumb {
        width: 80px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        background: #000;
        flex-shrink: 0;
    }
    .history-thumb.ebook {
        width: 45px;
        height: 60px;
    }
</style>

<div class="app-content">
    <div class="container-fluid">
        <div class="history-card">
            <h2 class="history-title">
                <i data-lucide="activity"></i>
                Log Aktivitas
            </h2>

            <?php if (empty($riwayat)): ?>
                <div class="empty-state">
                    <i data-lucide="clock"></i>
                    <h3>Belum ada log aktivitas</h3>
                    <p>Semua aktivitas menonton video atau membaca ebook dari user akan muncul di sini.</p>
                </div>
            <?php else: ?>
                <?php
                    $riwayat_ebook = array_filter($riwayat, fn($r) => $r['jenis_item'] === 'ebook');
                    $riwayat_video = array_filter($riwayat, fn($r) => $r['jenis_item'] === 'video');
                ?>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

                    <!-- Kolom Ebook -->
                    <div>
                        <div style="font-size:13px; font-weight:700; color:#10b981; background:#ecfdf5; padding:6px 14px; border-radius:10px; margin-bottom:14px; display:inline-flex; align-items:center; gap:6px;">
                            <i data-lucide="book-open" style="width:14px;height:14px;"></i> Ebook
                        </div>
                        <div class="history-list">
                            <?php if (empty($riwayat_ebook)): ?>
                                <div class="empty-state" style="padding:30px 10px;">
                                    <i data-lucide="book-open"></i>
                                    <p>Belum ada riwayat ebook.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($riwayat_ebook as $r): ?>
                                    <div class="history-item">
                                        <?php if ($r['sampul_ebook']): ?>
                                            <img src="<?= base_url('uploads/ebook/sampul/' . $r['sampul_ebook']) ?>" class="history-thumb ebook" alt="Sampul">
                                        <?php else: ?>
                                            <div class="history-icon-box ebook"><i data-lucide="book-open"></i></div>
                                        <?php endif; ?>
                                        <div class="history-info">
                                            <div class="history-item-title"><?= $r['judul_ebook'] ?></div>
                                            <div class="history-meta" style="flex-wrap:wrap; row-gap:4px;">
                                                <span style="color:#6366f1;font-weight:700;background:rgba(99,102,241,0.08);padding:2px 8px;border-radius:6px;">
                                                    <i data-lucide="user" style="width:12px;height:12px;"></i> <?= esc($r['nama_lengkap']) ?>
                                                </span>
                                                <span><i data-lucide="book-open-check"></i> Hal <?= $r['halaman_terakhir'] ?></span>
                                                <span><i data-lucide="calendar"></i> <?= date('d M Y', strtotime($r['updated_at'])) ?></span>
                                            </div>
                                        </div>
                                        <div class="history-time"><?= time_ago($r['updated_at']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Kolom Video -->
                    <div>
                        <div style="font-size:13px; font-weight:700; color:#ef4444; background:#fee2e2; padding:6px 14px; border-radius:10px; margin-bottom:14px; display:inline-flex; align-items:center; gap:6px;">
                            <i data-lucide="play-circle" style="width:14px;height:14px;"></i> Video
                        </div>
                        <div class="history-list">
                            <?php if (empty($riwayat_video)): ?>
                                <div class="empty-state" style="padding:30px 10px;">
                                    <i data-lucide="play-circle"></i>
                                    <p>Belum ada riwayat video.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($riwayat_video as $r): ?>
                                    <div class="history-item">
                                        <?php if (!empty($r['kode_video'])): $ytId = base64_decode($r['kode_video']); ?>
                                            <img src="https://img.youtube.com/vi/<?= $ytId ?>/mqdefault.jpg" class="history-thumb" alt="Video">
                                        <?php else: ?>
                                            <div class="history-icon-box video"><i data-lucide="play-circle"></i></div>
                                        <?php endif; ?>
                                        <div class="history-info">
                                            <div class="history-item-title"><?= $r['judul_video'] ?></div>
                                            <div class="history-meta" style="flex-wrap:wrap; row-gap:4px;">
                                                <span style="color:#6366f1;font-weight:700;background:rgba(99,102,241,0.08);padding:2px 8px;border-radius:6px;">
                                                    <i data-lucide="user" style="width:12px;height:12px;"></i> <?= esc($r['nama_lengkap']) ?>
                                                </span>
                                                <span><i data-lucide="clock"></i> Menit <?= floor($r['durasi'] / 60) . ':' . sprintf('%02d', $r['durasi'] % 60) ?></span>
                                                <span><i data-lucide="calendar"></i> <?= date('d M Y', strtotime($r['updated_at'])) ?></span>
                                            </div>
                                        </div>
                                        <div class="history-time"><?= time_ago($r['updated_at']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>

<?= view('Partials/v_footer') ?>
