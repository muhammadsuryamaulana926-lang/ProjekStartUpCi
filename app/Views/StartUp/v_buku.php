<?php /* View: Buku — halaman daftar ebook dengan tampilan rak buku perpustakaan */ ?>
<style>
    /* ============================================
       BOOKSHELF UI — Warm Library Theme
       ============================================ */

    /* Header */
    .library-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }
    .library-header h2 {
        font-size: 28px;
        font-weight: 800;
        color: #3D3426;
        letter-spacing: -0.5px;
        margin: 0;
    }
    .library-header .subtitle {
        font-size: 13px;
        color: #9C8E7A;
        font-weight: 500;
        margin: 4px 0 0 0;
    }

    /* Search Bar */
    .library-search {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
        background: #fff;
        border-radius: 16px;
        padding: 8px 8px 8px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.06);
    }
    .library-tabs {
        display: flex;
        gap: 4px;
    }
    .library-tab {
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        background: transparent;
        color: #9C8E7A;
    }
    .library-tab.active {
        background: #E8DFD0;
        color: #3D3426;
    }
    .library-tab:hover:not(.active) {
        color: #3D3426;
    }
    .library-search-input {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 12px;
        border-left: 1px solid #E8DFD0;
    }
    .library-search-input svg {
        width: 18px;
        height: 18px;
        color: #B8A990;
        flex-shrink: 0;
    }
    .library-search-input input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 14px;
        color: #3D3426;
        width: 100%;
        font-family: inherit;
    }
    .library-search-input input::placeholder {
        color: #C4B8A8;
    }

    /* Shelf Section */
    .shelf-section {
        margin-bottom: 12px;
    }
    .shelf-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 8px;
        margin-bottom: 20px;
    }
    .shelf-section-title {
        font-size: 20px;
        font-weight: 700;
        color: #3D3426;
        letter-spacing: -0.3px;
    }
    .shelf-section-count {
        font-size: 12px;
        font-weight: 600;
        color: #B8A990;
        margin-left: 10px;
    }
    .shelf-section-link {
        font-size: 13px;
        font-weight: 600;
        color: #B8A990;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: color 0.2s;
    }
    .shelf-section-link:hover {
        color: #3D3426;
    }

    /* The Shelf */
    .bookshelf {
        position: relative;
        padding: 24px 20px 0 20px;
        min-height: 220px;
    }

    /* Shelf board (the wooden plank) */
    .bookshelf::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(180deg, #D4C4A8 0%, #C2B08E 40%, #B09E7E 100%);
        border-radius: 0 0 6px 6px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.12), 0 2px 4px rgba(0,0,0,0.08);
    }

    /* Shelf shadow on wall */
    .bookshelf::before {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 10px;
        right: 10px;
        height: 12px;
        background: radial-gradient(ellipse at center, rgba(0,0,0,0.08) 0%, transparent 70%);
    }

    /* Books container */
    .books-row {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        padding-bottom: 20px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .books-row::-webkit-scrollbar { display: none; }

    /* Individual Book Wrapper to center title label */
    .book-item {
        position: relative;
        flex-shrink: 0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .book-item:hover {
        transform: translateY(-12px) scale(1.03);
        z-index: 5;
    }

    /* Fixed title label below book */
    .book-title-label {
        font-size: 11px;
        font-weight: 700;
        color: #3D3426;
        text-align: center;
        margin-top: 12px;
        width: 120px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-transform: capitalize;
        opacity: 0.85;
        height: 32.2px; /* Fixed height for 2 lines to keep shelf alignment */
    }

    .book-cover {
        width: 120px;
        height: 170px;
        border-radius: 4px 10px 10px 4px;
        overflow: hidden;
        position: relative;
        box-shadow: 
            4px 4px 12px rgba(0,0,0,0.15),
            1px 1px 3px rgba(0,0,0,0.1),
            inset -3px 0 6px rgba(0,0,0,0.05);
    }

    /* Book spine effect */
    .book-cover::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: linear-gradient(90deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.05) 50%, transparent 100%);
        z-index: 2;
    }

    /* Book shine effect */
    .book-cover::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 30%;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.08) 100%);
        z-index: 2;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .book-cover-default {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 12px;
        text-align: center;
    }

    .book-cover-default .book-emoji {
        font-size: 32px;
        margin-bottom: 8px;
        opacity: 0.6;
    }
    .book-cover-default .book-def-title {
        font-size: 10px;
        font-weight: 700;
        color: rgba(255,255,255,0.9);
        text-transform: capitalize;
        line-height: 1.3;
    }

    /* Book hover overlay */
    .book-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 30%, rgba(0,0,0,0.75) 100%);
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 10px;
        z-index: 3;
        border-radius: 4px 10px 10px 4px;
    }
    .book-item:hover .book-overlay {
        opacity: 1;
    }
    .book-overlay-title {
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 2px;
        text-transform: capitalize;
        line-height: 1.3;
    }
    .book-overlay-author {
        font-size: 9px;
        color: rgba(255,255,255,0.7);
        margin-bottom: 8px;
        text-transform: capitalize;
    }
    .book-overlay-actions {
        display: flex;
        gap: 6px;
    }
    .book-overlay-btn {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .book-overlay-btn svg {
        width: 14px;
        height: 14px;
    }
    .book-overlay-btn.btn-read {
        background: rgba(255,255,255,0.95);
        color: #3D3426;
    }
    .book-overlay-btn.btn-read:hover {
        background: #fff;
        transform: scale(1.1);
    }
    .book-overlay-btn.btn-edit {
        background: rgba(255,255,255,0.2);
        color: #fff;
    }
    .book-overlay-btn.btn-edit:hover {
        background: rgba(255,255,255,0.35);
    }
    .book-overlay-btn.btn-del {
        background: rgba(239,68,68,0.2);
        color: #fca5a5;
    }
    .book-overlay-btn.btn-del:hover {
        background: rgba(239,68,68,0.5);
        color: #fff;
    }

    /* Badge on book */
    .book-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 4;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 8px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        backdrop-filter: blur(4px);
    }
    .book-badge.publik {
        background: rgba(34,197,94,0.85);
        color: #fff;
    }
    .book-badge.privat {
        background: rgba(239,68,68,0.85);
        color: #fff;
    }

    /* Empty State */
    .empty-library {
        text-align: center;
        padding: 80px 40px;
        background: #fff;
        border-radius: 24px;
        border: 2px dashed #D4C4A8;
    }
    .empty-library-icon {
        font-size: 64px;
        margin-bottom: 16px;
    }
    .empty-library h3 {
        font-size: 18px;
        font-weight: 700;
        color: #3D3426;
        margin-bottom: 8px;
    }
    .empty-library p {
        font-size: 13px;
        color: #9C8E7A;
    }

    /* Color palette for default covers */
    .cover-palette-1 { background: linear-gradient(145deg, #8B7355, #6B5B45); }
    .cover-palette-2 { background: linear-gradient(145deg, #5B7B6F, #3D5B4F); }
    .cover-palette-3 { background: linear-gradient(145deg, #7B6B8B, #5B4B6B); }
    .cover-palette-4 { background: linear-gradient(145deg, #8B6B5B, #6B4B3B); }
    .cover-palette-5 { background: linear-gradient(145deg, #5B6B8B, #3B4B6B); }
    .cover-palette-6 { background: linear-gradient(145deg, #8B8B5B, #6B6B3B); }

    /* Add Book Button on shelf */
    .book-add-btn {
        width: 120px;
        height: 170px;
        border-radius: 4px 10px 10px 4px;
        border: 2px dashed #C4B8A8;
        background: rgba(255,255,255,0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s;
        flex-shrink: 0;
    }
    .book-add-btn:hover {
        border-color: #8B7355;
        background: rgba(255,255,255,0.8);
        transform: translateY(-4px);
    }
    .book-add-btn svg {
        width: 24px;
        height: 24px;
        color: #B8A990;
    }
    .book-add-btn span {
        font-size: 10px;
        font-weight: 700;
        color: #B8A990;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Modal PDF Viewer — Full Screen */
    #modalPdf { display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.95); backdrop-filter: blur(12px); align-items:center; justify-content:center; }
    #modalPdf.show { display:flex; }
    #modalPdf .pdf-wrap { position:relative; width:100%; height:100vh; display: flex; flex-direction: column; }
    #modalPdf .pdf-wrap iframe { width:100%; height:100%; border:none; border-radius:0; shadow: none; }
    #modalPdf .btn-tutup { 
        position:absolute; top:20px; right:30px; 
        background: rgba(255,255,255,0.2); border:none; color:#fff; 
        width: 44px; height: 44px; border-radius: 50%;
        font-size: 20px; cursor:pointer; line-height: 1;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s; backdrop-filter: blur(8px);
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    #modalPdf .btn-tutup:hover { background: rgba(255,255,255,0.3); transform: rotate(90deg) scale(1.1); }

    /* Btn styles for header */
    .btn-add-book {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #8B7355;
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(139,115,85,0.25);
    }
    .btn-add-book:hover {
        background: #6B5B45;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139,115,85,0.35);
    }
    .btn-add-book svg { width: 18px; height: 18px; }

    /* Stats */
    .library-stats {
        display: flex;
        gap: 24px;
        margin-bottom: 28px;
    }
    .library-stat {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .library-stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .library-stat-icon svg {
        width: 20px;
        height: 20px;
    }
    .library-stat-value {
        font-size: 20px;
        font-weight: 800;
        color: #3D3426;
        line-height: 1;
    }
    .library-stat-label {
        font-size: 11px;
        font-weight: 600;
        color: #9C8E7A;
        margin-top: 2px;
    }
</style>

<div class="app-content">
    <!-- Header -->
    <div class="library-header">
        <div>
            <div class="d-flex align-items-center gap-2">
                <i data-lucide="book-open" style="width: 28px; height: 28px; color: #8B7355;"></i>
                <h2 class="mb-0">Perpustakaan</h2>
            </div>
            <p class="subtitle">Koleksi ebook & referensi untuk startup</p>
        </div>
        <?php if (session()->get('user_role') === 'admin'): ?>
        <button onclick="bukaModalTambahEbook()" class="btn-add-book">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Ebook
        </button>
        <?php endif; ?>
    </div>

    <!-- Stats -->
    <div class="library-stats">
        <div class="library-stat">
            <div class="library-stat-icon" style="background: #F0EBE0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#8B7355"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <div class="library-stat-value"><?= count($ebooks ?? []) ?></div>
                <div class="library-stat-label">Total Ebook</div>
            </div>
        </div>
        <div class="library-stat">
            <div class="library-stat-icon" style="background: #E8F5E9;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#4CAF50"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <div>
                <div class="library-stat-value"><?= count(array_filter($ebooks ?? [], fn($e) => strtolower($e->status_ebook) === 'publik')) ?></div>
                <div class="library-stat-label">Publik</div>
            </div>
        </div>
        <div class="library-stat">
            <div class="library-stat-icon" style="background: #FFF3E0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#FF9800"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <div class="library-stat-value"><?= count(array_filter($ebooks ?? [], fn($e) => strtolower($e->status_ebook) === 'privat')) ?></div>
                <div class="library-stat-label">Privat</div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="library-search">
        <div class="library-tabs">
            <button class="library-tab active" onclick="filterBooks('all', this)">Semua</button>
            <button class="library-tab" onclick="filterBooks('publik', this)">Publik</button>
            <button class="library-tab" onclick="filterBooks('privat', this)">Privat</button>
        </div>
        <div class="library-search-input">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="searchEbook" placeholder="Cari ebook di perpustakaan..." oninput="searchBooks(this.value)">
        </div>
    </div>

    <?php if (empty($ebooks)): ?>
    <!-- Empty State -->
    <div class="empty-library">
        <div class="empty-library-icon">📖</div>
        <h3>Perpustakaan Masih Kosong</h3>
        <p>Belum ada ebook yang ditambahkan ke koleksi perpustakaan.</p>
    </div>
    <?php else: ?>

    <!-- Bookshelf: Koleksi Ebook -->
    <?php
        $publik_books = array_filter($ebooks, fn($e) => strtolower($e->status_ebook) === 'publik');
        $privat_books = array_filter($ebooks, fn($e) => strtolower($e->status_ebook) === 'privat');
        $colorPalettes = ['cover-palette-1','cover-palette-2','cover-palette-3','cover-palette-4','cover-palette-5','cover-palette-6'];
    ?>

    <!-- Shelf: Semua Buku -->
    <div class="shelf-section" id="shelf-all">
        <div class="shelf-section-header">
            <div>
                <span class="shelf-section-title">Koleksi Ebook</span>
                <span class="shelf-section-count"><?= count($ebooks) ?> buku</span>
            </div>
        </div>
        <div class="bookshelf">
            <div class="books-row" id="booksContainer">
                <?php foreach ($ebooks as $idx => $e): ?>
                <div class="book-item" data-title="<?= strtolower(esc($e->judul_ebook)) ?>" data-status="<?= strtolower($e->status_ebook) ?>">
                    <?php if (strtolower($e->status_ebook) !== 'publik'): ?>
                    <span class="book-badge <?= strtolower($e->status_ebook) ?>"><?= $e->status_ebook ?></span>
                    <?php endif; ?>
                    <div class="book-cover">
                        <?php if ($e->sampul_ebook && file_exists(FCPATH . 'uploads/ebook/sampul/' . $e->sampul_ebook)): ?>
                            <img src="<?= base_url('uploads/ebook/sampul/' . $e->sampul_ebook) ?>" alt="<?= esc($e->judul_ebook) ?>">
                        <?php else: ?>
                            <div class="book-cover-default <?= $colorPalettes[$idx % count($colorPalettes)] ?>">
                                <div class="book-emoji">📕</div>
                                <div class="book-def-title"><?= strtolower(esc(substr($e->judul_ebook, 0, 40))) ?></div>
                            </div>
                        <?php endif; ?>

                        <!-- Hover Overlay -->
                        <div class="book-overlay">
                            <div class="book-overlay-title"><?= strtolower(esc($e->judul_ebook)) ?></div>
                            <?php if ($e->penulis_ebook): ?>
                            <div class="book-overlay-author"><?= strtolower(esc($e->penulis_ebook)) ?></div>
                            <?php endif; ?>
                            <div class="book-overlay-actions">
                                <button onclick="bacaEbook('<?= $e->uuid_konten_ebook ?>')" class="book-overlay-btn btn-read" title="Baca">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </button>
                                <?php if (session()->get('user_role') === 'admin'): ?>
                                <button onclick="event.stopPropagation(); bukaModalUbahEbook(<?= $e->id_konten_ebook ?>)" class="book-overlay-btn btn-edit" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button onclick="event.stopPropagation(); hapusEbook(<?= $e->id_konten_ebook ?>)" class="book-overlay-btn btn-del" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Label Judul di bawah buku (Selalu Muncul) -->
                    <div class="book-title-label">
                        <?= strtolower(esc($e->judul_ebook)) ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php if (session()->get('user_role') === 'admin'): ?>
                <!-- Add Book Button on shelf -->
                <div class="book-add-btn" onclick="bukaModalTambahEbook()" style="margin-bottom: 44.2px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- No results state -->
    <div id="noResults" style="display:none; text-align:center; padding: 60px 20px;">
        <div style="font-size: 48px; margin-bottom: 12px;">🔍</div>
        <h4 style="font-size: 16px; color: #3D3426; font-weight: 700; margin-bottom: 6px;">Tidak ditemukan</h4>
        <p style="font-size: 13px; color: #9C8E7A;">Coba kata kunci lain untuk pencarian Anda.</p>
    </div>

    <?php endif; ?>
</div>

<!-- Modal PDF Viewer — file dibaca via streaming, path asli tidak terekspos -->
<div id="modalPdf">
    <div class="pdf-wrap">
        <button class="btn-tutup" onclick="tutupPdf()">&#x2715;</button>
        <iframe id="iframePdf" src=""></iframe>
    </div>
</div>

<?php if (session()->get('user_role') === 'admin'): ?>
<!-- Modal Tambah/Edit Ebook -->
<style>
    /* Styling Modal Modern Minimalis - Konsisten dengan Startup Form */
    .modal-content { border: none; border-radius: 20px; box-shadow: 0 24px 48px rgba(0,0,0,0.12); font-family: 'Inter', sans-serif; }
    .modal-header { background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 24px 32px; flex-direction: column; align-items: flex-start; position: relative; }
    .modal-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 0px; letter-spacing: -0.5px; }
    .modal-subtitle { font-size: 13px; color: #64748b; font-weight: 500; margin-top: 4px; }
    .modal-header .btn-close { position: absolute; top: 24px; right: 32px; opacity: 0.5; margin: 0; padding: 0; }
    
    .modal-body { padding: 32px; background: #ffffff; }
    
    .form-row-custom { margin-bottom: 16px; display: flex; flex-direction: column; }
    .form-label-custom { font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; }
    .text-danger { color: #ef4444; }
    
    .form-control-custom { width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 14px; color: #0f172a; background: #fff; transition: all 0.2s; outline: none; font-family: inherit; }
    .form-control-custom::placeholder { color: #94a3b8; }
    .form-control-custom:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); }
    select.form-control-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%2364748b'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right 14px center; background-size: 14px; padding-right: 36px;
    }
    input[type="file"].form-control-custom {
        padding: 7px 13px;
        cursor: pointer;
        color: #64748b;
    }
    
    .form-actions { border-top: 1px solid #f1f5f9; padding: 24px 32px; background: #f8fafc; display: flex; justify-content: flex-end; gap: 12px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;}
    .btn-submit-primary { background: #6366f1; border: 1.5px solid #6366f1; color: #ffffff !important; font-weight: 600; font-size: 14px; padding: 10px 32px; border-radius: 10px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 6px rgba(99, 102, 241, 0.2); }
    .btn-submit-primary:hover { background: #4f46e5; border-color: #4f46e5; box-shadow: 0 6px 12px rgba(99, 102, 241, 0.3); transform: translateY(-1px); }
    .btn-secondary-modern { background: #ffffff; border: 1.5px solid #cbd5e1; color: #475569 !important; font-weight: 600; font-size: 14px; padding: 10px 24px; border-radius: 10px; cursor: pointer; transition: all 0.2s; }
    .btn-secondary-modern:hover { background: #f1f5f9; color: #0f172a !important; }
    .form-helper { display: block; font-size: 11px; color: #94a3b8; margin-top: 6px; font-weight: 500; }
    
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .grid-2 .form-row-custom { margin-bottom: 0px; }
    @media (max-width: 576px) { .grid-2 { grid-template-columns: 1fr; } }
</style>

<div id="modalEbook" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEbook" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModalEbook">Tambah Ebook</h5>
                    <div class="modal-subtitle" id="subjudulModalEbook">Tambahkan referensi ebook untuk startup.</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pb-2">
                    <input type="hidden" name="id_konten_ebook" id="id_konten_ebook">

                    <div class="form-row-custom">
                        <label class="form-label-custom">Judul Ebook <span class="text-danger">*</span></label>
                        <input type="text" name="judul_ebook" id="judul_ebook" class="form-control-custom" style="text-transform: capitalize;" placeholder="Masukkan judul ebook" autocomplete="off" required>
                    </div>

                    <div class="grid-2">
                        <div class="form-row-custom">
                            <label class="form-label-custom">Penulis</label>
                            <input type="text" name="penulis_ebook" id="penulis_ebook" class="form-control-custom" style="text-transform: capitalize;" placeholder="Nama penulis" autocomplete="off">
                        </div>
                        <div class="form-row-custom">
                            <label class="form-label-custom">Status Akses <span class="text-danger">*</span></label>
                            <select name="status_ebook" id="status_ebook" class="form-control-custom" required>
                                <option value="Publik">Publik</option>
                                <option value="Privat">Privat</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row-custom">
                        <label class="form-label-custom">Deskripsi <span style="color:#94a3b8; font-weight:500; font-size:11px;">(Opsional)</span></label>
                        <textarea name="deskripsi_ebook" id="deskripsi_ebook" class="form-control-custom" rows="3" placeholder="Deskripsi singkat ebook..."></textarea>
                    </div>

                    <div class="grid-2 mb-0">
                        <div class="form-row-custom mb-0">
                            <label class="form-label-custom">File PDF <span class="text-danger" id="pdf_required">*</span></label>
                            <input type="file" name="file_ebook" id="file_ebook" class="form-control-custom" accept=".pdf">
                            <span class="form-helper">Format wajib: .pdf</span>
                        </div>
                        <div class="form-row-custom mb-0">
                            <label class="form-label-custom">Gambar Sampul</label>
                            <input type="file" name="sampul_ebook" class="form-control-custom" accept=".jpg,.jpeg,.png">
                            <span class="form-helper">Opsional (.jpg, .png)</span>
                        </div>
                    </div>
                </div>
                <div class="form-actions mt-3">
                    <button type="button" class="btn-secondary-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    // Buka PDF viewer dengan streaming via route baca_ebook (path asli tidak terekspos)
    function bacaEbook(uuid) {
        document.getElementById('iframePdf').src = '<?= base_url('konten/baca_ebook/') ?>' + uuid;
        document.getElementById('modalPdf').classList.add('show');
    }

    // Tutup PDF viewer dan hentikan streaming
    function tutupPdf() {
        document.getElementById('iframePdf').src = '';
        document.getElementById('modalPdf').classList.remove('show');
    }

    // Tutup PDF viewer jika klik di luar area
    document.getElementById('modalPdf').addEventListener('click', function(e) {
        if (e.target === this) tutupPdf();
    });

    // Filter books by status
    function filterBooks(status, btn) {
        document.querySelectorAll('.library-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        const books = document.querySelectorAll('.book-item');
        let visibleCount = 0;
        books.forEach(b => {
            if (status === 'all' || b.dataset.status === status) {
                b.style.display = '';
                visibleCount++;
            } else {
                b.style.display = 'none';
            }
        });

        document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
        document.querySelector('.bookshelf').style.display = visibleCount === 0 ? 'none' : '';
    }

    // Search books by title
    function searchBooks(query) {
        const q = query.toLowerCase().trim();
        const books = document.querySelectorAll('.book-item');
        let visibleCount = 0;
        books.forEach(b => {
            if (!q || b.dataset.title.includes(q)) {
                b.style.display = '';
                visibleCount++;
            } else {
                b.style.display = 'none';
            }
        });

        document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
        document.querySelector('.bookshelf').style.display = visibleCount === 0 ? 'none' : '';
    }

    <?php if (session()->get('user_role') === 'admin'): ?>
    const CSRF_NAME = '<?= csrf_token() ?>';
    const CSRF_HASH = '<?= csrf_hash() ?>';

    // Buka modal dalam mode tambah ebook baru
    function bukaModalTambahEbook() {
        document.getElementById('formEbook').reset();
        document.getElementById('id_konten_ebook').value = '';
        document.getElementById('judulModalEbook').innerHTML = 'Tambah Ebook';
        document.getElementById('pdf_required').style.display = 'inline';
        new bootstrap.Modal(document.getElementById('modalEbook')).show();
    }

    // Buka modal dalam mode edit, ambil data ebook via AJAX
    function bukaModalUbahEbook(id) {
        $.ajax({
            url: '<?= base_url('konten/ambil_ebook') ?>',
            type: 'POST',
            data: { id_konten_ebook: id, [CSRF_NAME]: CSRF_HASH },
            success: function(res) {
                var d = typeof res === 'string' ? JSON.parse(res) : res;
                document.getElementById('id_konten_ebook').value  = d.id_konten_ebook;
                document.getElementById('judul_ebook').value      = d.judul_ebook;
                document.getElementById('penulis_ebook').value    = d.penulis_ebook || '';
                document.getElementById('deskripsi_ebook').value  = d.deskripsi_ebook || '';
                document.getElementById('status_ebook').value     = d.status_ebook;
                document.getElementById('judulModalEbook').innerHTML = 'Edit Ebook';
                document.getElementById('pdf_required').style.display = 'none';
                new bootstrap.Modal(document.getElementById('modalEbook')).show();
            }
        });
    }

    // Submit form tambah/edit ebook via AJAX
    $('#formEbook').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append(CSRF_NAME, CSRF_HASH);
        var isEdit = document.getElementById('id_konten_ebook').value !== '';
        var url = isEdit ? '<?= base_url('konten/ubah_ebook') ?>' : '<?= base_url('konten/simpan_ebook') ?>';
        $.ajax({
            url: url, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
            success: function(res) {
                var d = typeof res === 'string' ? JSON.parse(res) : res;
                if (d.status) {
                    bootstrap.Modal.getInstance(document.getElementById('modalEbook')).hide();
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Ebook berhasil disimpan', showConfirmButton: false, timer: 1500 })
                        .then(() => location.reload());
                } else {
                    Swal.fire('Gagal!', d.msg || 'Terjadi kesalahan', 'error');
                }
            }
        });
    });

    // Konfirmasi dan hapus ebook via AJAX
    function hapusEbook(id) {
        Swal.fire({ title: 'Hapus Ebook?', text: 'File PDF juga akan dihapus permanen.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
        .then((r) => {
            if (r.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('konten/hapus_ebook') ?>', type: 'POST',
                    data: { id_konten_ebook: id, [CSRF_NAME]: CSRF_HASH },
                    success: function(res) {
                        var d = typeof res === 'string' ? JSON.parse(res) : res;
                        Swal.fire({ icon: d.status ? 'success' : 'error', title: d.status ? 'Berhasil!' : 'Gagal!', text: d.status ? 'Ebook berhasil dihapus' : 'Terjadi kesalahan', showConfirmButton: false, timer: 1500 })
                            .then(() => { if (d.status) location.reload(); });
                    }
                });
            }
        });
    }
    <?php endif; ?>
</script>