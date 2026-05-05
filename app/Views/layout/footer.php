<?php
// Partial: Footer — penutup struktur HTML, dimuat di setiap halaman
?>
<footer class="app-footer">
    <!-- Teks hak cipta dan nama sistem -->
    <div class="d-flex align-items-center gap-2">
        <span class="copyright">Hak Cipta &copy; 2026 SIMIK DKST</span>
        <span class="copyright separator">&bull;</span>
        <span class="copyright sub">Manajemen Startup Terpadu</span>
    </div>
    <!-- Tautan navigasi footer -->
    <div class="footer-links">
        <a href="#">Bantuan</a>
        <a href="#">Kebijakan</a>
    </div>
</footer>

</div><!-- end app-main -->
</div><!-- end app-wrapper -->

<!-- Global Miniplayer: Persistent across page navigation -->
<div id="global-miniplayer" style="display: none;">
    <button class="mini-close-btn" id="close-miniplayer">&times;</button>
    <div class="plyr-container">
        <div id="global-plyr" data-plyr-provider="youtube" data-plyr-embed-id=""></div>
    </div>
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
    display: block !important;
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 350px;
    height: 197px;
    z-index: 999999;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    overflow: hidden;
    background: #000;
}
#global-miniplayer .plyr-container {
    width: 100%;
    height: 100%;
}
#global-miniplayer .plyr__video-wrapper iframe,
#global-miniplayer iframe {
    transform: scale(1.05) !important;
    transform-origin: center center !important;
    pointer-events: none !important;
}
#global-miniplayer .plyr__controls {
    z-index: 20 !important;
}
#global-miniplayer .plyr__video-wrapper::after {
    content: '';
    position: absolute;
    bottom: 0; right: 0;
    width: 120px; height: 50px;
    background: linear-gradient(135deg, transparent 10%, rgba(0,0,0,0.9) 100%);
    z-index: 10;
    pointer-events: none;
}
#global-miniplayer .mini-close-btn {
    display: none;
    position: absolute;
    top: 6px;
    right: 6px;
    background: rgba(0,0,0,0.6);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 16px;
    line-height: 1;
    z-index: 100000;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}
#global-miniplayer .mini-close-btn:hover {
    background: rgba(220,38,38,0.8);
}
#global-miniplayer.is-mini:hover .mini-close-btn {
    display: flex;
}
</style>

<script>
// ═══════════════════════════════════════════════════════════════
// ULTIMATE MINIPLAYER - DOM PORTAL ARCHITECTURE
// Persistent player yang tidak terpengaruh navigasi halaman
// ═══════════════════════════════════════════════════════════════

window.globalPlayerInstance = window.globalPlayerInstance || null;
window.currentGlobalYtId = window.currentGlobalYtId || null;
window.currentVidId = window.currentVidId || null;
window.playerObserver = window.playerObserver || null;
window.saveIntervalId = window.saveIntervalId || null;

// Sinkronisasi posisi miniplayer dengan placeholder secara real-time
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
    } else if (mini && mini.classList.contains('is-mini')) {
        mini.style.position = 'fixed';
        mini.style.top = 'auto';
        mini.style.left = 'auto';
        mini.style.bottom = '24px';
        mini.style.right = '24px';
        mini.style.width = '350px';
        mini.style.height = '197px';
    }
}

window.addEventListener('resize', syncPlayerPosition);
window.addEventListener('scroll', syncPlayerPosition);

function initGlobalPlayer() {
    const placeholder = document.getElementById('yt-player-placeholder');
    const miniplayerContainer = document.getElementById('global-miniplayer');
    const closeBtn = document.getElementById('close-miniplayer');

    let targetYtId = null;
    let targetVidId = null;

    if (placeholder) {
        // ═══ SEDANG DI HALAMAN VIDEO UTAMA ═══
        const ytId = placeholder.getAttribute('data-yt-id');
        const vidId = placeholder.getAttribute('data-vid-id');
        const uuid = placeholder.getAttribute('data-uuid');
        
        // Hapus video ini dari antrian jika ada
        if (uuid) {
            let queue = JSON.parse(localStorage.getItem('tonton_setelah_ini') || '[]');
            if (queue.length > 0 && queue[0].uuid === uuid) {
                queue.shift();
                localStorage.setItem('tonton_setelah_ini', JSON.stringify(queue));
            }
        }

        if (ytId && ytId !== 'null' && ytId.trim() !== '') {
            targetYtId = ytId;
            targetVidId = vidId;

            miniplayerContainer.style.display = 'block';
            miniplayerContainer.classList.remove('is-mini');
            miniplayerContainer.classList.add('is-maximized');
            syncPlayerPosition();

            // Pasang ResizeObserver untuk tracking layout changes
            if (!window.playerObserver) {
                window.playerObserver = new ResizeObserver(syncPlayerPosition);
            }
            window.playerObserver.disconnect();
            window.playerObserver.observe(placeholder);
            window.playerObserver.observe(document.body);
        } else {
            console.warn("Invalid YouTube ID detected. Player not initialized.");
        }
    } else {
        // ═══ SEDANG DI HALAMAN LAIN ═══
        if (window.playerObserver) {
            window.playerObserver.disconnect();
        }
        if (window.currentGlobalYtId && window.globalPlayerInstance) {
            miniplayerContainer.style.display = 'block';
            miniplayerContainer.classList.remove('is-maximized');
            miniplayerContainer.classList.add('is-mini');
            syncPlayerPosition();
        }
    }

    // ═══ INISIALISASI ATAU UPDATE PLAYER ═══
    if (targetYtId) {
        if (!window.globalPlayerInstance) {
            // Buat player baru
            const plyrDiv = document.getElementById('global-plyr');
            plyrDiv.setAttribute('data-plyr-provider', 'youtube');
            plyrDiv.setAttribute('data-plyr-embed-id', targetYtId);

            window.globalPlayerInstance = new Plyr('#global-plyr', {
                controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'fullscreen'],
                youtube: { noCookie: true, rel: 0, showinfo: 0, ivory: 1, modestbranding: 1 }
            });

            window.currentGlobalYtId = targetYtId;
            window.currentVidId = targetVidId;

            // Event: Player ready - load durasi terakhir
            window.globalPlayerInstance.on('ready', () => {
                fetch('<?= base_url('riwayat/get_durasi_video') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id_video=${targetVidId}&<?= csrf_token() ?>=<?= csrf_hash() ?>`
                })
                .then(r => r.json())
                .then(data => {
                    const durasi = parseInt(data.durasi) || 0;
                    if (durasi > 5) window.globalPlayerInstance.currentTime = durasi;
                    window.globalPlayerInstance.play().catch(e => console.warn('Autoplay blocked:', e));
                })
                .catch(() => {
                    window.globalPlayerInstance.play().catch(e => console.warn('Autoplay blocked:', e));
                });
            });

            // Event: Simpan durasi setiap 10 detik
            window.globalPlayerInstance.on('timeupdate', () => {
                const currentTime = Math.floor(window.globalPlayerInstance.currentTime);
                if (currentTime > 0 && currentTime % 10 === 0 && window.globalPlayerInstance.playing && window.currentVidId) {
                    fetch('<?= base_url('riwayat/update_video') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id_video=${window.currentVidId}&durasi=${currentTime}&<?= csrf_token() ?>=<?= csrf_hash() ?>`
                    }).catch(e => console.warn('Save failed:', e));
                }
            });

            // Event: Video selesai - putar antrian berikutnya
            window.globalPlayerInstance.on('ended', () => {
                const queue = JSON.parse(localStorage.getItem('tonton_setelah_ini') || '[]');
                if (queue.length > 0) {
                    const next = queue.shift();
                    localStorage.setItem('tonton_setelah_ini', JSON.stringify(queue));
                    window.location.href = '<?= base_url('perpustakaan/full_vidio/') ?>' + next.uuid;
                }
            });

            // Tombol close miniplayer
            if (closeBtn) {
                closeBtn.onclick = () => {
                    if (window.globalPlayerInstance) window.globalPlayerInstance.stop();
                    miniplayerContainer.style.display = 'none';
                    miniplayerContainer.classList.remove('is-mini');
                    window.currentGlobalYtId = null;
                    window.currentVidId = null;
                };
            }
        } else if (window.currentGlobalYtId !== targetYtId) {
            // Ganti video (user buka video lain)
            window.globalPlayerInstance.source = {
                type: 'video',
                sources: [{ src: targetYtId, provider: 'youtube' }]
            };
            window.currentGlobalYtId = targetYtId;
            window.currentVidId = targetVidId;
            
            // Load durasi untuk video baru
            window.globalPlayerInstance.once('ready', () => {
                fetch('<?= base_url('riwayat/get_durasi_video') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id_video=${targetVidId}&<?= csrf_token() ?>=<?= csrf_hash() ?>`
                }).then(r=>r.json()).then(data => {
                    const durasi = parseInt(data.durasi) || 0;
                    if (durasi > 5) window.globalPlayerInstance.currentTime = durasi;
                    window.globalPlayerInstance.play().catch(e=>console.warn('Autoplay blocked:', e));
                }).catch(e => console.warn('Load failed:', e));
            });
        } else {
            // Video yang sama dibuka kembali
            if (!window.globalPlayerInstance.playing) {
                window.globalPlayerInstance.play().catch(e => console.warn('Autoplay blocked:', e));
            }
        }
    }
}

// Init saat halaman load
document.addEventListener('DOMContentLoaded', initGlobalPlayer);

// ═══════════════════════════════════════════════════════════════
// AJAX NAVIGATION - Intercept internal links untuk SPA behavior
// ═══════════════════════════════════════════════════════════════
$(document).on('click', 'a[href]:not([target="_blank"]):not([href^="mailto"]):not([href^="tel"]):not([href^="#"]):not([href*="download"]):not([href*="logout"]):not([href*="v_dashboard"])', function(e) {
    const href = $(this).attr('href');
    
    // Skip jika link eksternal
    if (!href || href.startsWith('http://') || href.startsWith('https://')) {
        if (!href.includes(window.location.hostname)) return;
    }
    
    // Skip jika link ke file
    if (href.match(/\.(pdf|zip|jpg|png|gif|doc|docx|xls|xlsx)$/i)) return;
    
    e.preventDefault();
    
    // Load konten via AJAX
    $.ajax({
        url: href,
        method: 'GET',
        beforeSend: function() {
            // Tampilkan loading bar tipis di atas
            if (!$('#ajax-loader').length) {
                $('body').append('<div id="ajax-loader" style="position:fixed;top:0;left:0;width:0;height:3px;background:#3b82f6;z-index:999999;transition:width 0.3s;"></div>');
            }
            $('#ajax-loader').css('width', '70%');
        },
        success: function(html) {
            // Parse HTML response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Extract konten dari app-main
            const newContent = doc.querySelector('.app-main');
            const newTopbar = doc.querySelector('.app-topbar');
            const newTitle = doc.querySelector('title');
            
            if (newContent) {
                // Replace konten
                $('.app-main').html(newContent.innerHTML);
                
                // Update topbar jika ada
                if (newTopbar) {
                    $('.app-topbar').html(newTopbar.innerHTML);
                }
                
                // Update title
                if (newTitle) {
                    document.title = newTitle.textContent;
                }
                
                // Update CSRF token dari response baru
                const newCsrfMeta = doc.querySelector('meta[name^="csrf"]');
                if (newCsrfMeta) {
                    const oldCsrfMeta = document.querySelector('meta[name^="csrf"]');
                    if (oldCsrfMeta) {
                        oldCsrfMeta.setAttribute('name', newCsrfMeta.getAttribute('name'));
                        oldCsrfMeta.setAttribute('content', newCsrfMeta.getAttribute('content'));
                    }
                }
                
                // Update URL tanpa reload
                window.history.pushState({path: href}, '', href);
                
                // Update menu aktif
                $('.topbar-nav .top-nav-link-item').removeClass('top-nav-active');
                $('.topbar-nav button.top-nav-link-item').removeClass('top-nav-active');
                
                // Cari link yang exact match
                var exactLink = $('.topbar-nav .top-nav-link-item[href="' + href + '"]');
                if (exactLink.length > 0) {
                    exactLink.addClass('top-nav-active');
                } else {
                    // Jika tidak ada exact match, cek apakah ada di dropdown
                    var dropdownLink = $('.perpus-dropdown-menu a[href="' + href + '"]');
                    if (dropdownLink.length > 0) {
                        // Aktifkan button dropdown parent-nya
                        dropdownLink.closest('.perpus-dropdown').find('button.top-nav-link-item').addClass('top-nav-active');
                    }
                }
                
                // Scroll ke atas
                window.scrollTo(0, 0);
                
                // Re-init player untuk halaman baru
                setTimeout(() => {
                    initGlobalPlayer();
                    
                    // Destroy semua DataTables yang sudah di-init sebelum re-execute script
                    if ($.fn.DataTable) {
                        $.fn.dataTable.tables({api: true}).destroy();
                    }
                    
                    // Re-execute inline scripts dari konten baru
                    $(newContent).find('script').each(function() {
                        // Skip script flashdata saja
                        if (this.hasAttribute('data-flashdata')) {
                            return;
                        }
                        
                        if (this.src) {
                            // External script - load ulang jika belum ada
                            const scriptId = 'ajax-script-' + btoa(this.src).substring(0, 20);
                            if (!document.getElementById(scriptId)) {
                                const script = document.createElement('script');
                                script.id = scriptId;
                                script.src = this.src;
                                document.body.appendChild(script);
                            }
                        } else {
                            // Inline script - execute langsung
                            try {
                                // Decode HTML entities sebelum eval
                                const textarea = document.createElement('textarea');
                                textarea.innerHTML = this.textContent;
                                const decodedScript = textarea.value;
                                
                                // Execute dalam global scope
                                (function() {
                                    eval(decodedScript);
                                }).call(window);
                            } catch(e) {
                                console.warn('Script execution error:', e, this.textContent.substring(0, 100));
                            }
                        }
                    });
                }, 100);
            } else {
                // Fallback: reload halaman biasa
                window.location.href = href;
            }
        },
        error: function() {
            // Fallback: reload halaman biasa
            window.location.href = href;
        },
        complete: function() {
            $('#ajax-loader').css('width', '100%');
            setTimeout(() => $('#ajax-loader').remove(), 300);
        }
    });
});

// Handle browser back/forward button
window.addEventListener('popstate', function(e) {
    if (e.state && e.state.path) {
        window.location.href = e.state.path;
    }
});
</script>


<!-- JS Bootstrap untuk komponen interaktif (modal, dropdown, dll) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Helper global untuk confirm hapus pakai SweetAlert2
function swalConfirm(form) {
    Swal.fire({
        title: 'Yakin?',
        text: 'Data tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then(function(result) {
        if (result.isConfirmed) form.submit();
    });
    return false;
}

// Helper global untuk mendapatkan CSRF token terbaru
function getCsrfToken() {
    const meta = document.querySelector('meta[name^="csrf"]');
    if (meta) {
        return {
            name: meta.getAttribute('name'),
            hash: meta.getAttribute('content')
        };
    }
    return { name: '', hash: '' };
}
</script>
</body>
</html>
