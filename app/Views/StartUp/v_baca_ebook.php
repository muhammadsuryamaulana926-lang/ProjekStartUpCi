<?php /* View: Baca Ebook dengan Light Theme Flat (Tanpa Border Container, Tombol Bawah Ber-border) */ ?>
<link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
<style>
    .reader-wrapper *, .reader-wrapper *::before, .reader-wrapper *::after { box-sizing: border-box; }

    /* Memaksa background seluruh dashboard (di luar ebook) menjadi putih juga */
    body, #content-wrapper, #content, .container-fluid, .app-content {
        background-color: #ffffff !important;
    }

    .reader-wrapper {
        font-family: 'Inter', sans-serif;
        user-select: none;
        width: 100%;
        height: calc(100vh - 120px);
        margin-bottom: 20px;
        position: relative;
    }

    /* ── SVG Noise Filter (for paper grain) ── */
    .svg-filters { position: absolute; width: 0; height: 0; }

    /* ── Loading Overlay ── */
    .loading-overlay {
        position: absolute;
        inset: 0;
        z-index: 9999;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 28px;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    .loading-overlay.hidden {
        opacity: 0;
        pointer-events: none;
    }
    .loading-book-anim {
        width: 90px;
        height: 90px;
        position: relative;
    }
    .loading-book-anim .page-l,
    .loading-book-anim .page-r {
        position: absolute;
        width: 38px;
        height: 54px;
        border: none !important;
        background: rgba(0,0,0,0.05);
        top: 18px;
    }
    .loading-book-anim .page-l {
        left: 6px;
        border-radius: 4px 0 0 4px;
    }
    .loading-book-anim .page-r {
        right: 6px;
        border-radius: 0 4px 4px 0;
    }
    .loading-book-anim .flip {
        position: absolute;
        width: 38px;
        height: 54px;
        top: 18px;
        right: 44px;
        border: none !important;
        border-radius: 0 4px 4px 0;
        transform-origin: left center;
        animation: flipPage 1.4s ease-in-out infinite;
        background: rgba(0,0,0,0.08);
    }
    @keyframes flipPage {
        0%   { transform: rotateY(0deg); }
        50%  { transform: rotateY(-180deg); }
        100% { transform: rotateY(-180deg); }
    }
    .loading-text {
        font-size: 13px;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }
    .loading-progress {
        width: 200px;
        height: 3px;
        background: #f1f5f9;
        overflow: hidden;
        border: none !important;
        box-shadow: none !important;
    }
    .loading-progress-bar {
        height: 100%;
        background: #3b82f6;
        width: 0%;
        transition: width 0.3s;
    }

    /* ── Reader Layout ── */
    .reader-container {
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
        background: #ffffff !important;
        overflow: hidden !important;
        position: relative !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* Ensure NO border on any canvas or internal containers */
    .reader-container canvas, 
    .reader-container div, 
    .reader-container a, 
    .reader-container button { 
        outline: none !important; 
        border-color: transparent;
    }

    /* ── Header Bar ── */
    .reader-header {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 10px 28px 0 28px;
        background: transparent;
        flex-shrink: 0;
        height: 56px;
        z-index: 100;
        position: relative;
        border: none !important;
        box-shadow: none !important;
    }
    .reader-header-left {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 16px !important;
        flex: 1 !important;
        min-width: 0 !important;
    }
    .btn-back {
        width: 36px; height: 36px;
        border-radius: 50%;
        border: none !important;
        background: transparent;
        color: #000000;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.25s;
        text-decoration: none;
        flex-shrink: 0;
        box-shadow: none !important;
    }
    .btn-back:hover { color: #3b82f6; transform: scale(1.1); }
    .btn-back svg { width: 18px; height: 18px; }
    .reader-book-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-transform: capitalize;
        letter-spacing: -0.2px;
        min-width: 0;
    }
    .reader-book-author {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        text-transform: capitalize;
        font-family: 'Crimson Text', serif;
        font-style: italic;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .reader-header-right {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-shrink: 0 !important;
    }
    .header-btn {
        width: 36px; height: 36px;
        border-radius: 50%;
        border: none !important;
        background: transparent !important;
        color: #000000;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.25s;
        box-shadow: none !important;
    }
    .header-btn:hover { color: #3b82f6; transform: scale(1.1); }
    .header-btn svg { width: 18px; height: 18px; }
    .header-btn.active { color: #3b82f6; }

    /* ── Main Book Area ── */
    .reader-body {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        padding: 16px 0;
        perspective: 2500px;
        z-index: 1;
        border: none !important;
    }

    /* Navigation Arrows */
    .nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 48px;
        height: 72px;
        background: transparent;
        border: none !important;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #000000;
        z-index: 50;
        opacity: 0.7;
        box-shadow: none !important;
    }
    .nav-arrow:hover {
        color: #000000;
        opacity: 1;
        background: rgba(0, 0, 0, 0.05);
        transform: translateY(-50%) scale(1.1);
    }
    .nav-arrow:active { transform: translateY(-50%) scale(0.96); }
    .nav-arrow svg { width: 22px; height: 22px; }
    .nav-arrow.left { left: 24px; }
    .nav-arrow.right { right: 24px; }

    /* ── Book Container ── */
    #bookContainer {
        position: relative;
        z-index: 5;
        transform-style: preserve-3d;
    }

    /* Book outer shadow */
    .stf__parent {
        box-shadow:
            0 4px 10px rgba(0,0,0,0.05),
            0 10px 25px rgba(0,0,0,0.08),
            0 25px 50px rgba(0,0,0,0.12) !important;
        border-radius: 0 4px 4px 0;
    }

    /* Page edge stacking */
    .book-edge-bottom {
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 8px);
        height: 5px;
        background: linear-gradient(180deg, #e2e8f0 0%, #cbd5e1 30%, #94a3b8 100%);
        z-index: 4;
        pointer-events: none;
        border-radius: 0 0 2px 2px;
    }
    .book-edge-right {
        position: absolute;
        top: 4px;
        right: -4px;
        width: 4px;
        height: calc(100% - 8px);
        background: linear-gradient(90deg, #e2e8f0 0%, #cbd5e1 50%, #94a3b8 100%);
        z-index: 4;
        pointer-events: none;
        border-radius: 0 2px 2px 0;
    }
    .book-edge-left {
        position: absolute;
        top: 4px;
        left: -4px;
        width: 4px;
        height: calc(100% - 8px);
        background: linear-gradient(270deg, #e2e8f0 0%, #cbd5e1 50%, #94a3b8 100%);
        z-index: 4;
        pointer-events: none;
        border-radius: 2px 0 0 2px;
    }

    /* ── Page Styles ── */
    .page {
        background: #fdfdfc;
        overflow: hidden;
        position: relative;
    }
    .page::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(139,115,85,0.005) 2px, rgba(139,115,85,0.005) 4px),
            repeating-linear-gradient(90deg, transparent, transparent 3px, rgba(139,115,85,0.003) 3px, rgba(139,115,85,0.003) 6px);
        pointer-events: none;
        z-index: 3;
        mix-blend-mode: multiply;
        filter: url(#paper-noise);
    }
    /* Default page inner shadow (spine crease) */
    .page::after {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 4;
        transition: opacity 0.3s;
    }

    /* LEFT pages: Spine is on the right side */
    .page-left::after {
        background: linear-gradient(90deg,
            transparent 0%,
            transparent 85%,
            rgba(0,0,0,0.06) 95%,
            rgba(0,0,0,0.18) 100%
        );
    }

    /* RIGHT pages: Spine is on the left side */
    .page-right::after {
        background: linear-gradient(90deg,
            rgba(0,0,0,0.18) 0%,
            rgba(0,0,0,0.06) 5%,
            transparent 15%,
            transparent 100%
        );
    }
    .page canvas {
        display: block;
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 1;
    }
    .page-loading {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 14px;
        background: radial-gradient(ellipse at center, #ffffff, #f8fafc);
        z-index: 2;
    }
    .page-loading-spinner {
        width: 28px; height: 28px;
        border: 2px solid transparent;
        border-top: 2px solid #3b82f6;
        border-radius: 50%;
        animation: spin 0.9s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .page-loading-text {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .page-number {
        position: absolute;
        bottom: 16px;
        font-size: 10px;
        font-weight: 600;
        color: #94a3b8;
        pointer-events: none;
        z-index: 5;
        font-family: 'Inter', sans-serif;
    }
    .page-number.left { left: 24px; }
    .page-number.right { right: 24px; }

    /* ── Cover Pages ── */
    .page-cover {
        background: linear-gradient(145deg, #5A4C3D, #3D3426, #231C14);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .page-cover::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.06) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(255,255,255,0.04) 0%, transparent 50%);
        pointer-events: none;
        z-index: 1;
        filter: url(#paper-noise);
    }
    .page-cover::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg,
            rgba(0,0,0,0.18) 0%,
            rgba(0,0,0,0.05) 5%,
            transparent 15%,
            transparent 85%,
            rgba(0,0,0,0.05) 95%,
            rgba(0,0,0,0.18) 100%
        );
        pointer-events: none;
        z-index: 2;
    }
    .page-cover > * { position: relative; z-index: 3; }
    .page-cover-img {
        width: 60%;
        max-height: 50%;
        object-fit: contain;
        border-radius: 4px;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .page-cover-title {
        font-size: 22px;
        font-weight: 800;
        color: #ffffff;
        text-transform: capitalize;
        line-height: 1.35;
        margin-bottom: 8px;
        letter-spacing: -0.3px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    .page-cover-author {
        font-size: 14px;
        font-weight: 400;
        color: #E8DFD0;
        font-family: 'Crimson Text', serif;
        font-style: italic;
    }
    .page-cover-ornament {
        width: 50px;
        height: 2px;
        background: #9C8E7A;
        margin: 16px 0;
        border-radius: 2px;
    }

    .page-endpaper {
        background: radial-gradient(ellipse at 50% 50%, #ffffff, #f1f5f9);
        display: flex; align-items: center; justify-content: center;
    }
    .page-endpaper::before {
        content: ''; position: absolute; inset: 0; opacity: 0.5;
        background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(0,0,0,0.01) 10px, rgba(0,0,0,0.01) 20px),
                          repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(0,0,0,0.01) 10px, rgba(0,0,0,0.01) 20px);
        pointer-events: none; filter: url(#paper-noise);
    }
    .endpaper-text {
        font-family: 'Crimson Text', serif; font-size: 12px; color: #94a3b8;
        font-style: italic; letter-spacing: 0.1em; text-transform: uppercase;
    }

    .page-cover-back {
        background: linear-gradient(145deg, #3D3426, #231C14);
        display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;
    }
    .page-cover-back::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg,
            rgba(0,0,0,0.18) 0%,
            rgba(0,0,0,0.05) 5%,
            transparent 15%,
            transparent 85%,
            rgba(0,0,0,0.05) 95%,
            rgba(0,0,0,0.18) 100%
        );
        pointer-events: none; 
        z-index: 2;
    }
    .back-cover-logo { font-size: 13px; font-weight: 800; color: #9C8E7A; letter-spacing: 0.2em; text-transform: uppercase; }

    /* ── Bottom Toolbar ── */
    .reader-toolbar {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 28px 16px 28px;
        background: transparent;
        flex-shrink: 0;
        height: 60px;
        z-index: 100;
        position: relative;
        margin-top: 30px;
    }
    .toolbar-group { display: flex; align-items: center; gap: 6px; }
    
    /* Tombol icon dengan border sesuai request */
    .toolbar-btn {
        width: 38px; height: 38px;
        border-radius: 50%; 
        border: none !important; 
        background: transparent !important; 
        color: #475569;
        display: flex; align-items: center; justify-content: center; 
        cursor: pointer; transition: all 0.2s;
        box-shadow: none !important;
    }
    .toolbar-btn:hover { color: #3b82f6; transform: scale(1.1); }
    .toolbar-btn:active { transform: scale(0.92); }
    .toolbar-btn.active { color: #3b82f6; }
    .toolbar-btn svg { width: 20px; height: 20px; }

    .toolbar-page-info { display: flex; align-items: center; gap: 8px; margin: 0 12px; }
    .toolbar-page-input {
        width: 44px; height: 32px; border-radius: 6px; border: none !important;
        background: transparent !important; color: #0f172a; text-align: center; font-size: 15px; font-weight: 700;
        font-family: 'Inter', sans-serif; outline: none; transition: all 0.25s;
        box-shadow: none !important;
    }
    .toolbar-page-input:focus { color: #3b82f6; }
    .toolbar-page-total { font-size: 14px; font-weight: 600; color: #64748b; }

    /* ── Sound Toast ── */
    .sound-indicator {
        position: absolute;
        top: 70px;
        right: 28px;
        padding: 10px 18px;
        background: #ffffff;
        color: #0f172a;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: none !important;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
        z-index: 1000;
        opacity: 0;
        transform: translateY(-8px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }
    .sound-indicator.show { opacity: 1; transform: translateY(0); }

    /* Fix StPageFlip cursor */
    .stf__block { cursor: grab !important; }
    .stf__block:active { cursor: grabbing !important; }

    @media (max-width: 768px) {
        .nav-arrow { display: none; }
        .reader-book-title { max-width: 140px; font-size: 13px; }
        .reader-header { padding: 8px 16px 0 16px; }
        .reader-toolbar { padding: 0 16px 12px 16px; }
    }
</style>

<div class="app-content">
    <div class="reader-wrapper">

        <!-- SVG Noise Filter for paper grain texture -->
        <svg class="svg-filters">
            <filter id="paper-noise">
                <feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="5" stitchTiles="stitch" result="noise"/>
                <feColorMatrix type="saturate" values="0" in="noise" result="grayNoise"/>
                <feBlend in="SourceGraphic" in2="grayNoise" mode="multiply" result="blend"/>
                <feComponentTransfer in="blend">
                    <feFuncA type="linear" slope="1"/>
                </feComponentTransfer>
            </filter>
        </svg>

        <!-- Container Inti Reader -->
        <div class="reader-container" id="readerContainer">

            <!-- Loading Screen -->
            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-book-anim">
                    <div class="page-l"></div>
                    <div class="page-r"></div>
                    <div class="flip"></div>
                </div>
                <div class="loading-text" id="loadingText">Memuat ebook...</div>
                <div class="loading-progress">
                    <div class="loading-progress-bar" id="loadingBar"></div>
                </div>
            </div>

            <!-- Header -->
            <div class="reader-header">
                <div class="reader-header-left"></div>
                <div class="reader-header-right">
                    <button class="header-btn active" id="btnSound" onclick="toggleSound()" title="Efek Suara">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                    </button>
                    <!-- Tombol Fullscreen internal container -->
                    <button class="header-btn" id="btnFullscreen" onclick="toggleFullscreen()" title="Layar Penuh">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    </button>
                </div>
            </div>

            <!-- Book Reading Area -->
            <div class="reader-body">
                <!-- Left Arrow -->
                <div class="nav-arrow left" id="navLeft" onclick="flipPrev()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>

                <!-- Flipbook Container -->
                <div id="bookContainer">
                    <div class="book-edge-bottom"></div>
                    <div class="book-edge-right"></div>
                    <div class="book-edge-left"></div>
                </div>

                <!-- Right Arrow -->
                <div class="nav-arrow right" id="navRight" onclick="flipNext()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Bottom Toolbar -->
            <div class="reader-toolbar">
                <div class="toolbar-group">
                    <button class="toolbar-btn" onclick="zoomOut()" title="Perkecil">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
                    </button>
                    <button class="toolbar-btn" onclick="zoomIn()" title="Perbesar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                    </button>
                </div>

                <div class="toolbar-page-info">
                    <button class="toolbar-btn" onclick="goFirst()" title="Halaman Pertama">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                    </button>
                    <button class="toolbar-btn" onclick="flipPrev()" title="Sebelumnya">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>

                    <input type="number" class="toolbar-page-input" id="pageInput" min="1" value="1"
                           onchange="goToPage(this.value)" onkeydown="if(event.key==='Enter')goToPage(this.value)">
                    <span class="toolbar-page-total" id="pageTotal">/ 0</span>

                    <button class="toolbar-btn" onclick="flipNext()" title="Selanjutnya">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button class="toolbar-btn" onclick="goLast()" title="Halaman Terakhir">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- Sound Toast -->
            <div class="sound-indicator" id="soundToast"></div>

        </div>
    </div>
</div>

<!-- PDF.js -->
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.4.120/legacy/build/pdf.min.js"></script>
<!-- StPageFlip -->
<script src="https://cdn.jsdelivr.net/npm/page-flip@2.0.7/dist/js/page-flip.browser.js"></script>

<script>
(function() {
    'use strict';

    const PDF_URL = '<?= base_url('perpustakaan/stream_ebook/' . $ebook->uuid_konten_ebook) ?>';
    const COVER_IMG = <?= ($ebook->sampul_ebook && file_exists(FCPATH . 'uploads/ebook/sampul/' . $ebook->sampul_ebook))
        ? "'" . base_url('uploads/ebook/sampul/' . $ebook->sampul_ebook) . "'"
        : 'null' ?>;
    const BOOK_TITLE = '<?= addslashes($ebook->judul_ebook) ?>';
    const BOOK_AUTHOR = '<?= addslashes($ebook->penulis_ebook ?? '') ?>';

    let pageFlip = null;
    let pdfDoc = null;
    let totalPages = 0;
    let renderedPages = {};
    let soundEnabled = true;
    let currentZoom = 1;

    // AUDIO POOLING FOR REALISTIC PAGE FLIP
    const FLIP_SOUND_POOL_SIZE = 4;
    const flipSoundPool = [];
    let flipSoundIndex = 0;

    for (let i = 0; i < FLIP_SOUND_POOL_SIZE; i++) {
        const audio = new Audio('<?= base_url('suara/freesounds123-book-opening-345808.mp3') ?>');
        audio.volume = 0.6;
        audio.preload = 'auto';
        flipSoundPool.push(audio);
    }

    const sndOpen = new Audio('<?= base_url('suara/freesounds123-book-opening-345808.mp3') ?>');
    sndOpen.volume = 0.8;
    sndOpen.preload = 'auto';

    function playPageFlipSound() {
        if (!soundEnabled) return;
        try {
            const snd = flipSoundPool[flipSoundIndex];
            flipSoundIndex = (flipSoundIndex + 1) % FLIP_SOUND_POOL_SIZE;
            snd.currentTime = 0;
            snd.playbackRate = 0.9 + Math.random() * 0.25;
            snd.volume = 0.5 + Math.random() * 0.2;
            snd.play().catch(function(){});
        } catch (e) {}
    }

    function playBookOpenSound() {
        if (!soundEnabled) return;
        try {
            sndOpen.currentTime = 0;
            sndOpen.playbackRate = 0.85;
            sndOpen.volume = 0.9;
            sndOpen.play().catch(function(){});
        } catch (e) {}
    }

    // MEMUAT PDF
    const pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@3.4.120/legacy/build/pdf.worker.min.js';

    async function loadPDF() {
        updateLoading('Mengunduh PDF...', 10);
        const loadingTask = pdfjsLib.getDocument(PDF_URL);
        loadingTask.onProgress = function(progress) {
            if (progress.total > 0) {
                const pct = Math.round((progress.loaded / progress.total) * 50);
                updateLoading('Mengunduh PDF...', 10 + pct);
            }
        };

        pdfDoc = await loadingTask.promise;
        totalPages = pdfDoc.numPages;

        updateLoading('Menyiapkan halaman...', 65);
        document.getElementById('pageTotal').textContent = '/ ' + totalPages;
        document.getElementById('pageInput').max = totalPages;

        await buildBook();
    }

    function updateLoading(text, pct) {
        document.getElementById('loadingText').textContent = text;
        document.getElementById('loadingBar').style.width = pct + '%';
    }

    // MEMBANGUN BUKU EBOOK
    async function buildBook(requestedPage = 0) {
        const container = document.getElementById('bookContainer');
        const edgeBottom = container.querySelector('.book-edge-bottom');
        const edgeRight = container.querySelector('.book-edge-right');
        const edgeLeft = container.querySelector('.book-edge-left');
        
        container.innerHTML = '';
        if (edgeBottom) container.appendChild(edgeBottom);
        if (edgeRight) container.appendChild(edgeRight);
        if (edgeLeft) container.appendChild(edgeLeft);

        // Menyesuaikan ukuran berdasarkan container dalam .app-content
        const readerBody = document.querySelector('.reader-body');
        const vh = readerBody.clientHeight - 40; // padding
        const vw = readerBody.clientWidth - 140; // arrows + padding
        const pageRatio = 1.414;

        let pageH = vh;
        let pageW = Math.floor(pageH / pageRatio);

        if (pageW * 2 > vw) {
            pageW = Math.floor(vw / 2);
            pageH = Math.floor(pageW * pageRatio);
        }

        pageW = Math.max(pageW, 250);
        pageH = Math.max(pageH, 320);

        let runningIdx = 0;
        function getSideClass() {
            const cls = (runningIdx % 2 === 0) ? 'page-right' : 'page-left';
            runningIdx++;
            return cls;
        }

        // Sampul depan murni memanfaatkan Halaman 1 dari PDF (ditumpuk dengan foto berkualitas tinggi jika ada)
        for (let i = 1; i <= totalPages; i++) {
            const pageDiv = document.createElement('div');
            
            if (i === 1) {
                pageDiv.className = 'page ' + getSideClass() + ' page-cover';
                pageDiv.setAttribute('data-density', 'hard');
                pageDiv.setAttribute('data-page-num', i);
                if (COVER_IMG) {
                    pageDiv.innerHTML = `<img src="${COVER_IMG}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; z-index:5;" alt="Cover" draggable="false">`;
                } else {
                    pageDiv.innerHTML = `<div class="page-loading"><div class="page-loading-spinner"></div></div>`;
                }
            } else {
                pageDiv.className = 'page ' + getSideClass();
                pageDiv.setAttribute('data-density', 'soft');
                pageDiv.setAttribute('data-page-num', i);
                const numPos = (i % 2 === 0) ? 'left' : 'right'; // i=2 (left), i=3 (right)
                pageDiv.innerHTML = `<div class="page-loading">
                    <div class="page-loading-spinner"></div>
                    <div class="page-loading-text">Halaman ${i}</div>
                </div>
                <span class="page-number ${numPos}">${i}</span>`;
            }
            container.appendChild(pageDiv);
        }

        // Agar sampul belakang menutup buku secara sempurna di sisi kiri (natively), 
        // total semua elemen halaman yang dimasukkan ke StPageFlip HARUS GENAP.
        if (runningIdx % 2 === 0) {
            const blankPage = document.createElement('div');
            blankPage.className = 'page ' + getSideClass();
            blankPage.setAttribute('data-density', 'soft');
            blankPage.innerHTML = `<div style="width:100%; height:100%; background:#fdfdfc;"></div>`;
            container.appendChild(blankPage);
        }

        const coverBack = createCoverBack(pageW, pageH);
        coverBack.className += ' ' + getSideClass();
        coverBack.setAttribute('data-page-num', 'cover-back'); // Tandai agar renderPage tak error
        container.appendChild(coverBack);

        updateLoading('Mempersiapkan flipbook...', 80);

        pageFlip = new St.PageFlip(container, {
            width: pageW,
            height: pageH,
            size: 'fixed',
            showCover: true,
            maxShadowOpacity: 0.95,
            mobileScrollSupport: true,
            clickEventForward: false,
            useMouseEvents: true,
            flippingTime: 900,
            startZIndex: 0,
            autoSize: false,
            drawShadow: true,
            startPage: requestedPage,
            usePortrait: false, // Memaksa tampil ganda
        });

        const pageElements = container.querySelectorAll('[data-density]');
        pageFlip.loadFromHTML(pageElements);

        pageFlip.on('flip', function(e) {
            playPageFlipSound();
            updatePageInfo();
            renderNearbyPages(e.data);
            setTimeout(updateBookEdges, 10);
        });

        pageFlip.on('changeState', function(e) {
            updatePageInfo();
            setTimeout(updateBookEdges, 10);
        });

        updateLoading('Merender halaman...', 90);
        await renderNearbyPages(requestedPage);
        
        updateLoading('Selesai!', 100);

        setTimeout(function() {
            document.getElementById('loadingOverlay').classList.add('hidden');
            updateBookEdges();
        }, 500);
    }

    function updateBookEdges() {
        if (!pageFlip) return;
        const leftEdge = document.querySelector('.book-edge-left');
        const rightEdge = document.querySelector('.book-edge-right');
        const bottomEdge = document.querySelector('.book-edge-bottom');
        
        if (!leftEdge || !bottomEdge) return;

        const currentIndex = pageFlip.getCurrentPageIndex();
        const maxIndex = pageFlip.getPageCount() - 1;
        
        if (currentIndex === 0) {
            leftEdge.style.display = 'none';
            rightEdge.style.display = 'block';
            bottomEdge.style.width = 'calc(50% - 4px)';
            bottomEdge.style.left = '50%';
            bottomEdge.style.transform = 'none';
        } else if (currentIndex >= maxIndex - 1 && maxIndex > 0) {
            leftEdge.style.display = 'block';
            rightEdge.style.display = 'none';
            bottomEdge.style.width = 'calc(50% - 4px)';
            bottomEdge.style.left = '4px';
            bottomEdge.style.transform = 'none';
        } else {
            leftEdge.style.display = 'block';
            rightEdge.style.display = 'block';
            bottomEdge.style.width = 'calc(100% - 8px)';
            bottomEdge.style.left = '50%';
            bottomEdge.style.transform = 'translateX(-50%)';
        }
    }

    // Menghapus fungsi createCoverFront dan createEndpaper karena sekarang terintegrasi langsung dengan Halaman 1 PDF.

    function createCoverBack(w, h) {
        const div = document.createElement('div');
        div.className = 'page page-cover page-cover-back';
        div.setAttribute('data-density', 'hard');
        div.innerHTML = `
            <div class="page-cover-ornament" style="margin-bottom:20px; background:#475569;"></div>
            <div class="back-cover-logo">PERPUSTAKAAN</div>
            <div style="font-size:10px; color:rgba(255,255,255,0.2); margin-top:8px; font-weight:500; letter-spacing:0.1em;">SIMIK Integrated System</div>
            <div class="page-cover-ornament" style="margin-top:20px; background:#475569;"></div>
        `;
        return div;
    }

    async function renderPage(pageNum) {
        if (renderedPages[pageNum] || pageNum < 1 || pageNum > totalPages) return;
        renderedPages[pageNum] = true;

        try {
            const page = await pdfDoc.getPage(pageNum);
            const allPages = document.querySelectorAll('#bookContainer [data-density]');
            const pageEl = allPages[pageNum - 1]; // PDF Page 1 is Index 0

            if (!pageEl) return;

            const desiredW = pageFlip.getSettings().width;
            const desiredH = pageFlip.getSettings().height;
            const origViewport = page.getViewport({ scale: 1 });
            const scaleToFit = Math.min(desiredW / origViewport.width, desiredH / origViewport.height);
            const renderScale = scaleToFit * (window.devicePixelRatio || 1);

            const viewport = page.getViewport({ scale: renderScale });
            const canvas = document.createElement('canvas');
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            canvas.style.width = '100%';
            canvas.style.height = '100%';

            const ctx = canvas.getContext('2d');
            await page.render({ canvasContext: ctx, viewport: viewport }).promise;

            const loading = pageEl.querySelector('.page-loading');
            if (loading) loading.remove();
            
            const pageNumberEl = pageEl.querySelector('.page-number');
            if (pageNumberEl) {
                pageEl.insertBefore(canvas, pageNumberEl);
            } else {
                pageEl.appendChild(canvas);
            }
        } catch (e) {
            console.warn('Failed to render page', pageNum, e);
        }
    }

    async function renderNearbyPages(currentFlipPage) {
        const pdfPage = currentFlipPage + 1; // Flip Index 0 is PDF Page 1
        const range = 4;
        const promises = [];
        for (let i = Math.max(1, pdfPage - range); i <= Math.min(totalPages, pdfPage + range); i++) {
            promises.push(renderPage(i));
        }
        await Promise.all(promises);
    }

    // CONTROLS
    function updatePageInfo() {
        if (!pageFlip) return;
        const current = pageFlip.getCurrentPageIndex();
        let displayPage = current + 1; // Flip Index 0 is PDF Page 1
        if (displayPage < 1) displayPage = 1;
        if (displayPage > totalPages) displayPage = totalPages;
        document.getElementById('pageInput').value = displayPage;
    }

    window.flipNext = function() { if (pageFlip) pageFlip.flipNext(); };
    window.flipPrev = function() { if (pageFlip) pageFlip.flipPrev(); };
    window.goFirst = function() { if (pageFlip) pageFlip.turnToPage(0); };
    window.goLast = function() { if (pageFlip) pageFlip.turnToPage(pageFlip.getPageCount() - 1); };

    window.goToPage = function(num) {
        num = parseInt(num);
        if (!pageFlip || isNaN(num)) return;
        const flipIdx = Math.max(0, Math.min(num - 1, totalPages)); // PDF Page maps to flipIdx - 1
        pageFlip.turnToPage(flipIdx);
        renderNearbyPages(flipIdx);
    };

    document.addEventListener('keydown', function(e) {
        if (e.target.tagName === 'INPUT') return;
        if (e.key === 'ArrowRight' || e.key === ' ') { e.preventDefault(); flipNext(); }
        if (e.key === 'ArrowLeft') { e.preventDefault(); flipPrev(); }
    });

    window.zoomIn = function() {
        currentZoom = Math.min(currentZoom + 0.15, 2);
        applyZoom();
    };
    window.zoomOut = function() {
        currentZoom = Math.max(currentZoom - 0.15, 0.5);
        applyZoom();
    };
    function applyZoom() {
        const container = document.getElementById('bookContainer');
        container.style.transform = 'scale(' + currentZoom + ')';
        container.style.transformOrigin = 'center center';
        container.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    }

    window.toggleFullscreen = function() {
        const container = document.getElementById('readerContainer');
        if (!document.fullscreenElement) {
            container.requestFullscreen().catch(()=>{});
        } else {
            document.exitFullscreen().catch(()=>{});
        }
    };

    window.toggleSound = function() {
        soundEnabled = !soundEnabled;
        const btn = document.getElementById('btnSound');
        const toast = document.getElementById('soundToast');
        if (soundEnabled) {
            btn.classList.add('active');
            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>';
            toast.textContent = '🔊 Suara Aktif';
        } else {
            btn.classList.remove('active');
            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>';
            toast.textContent = '🔇 Suara Dimatikan';
        }
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 1500);
    };

    loadPDF().catch(function(err) {});

    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (pageFlip) {
                const currentPage = pageFlip.getCurrentPageIndex();
                renderedPages = {};
                buildBook(currentPage);
            }
        }, 500);
    });
})();
</script>
