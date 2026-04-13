<?php /* View: Perpustakaan — halaman gabungan ebook & video di satu tempat */ ?>
<style>
    /* ============================================
       PERPUSTAKAAN UI — Combined Library Theme
       ============================================ */

    /* Memaksa background dashboard menjadi putih seragam */
    body, #content-wrapper, #content, .container-fluid, .app-content {
        background-color: #ffffff !important;
    }

    /* ── Section Filter Bar (di bawah topbar) ── */
    .perpus-filter-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        background: #fff;
        border-radius: 16px;
        padding: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.06);
    }
    .perpus-filter-tabs {
        display: flex;
        gap: 4px;
        flex: 1;
    }
    .perpus-filter-tab {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
        color: #9C8E7A;
        position: relative;
        overflow: hidden;
    }
    .perpus-filter-tab::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .perpus-filter-tab:hover:not(.active) {
        color: #3D3426;
        background: #f8f5f0;
    }
    .perpus-filter-tab.active {
        background: #3D3426;
        color: #fff;
        box-shadow: 0 4px 16px rgba(61,52,38,0.2);
    }
    .perpus-filter-tab svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        transition: transform 0.3s;
    }

    #tabEbook:hover svg, #tabEbook.active svg {
        animation: flipIcon 2.5s infinite ease-in-out;
    }
    #tabVideo:hover svg, #tabVideo.active svg {
        animation: pulseIcon 2s infinite ease-in-out;
    }

    @keyframes flipIcon {
        0% { transform: perspective(200px) rotateY(0deg); }
        40% { transform: perspective(200px) rotateY(180deg); }
        50% { transform: perspective(200px) rotateY(180deg); }
        90% { transform: perspective(200px) rotateY(360deg); }
        100% { transform: perspective(200px) rotateY(360deg); }
    }
    @keyframes pulseIcon {
        0% { transform: scale(1); }
        25% { transform: scale(1.18) rotate(5deg); }
        50% { transform: scale(1); }
        75% { transform: scale(1.18) rotate(-5deg); }
        100% { transform: scale(1); }
    }
    .perpus-filter-tab .tab-count {
        font-size: 11px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 20px;
        background: rgba(0,0,0,0.08);
        transition: all 0.3s;
    }
    .perpus-filter-tab.active .tab-count {
        background: rgba(255,255,255,0.2);
    }

    /* ── Content Sections ── */
    .perpus-section {
        display: none;
        animation: fadeInSection 0.4s ease;
    }
    .perpus-section.active {
        display: block;
    }
    @keyframes fadeInSection {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ============================
       BOOKSHELF STYLES (EBOOK)
       ============================ */
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

    /* The Shelf */
    .bookshelf {
        position: relative;
        padding: 24px 20px 0 20px;
        min-height: 220px;
    }
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

    /* Individual Book */
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
        height: 32.2px;
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

    /* Modal PDF Viewer */
    #modalPdf { display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.95); backdrop-filter: blur(12px); align-items:center; justify-content:center; }
    #modalPdf.show { display:flex; }
    #modalPdf .pdf-wrap { position:relative; width:100%; height:100vh; display: flex; flex-direction: column; }
    #modalPdf .pdf-wrap iframe { width:100%; height:100%; border:none; border-radius:0; }
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

    /* ============================
       VIDEO GALLERY STYLES
       ============================ */
    .btn-add-video {
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
    .btn-add-video:hover {
        background: #6B5B45;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139,115,85,0.35);
    }
    .btn-add-video svg { width: 18px; height: 18px; }

    /* Video Grid */
    .video-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
    }
    .vid-card { width: calc((100% - 48px) / 3); }
    .vid-card:nth-child(7n+4),
    .vid-card:nth-child(7n+5),
    .vid-card:nth-child(7n+6),
    .vid-card:nth-child(7n+7) { width: calc((100% - 72px) / 4); }
    @media (max-width: 992px) {
        .vid-card { width: calc((100% - 24px) / 2) !important; }
    }
    @media (max-width: 576px) {
        .vid-card { width: 100% !important; }
    }

    .vid-card {
        background: transparent;
        border-radius: 20px;
        overflow: hidden;
        transition: background 0.3s, box-shadow 0.3s;
        box-shadow: none;
        border: none;
    }
    .vid-card:hover {
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }
    .vid-card:nth-child(7n+1):hover { background: #FFF0F0; }
    .vid-card:nth-child(7n+2):hover { background: #F0F4FF; }
    .vid-card:nth-child(7n+3):hover { background: #F0FFF4; }
    .vid-card:nth-child(7n+4):hover { background: #FFFBF0; }
    .vid-card:nth-child(7n+5):hover { background: #F5F0FF; }
    .vid-card:nth-child(7n+6):hover { background: #FFF0FB; }
    .vid-card:nth-child(7n+7):hover { background: #F0FFFE; }

    .vid-thumb {
        position: relative;
        width: 100%;
        padding-top: 56.25%;
        background: #1a1a1a;
        overflow: hidden;
        cursor: pointer;
        border-radius: 16px;
        margin: 6px 6px 0 6px;
        width: calc(100% - 12px);
    }
    .vid-thumb img {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.4s;
    }
    .vid-thumb iframe {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        border: none;
        display: none;
    }
    .vid-thumb.playing img { display: none; }
    .vid-thumb.playing iframe { display: block; }

    .vid-thumb-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s;
        z-index: 2;
    }
    .vid-card:hover .vid-thumb-overlay { opacity: 1; }
    .vid-thumb.playing .vid-thumb-overlay { display: none; }

    .vid-play-btn {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        width: 64px;
        height: 64px;
        background: rgba(255,255,255,0.95);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
        transition: all 0.3s;
        opacity: 0;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        border: none;
        cursor: pointer;
    }
    .vid-card:hover .vid-play-btn {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
    .vid-play-btn:hover {
        background: #fff;
        transform: translate(-50%, -50%) scale(1.1) !important;
    }
    .vid-play-btn svg {
        width: 28px;
        height: 28px;
        color: #ef4444;
        margin-left: 3px;
    }
    .vid-thumb.playing .vid-play-btn { display: none; }

    .vid-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 4;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        backdrop-filter: blur(8px);
    }
    .vid-badge.privat {
        background: rgba(239,68,68,0.85);
        color: #fff;
    }

    .vid-fullscreen {
        position: absolute;
        bottom: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(4px);
        border: none;
        border-radius: 10px;
        color: #fff;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 4;
        transition: background 0.2s;
    }
    .vid-fullscreen:hover { background: rgba(0,0,0,0.85); }
    .vid-fullscreen svg { width: 16px; height: 16px; }
    .vid-thumb.playing .vid-fullscreen { display: flex; }

    .vid-body {
        padding: 20px;
    }
    .vid-title {
        font-size: 15px;
        font-weight: 700;
        color: #3D3426;
        margin-bottom: 6px;
        line-height: 1.4;
        text-transform: capitalize;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .vid-desc {
        font-size: 12px;
        color: #9C8E7A;
        margin-bottom: 14px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .vid-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .vid-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #B8A990;
    }
    .vid-meta svg { width: 14px; height: 14px; }
    .vid-actions {
        display: flex;
        gap: 4px;
    }
    .vid-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s;
        color: #B8A990;
    }
    .vid-action-btn:hover {
        background: #F0EBE0;
        color: #3D3426;
    }
    .vid-action-btn.danger:hover {
        background: #fef2f2;
        color: #ef4444;
    }
    .vid-action-btn svg { width: 16px; height: 16px; }

    .empty-cinema {
        text-align: center;
        padding: 80px 40px;
        background: #fff;
        border-radius: 24px;
        border: 2px dashed #D4C4A8;
    }
    .empty-cinema-icon { font-size: 64px; margin-bottom: 16px; }
    .empty-cinema h3 { font-size: 18px; font-weight: 700; color: #3D3426; margin-bottom: 8px; }
    .empty-cinema p { font-size: 13px; color: #9C8E7A; }

    #noVideoResults {
        text-align: center;
        padding: 60px 20px;
    }

    /* Cinema Search */
    .cinema-search {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 32px;
        background: #fff;
        border-radius: 16px;
        padding: 8px 8px 8px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.06);
    }
    .cinema-search-input {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 12px;
    }
    .cinema-search-input svg { width: 18px; height: 18px; color: #B8A990; flex-shrink: 0; }
    .cinema-search-input input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 14px;
        color: #3D3426;
        width: 100%;
        font-family: inherit;
    }
    .cinema-search-input input::placeholder { color: #C4B8A8; }

    /* ── Modal Form Styles (shared) ── */
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

<div class="app-content">

    <!-- ═══════════════════════════════════════════════
         FILTER BAR — Icon Buku & Video
         ═══════════════════════════════════════════════ -->
    <div class="perpus-filter-bar">
        <div class="perpus-filter-tabs">
            <!-- Tab Ebook -->
            <button class="perpus-filter-tab active" onclick="switchSection('ebook', this)" id="tabEbook">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Ebook
                <span class="tab-count"><?= count($ebooks ?? []) ?></span>
            </button>
            <!-- Tab Video -->
            <button class="perpus-filter-tab" onclick="switchSection('video', this)" id="tabVideo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                </svg>
                Video
                <span class="tab-count"><?= count($videos ?? []) ?></span>
            </button>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════
         SECTION: EBOOK (Bookshelf)
         ═══════════════════════════════════════════════ -->
    <div class="perpus-section active" id="sectionEbook">



        <!-- Stats -->
        <?php if (session()->get('user_role') === 'admin'): ?>
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
        <?php endif; ?>

        <!-- Search Bar -->
        <div class="library-search">
            <?php if (session()->get('user_role') === 'admin'): ?>
            <div class="library-tabs">
                <button class="library-tab active" onclick="filterBooks('all', this)">Semua</button>
                <button class="library-tab" onclick="filterBooks('publik', this)">Publik</button>
                <button class="library-tab" onclick="filterBooks('privat', this)">Privat</button>
            </div>
            <?php endif; ?>
            <div class="library-search-input">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchEbook" placeholder="Cari ebook di perpustakaan..." oninput="searchBooks(this.value)">
            </div>
        </div>

        <?php if (empty($ebooks)): ?>
        <div class="empty-library">
            <div class="empty-library-icon">📖</div>
            <h3>Perpustakaan Masih Kosong</h3>
            <p>Belum ada ebook yang ditambahkan ke koleksi perpustakaan.</p>
        </div>
        <?php else: ?>

        <?php
            $colorPalettes = ['cover-palette-1','cover-palette-2','cover-palette-3','cover-palette-4','cover-palette-5','cover-palette-6'];
        ?>

        <div class="shelf-section" id="shelf-all">
            <div class="shelf-section-header">
                <div>
                    <span class="shelf-section-count" style="margin-left: 0; font-size: 14px; color: #3D3426;"><?= count($ebooks) ?> buku terdaftar</span>
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
                        <div class="book-title-label">
                            <?= strtolower(esc($e->judul_ebook)) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <?php if (session()->get('user_role') === 'admin'): ?>
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

    <!-- ═══════════════════════════════════════════════
         SECTION: VIDEO (Cinema)
         ═══════════════════════════════════════════════ -->
    <div class="perpus-section" id="sectionVideo">
        <!-- Search Bar -->
        <div class="cinema-search" style="margin-top: 10px; margin-bottom: 8px;">
            <div class="cinema-search-input" style="border-left: none; padding-left: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B8A990" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="searchVideo" placeholder="Cari video pembelajaran..." oninput="searchVideos(this.value)">
            </div>
        </div>

        <div class="d-flex justify-content-end" style="padding: 10px 0; margin-bottom: 24px;">
            <?php if (session()->get('user_role') === 'admin'): ?>
            <button onclick="bukaModalTambahVideo()" class="btn-add-video" style="padding: 8px 16px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px; margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Video
            </button>
            <?php endif; ?>
        </div>

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
            <div class="vid-card" data-title="<?= strtolower(esc($v->judul_video)) ?>" data-status="<?= strtolower($v->status_video) ?>" data-vid-id="<?= $v->id_konten_video ?>" data-yt-id="<?= $v->youtube_id ?>">
                <div class="vid-thumb" id="thumb_<?= $v->id_konten_video ?>">
                    <img src="https://img.youtube.com/vi/<?= $v->youtube_id ?>/hqdefault.jpg" alt="<?= esc($v->judul_video) ?>">
                    <div class="vid-thumb-overlay"></div>

                    <?php if (strtolower($v->status_video) !== 'publik'): ?>
                    <span class="vid-badge <?= strtolower($v->status_video) ?>"><?= $v->status_video ?></span>
                    <?php endif; ?>

                    <button class="vid-play-btn" onclick="putarVideo(<?= $v->id_konten_video ?>, '<?= $v->youtube_id ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </button>

                    <iframe id="iframe_<?= $v->id_konten_video ?>"
                        src=""
                        allowfullscreen
                        allow="autoplay; encrypted-media; fullscreen">
                    </iframe>

                    <button class="vid-fullscreen" onclick="layarPenuh(<?= $v->id_konten_video ?>)" title="Layar Penuh">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                        </svg>
                    </button>
                </div>

                <div class="vid-body">
                    <div class="vid-title"><?= strtolower(esc($v->judul_video)) ?></div>
                    <?php if ($v->deskripsi_video): ?>
                    <div class="vid-desc"><?= esc($v->deskripsi_video) ?></div>
                    <?php else: ?>
                    <div class="vid-desc" style="color:#D4C4A8; font-style:italic;">Belum ada deskripsi</div>
                    <?php endif; ?>
                    <div class="vid-footer">
                        <div class="vid-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            YouTube
                        </div>
                        <?php if (session()->get('user_role') === 'admin'): ?>
                        <div class="vid-actions">
                            <button onclick="bukaModalUbahVideo(<?= $v->id_konten_video ?>)" class="vid-action-btn" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button onclick="hapusVideo(<?= $v->id_konten_video ?>)" class="vid-action-btn danger" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- No results state -->
        <div id="noVideoResults" style="display:none; text-align:center; padding: 60px 20px;">
            <div style="font-size: 48px; margin-bottom: 12px;">🔍</div>
            <h4 style="font-size: 16px; color: #3D3426; font-weight: 700; margin-bottom: 6px;">Tidak ditemukan</h4>
            <p style="font-size: 13px; color: #9C8E7A;">Coba kata kunci lain untuk pencarian Anda.</p>
        </div>

        <?php endif; ?>
    </div>

</div>

<!-- Modal PDF Viewer -->
<div id="modalPdf">
    <div class="pdf-wrap">
        <button class="btn-tutup" onclick="tutupPdf()">&#x2715;</button>
        <iframe id="iframePdf" src=""></iframe>
    </div>
</div>

<?php if (session()->get('user_role') === 'admin'): ?>
<!-- Modal Tambah/Edit Ebook -->
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

<!-- Modal Tambah/Edit Video -->
<div id="modalVideo" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formVideo" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModalVideo">Tambah Video Baru</h5>
                    <div class="modal-subtitle" id="subjudulModalVideo">Lengkapi informasi di bawah untuk menambahkan konten video.</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pb-2">
                    <input type="hidden" name="id_konten_video" id="id_konten_video">

                    <div class="form-row-custom">
                        <label class="form-label-custom">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" name="judul_video" id="judul_video" class="form-control-custom" style="text-transform: capitalize;" placeholder="Masukkan judul video..." autocomplete="off" required>
                    </div>

                    <div class="form-row-custom">
                        <label class="form-label-custom">URL YouTube <span class="text-danger">*</span></label>
                        <input type="url" name="url_video" id="url_video" class="form-control-custom" placeholder="https://www.youtube.com/watch?v=..." autocomplete="off" required>
                        <span class="form-helper">Pastikan URL video disalin secara penuh dari address bar browser.</span>
                    </div>

                    <div class="form-row-custom">
                        <label class="form-label-custom">Deskripsi <span style="color:#94a3b8; font-weight:500; font-size:11px;">(Opsional)</span></label>
                        <textarea name="deskripsi_video" id="deskripsi_video" class="form-control-custom" rows="3" placeholder="Tambahkan deskripsi singkat mengenai isi konten video ini..."></textarea>
                    </div>

                    <div class="form-row-custom mb-0">
                        <label class="form-label-custom">Status Akses <span class="text-danger">*</span></label>
                        <select name="status_video" id="status_video" class="form-control-custom" required>
                            <option value="Publik">Publik</option>
                            <option value="Privat">Privat</option>
                        </select>
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
    // ═══════════════════════════════════════════════
    // SECTION SWITCHER — Perpustakaan Filter Tabs
    // ═══════════════════════════════════════════════
    function switchSection(section, btn) {
        // Update tab active state
        document.querySelectorAll('.perpus-filter-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        // Show/hide sections with animation
        document.querySelectorAll('.perpus-section').forEach(s => s.classList.remove('active'));

        if (section === 'ebook') {
            document.getElementById('sectionEbook').classList.add('active');
        } else {
            document.getElementById('sectionVideo').classList.add('active');
            // Re-initialize video hover listeners after section becomes visible
            initVideoHoverListeners();
        }

        // Re-render Lucide icons for newly visible sections
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    // ═══════════════════════════════════════════════
    // EBOOK FUNCTIONS
    // ═══════════════════════════════════════════════

    // Buka halaman baca ebook (tab baru dengan efek flip buku)
    function bacaEbook(uuid) {
        window.open('<?= base_url('perpustakaan/baca_ebook/') ?>' + uuid, '_blank');
    }

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
        var shelf = document.querySelector('.bookshelf');
        if (shelf) shelf.style.display = visibleCount === 0 ? 'none' : '';
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
        var shelf = document.querySelector('.bookshelf');
        if (shelf) shelf.style.display = visibleCount === 0 ? 'none' : '';
    }

    // ═══════════════════════════════════════════════
    // VIDEO FUNCTIONS
    // ═══════════════════════════════════════════════

    function putarVideo(id, ytId) {
        var thumb  = document.getElementById('thumb_' + id);
        var iframe = document.getElementById('iframe_' + id);
        iframe.src = 'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0&modestbranding=1&mute=1';
        thumb.classList.add('playing');
    }

    function stopVideo(id) {
        var thumb  = document.getElementById('thumb_' + id);
        var iframe = document.getElementById('iframe_' + id);
        iframe.src = '';
        thumb.classList.remove('playing');
    }

    function initVideoHoverListeners() {
        document.querySelectorAll('.vid-card').forEach(function(card) {
            // Only add listeners once
            if (card.dataset.hoverInit) return;
            card.dataset.hoverInit = 'true';

            var hoverTimer = null;
            card.addEventListener('mouseenter', function() {
                var vidId = card.dataset.vidId;
                var ytId  = card.dataset.ytId;
                hoverTimer = setTimeout(function() {
                    putarVideo(vidId, ytId);
                }, 400);
            });
            card.addEventListener('mouseleave', function() {
                clearTimeout(hoverTimer);
                var vidId = card.dataset.vidId;
                stopVideo(vidId);
            });
        });
    }
    // Initialize on page load
    initVideoHoverListeners();

    function layarPenuh(id) {
        var iframe = document.getElementById('iframe_' + id);
        if (iframe.requestFullscreen)       iframe.requestFullscreen();
        else if (iframe.webkitRequestFullscreen) iframe.webkitRequestFullscreen();
        else if (iframe.mozRequestFullScreen)    iframe.mozRequestFullScreen();
        else if (iframe.msRequestFullscreen)     iframe.msRequestFullscreen();
    }

    // Search videos by title
    function searchVideos(query) {
        const q = query.toLowerCase().trim();
        const cards = document.querySelectorAll('.vid-card');
        let visible = 0;
        cards.forEach(c => {
            if (!q || c.dataset.title.includes(q)) {
                c.style.display = '';
                visible++;
            } else {
                c.style.display = 'none';
            }
        });
        document.getElementById('noVideoResults').style.display = visible === 0 ? 'block' : 'none';
        var grid = document.querySelector('.video-grid');
        if (grid) grid.style.display = visible === 0 ? 'none' : '';
    }

    // ═══════════════════════════════════════════════
    // ADMIN CRUD (Ebook & Video)
    // ═══════════════════════════════════════════════
    <?php if (session()->get('user_role') === 'admin'): ?>
    const CSRF_NAME = '<?= csrf_token() ?>';
    const CSRF_HASH = '<?= csrf_hash() ?>';

    // ── Ebook CRUD ──
    function bukaModalTambahEbook() {
        document.getElementById('formEbook').reset();
        document.getElementById('id_konten_ebook').value = '';
        document.getElementById('judulModalEbook').innerHTML = 'Tambah Ebook';
        document.getElementById('pdf_required').style.display = 'inline';
        new bootstrap.Modal(document.getElementById('modalEbook')).show();
    }

    function bukaModalUbahEbook(id) {
        $.ajax({
            url: '<?= base_url('perpustakaan/ambil_ebook') ?>',
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

    $('#formEbook').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append(CSRF_NAME, CSRF_HASH);
        var isEdit = document.getElementById('id_konten_ebook').value !== '';
        var url = isEdit ? '<?= base_url('perpustakaan/ubah_ebook') ?>' : '<?= base_url('perpustakaan/simpan_ebook') ?>';
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

    function hapusEbook(id) {
        Swal.fire({ title: 'Hapus Ebook?', text: 'File PDF juga akan dihapus permanen.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
        .then((r) => {
            if (r.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('perpustakaan/hapus_ebook') ?>', type: 'POST',
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

    // ── Video CRUD ──
    function bukaModalTambahVideo() {
        document.getElementById('formVideo').reset();
        document.getElementById('id_konten_video').value = '';
        document.getElementById('judulModalVideo').innerHTML = 'Tambah Video Baru';
        document.getElementById('subjudulModalVideo').innerHTML = 'Lengkapi informasi di bawah untuk menambahkan konten video.';
        new bootstrap.Modal(document.getElementById('modalVideo')).show();
    }

    function bukaModalUbahVideo(id) {
        $.ajax({
            url: '<?= base_url('perpustakaan/ambil_video') ?>',
            type: 'POST',
            data: { id_konten_video: id, [CSRF_NAME]: CSRF_HASH },
            success: function(res) {
                var d = typeof res === 'string' ? JSON.parse(res) : res;
                document.getElementById('id_konten_video').value = d.id_konten_video;
                document.getElementById('judul_video').value     = d.judul_video;
                document.getElementById('url_video').value       = 'https://www.youtube.com/watch?v=' + d.kode_video;
                document.getElementById('deskripsi_video').value = d.deskripsi_video || '';
                document.getElementById('status_video').value    = d.status_video;
                document.getElementById('judulModalVideo').innerHTML = 'Edit Data Video';
                document.getElementById('subjudulModalVideo').innerHTML = 'Ubah informasi detail untuk konten video ini.';
                new bootstrap.Modal(document.getElementById('modalVideo')).show();
            }
        });
    }

    $('#formVideo').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append(CSRF_NAME, CSRF_HASH);
        var isEdit = document.getElementById('id_konten_video').value !== '';
        var url = isEdit ? '<?= base_url('perpustakaan/ubah_video') ?>' : '<?= base_url('perpustakaan/simpan_video') ?>';
        $.ajax({
            url: url, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
            success: function(res) {
                var d = typeof res === 'string' ? JSON.parse(res) : res;
                if (d.status) {
                    bootstrap.Modal.getInstance(document.getElementById('modalVideo')).hide();
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Video berhasil disimpan', showConfirmButton: false, timer: 1500 })
                        .then(() => location.reload());
                } else {
                    Swal.fire('Gagal!', d.msg || 'Terjadi kesalahan', 'error');
                }
            }
        });
    });

    function hapusVideo(id) {
        Swal.fire({ title: 'Hapus Video?', text: 'Data tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
        .then((r) => {
            if (r.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('perpustakaan/hapus_video') ?>', type: 'POST',
                    data: { id_konten_video: id, [CSRF_NAME]: CSRF_HASH },
                    success: function(res) {
                        var d = typeof res === 'string' ? JSON.parse(res) : res;
                        Swal.fire({ icon: d.status ? 'success' : 'error', title: d.status ? 'Berhasil!' : 'Gagal!', text: d.status ? 'Video berhasil dihapus' : 'Terjadi kesalahan', showConfirmButton: false, timer: 1500 })
                            .then(() => { if (d.status) location.reload(); });
                    }
                });
            }
        });
    }
    <?php endif; ?>
</script>
