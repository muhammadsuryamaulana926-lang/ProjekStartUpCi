<!-- Modal Detail Video — Desain Premium & Imersif -->
<div class="modal fade" id="modalDetailVideo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);">
            <div class="modal-body p-0">
                <div style="display:flex; height: 420px;">
                    <!-- Kiri: Thumbnail -->
                    <div style="width: 55%; background: #000; position: relative; flex-shrink:0;">
                        <img id="detailVidThumb" src="" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.85;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 60%, rgba(0,0,0,0.6) 100%);"></div>
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 50px; height: 50px; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="tontonFullVideo()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24" style="margin-left: 3px;"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                        <div style="position: absolute; bottom: 15px; left: 20px;">
                            <span id="detailVidBadge" class="badge" style="background: #3D3426; color: #fff; padding: 4px 10px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 6px;">VIDEO</span>
                        </div>
                    </div>
                    <!-- Kanan: Info -->
                    <div style="flex:1; background:#fff; padding:28px; display:flex; flex-direction:column; overflow:hidden;">
                        <div class="d-flex justify-content-between align-items-start" style="margin-bottom:12px;">
                            <div style="flex:1; min-width:0;">
                                <h4 id="detailVidTitle" style="font-size: 18px; font-weight: 800; color: #3D3426; margin-bottom: 4px; line-height: 1.3; text-transform: capitalize;">Judul Video</h4>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px; background-color: #f8f5f0; border-radius: 50%; padding: 8px; opacity: 0.8; flex-shrink:0; margin-left:12px;"></button>
                        </div>
                        <hr style="border-color: #E8DFD0; margin: 0 0 16px 0;">
                        <div style="flex:1; overflow-y:auto; margin-bottom:16px;">
                            <h6 style="font-size: 10px; font-weight: 800; color: #B8A990; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Deskripsi</h6>
                            <p id="detailVidDesc" style="font-size: 13.5px; color: #5C5446; line-height: 1.6; margin: 0;">Deskripsi video...</p>
                        </div>
                        <button class="btn" onclick="tontonFullVideo()" style="width: 100%; background: #3D3426; color: #fff; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 13px; box-shadow: 0 4px 12px rgba(61,52,38,0.15); flex-shrink:0;">
                            Tonton Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var currentDetailVidId = null;
    var currentDetailYtId = null;
    var currentDetailUuid = null;

    function bukaDetailVideoFromEl(el) {
        bukaDetailVideo(
            el.dataset.vidId,
            el.dataset.title,
            el.dataset.desc,
            el.dataset.status,
            el.dataset.ytId,
            el.dataset.uuid
        );
    }

    function bukaDetailVideo(id, title, desc, status, ytId, uuid) {
        currentDetailVidId = id;
        currentDetailYtId = ytId;
        currentDetailUuid = uuid;

        document.getElementById('detailVidThumb').src = 'https://img.youtube.com/vi/' + ytId + '/maxresdefault.jpg';
        document.getElementById('detailVidTitle').innerText = title;
        document.getElementById('detailVidDesc').innerText = desc || 'Tidak ada deskripsi untuk video ini.';
        
        const modal = new bootstrap.Modal(document.getElementById('modalDetailVideo'));
        modal.show();
    }

    function tontonFullVideo() {
        if (currentDetailUuid) {
            window.location.href = '<?= base_url('perpustakaan/full_vidio/') ?>' + currentDetailUuid;
        }
    }
</script>
