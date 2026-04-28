<style>
/* Desain UI: Kertas HVS Putih */
body {
    background-color: #f5f5f5 !important;
}
.paper-wrapper {
    max-width: 800px;
    margin: 40px auto;
}
.paper-form {
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 40px;
}
.paper-title {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    margin-bottom: 25px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}
.form-label {
    font-weight: 600;
    color: #555;
    margin-bottom: 8px;
}
.form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 10px 15px;
    transition: all 0.3s;
}
.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.btn-modern {
    padding: 10px 24px;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.kelas-subtitle {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 20px;
}
</style>

<div class="container-fluid" style="background-color: #f5f5f5; min-h-screen: 100vh; padding-bottom: 50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title">Tambah Jadwal Kelas</h2>
            <div class="kelas-subtitle">Program: <strong><?= esc($program['nama_program']) ?></strong></div>
            
            <form action="<?= base_url('kelas/simpan_kelas') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_program" value="<?= esc($program['id_program']) ?>">
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_kelas" required placeholder="Misal: Sesi 1 - Fundamental Bisnis">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status Kelas</label>
                        <select name="status_kelas" class="form-select">
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Deskripsi / Materi Kelas</label>
                    <textarea class="form-control" name="deskripsi" rows="3" placeholder="Penjelasan tentang materi yang akan dibahas..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" name="jam_mulai" id="jam_mulai">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" name="jam_selesai" id="jam_selesai">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dosen / Pemateri</label>
                    <select class="form-select" name="id_pemateri" id="id_pemateri" onchange="isi_nama_dosen(this)">
                        <option value="">-- Pilih Pemateri --</option>
                        <?php foreach ($daftar_pemateri as $p): ?>
                        <option value="<?= $p['id_user'] ?>" data-nama="<?= esc($p['nama_lengkap']) ?>">
                            <?= esc($p['nama_lengkap']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="nama_dosen" id="nama_dosen">
                </div>

                <!-- Tipe Kelas Online / Offline -->
                <div class="mb-3">
                    <label class="form-label">Tipe Kelas <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipe_kelas" id="tipe_online" value="online" onchange="toggle_tipe_kelas()">
                            <label class="form-check-label" for="tipe_online">Online</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipe_kelas" id="tipe_offline" value="offline" onchange="toggle_tipe_kelas()">
                            <label class="form-check-label" for="tipe_offline">Offline</label>
                        </div>
                    </div>
                </div>

                <!-- Field Online -->
                <div id="seksi_online" style="display:none;">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Platform</label>
                            <select name="platform_online" class="form-select">
                                <option value="">-- Pilih Platform --</option>
                                <option value="Zoom">Zoom</option>
                                <option value="Google Meet">Google Meet</option>
                                <option value="Microsoft Teams">Microsoft Teams</option>
                                <option value="Webex">Webex</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Link Meeting</label>
                            <input type="url" class="form-control" name="link_meeting" placeholder="https://zoom.us/j/... atau https://meet.google.com/...">
                        </div>
                    </div>
                </div>

                <!-- Field Offline -->
                <div id="seksi_offline" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Lokasi / Ruangan</label>
                        <input type="text" class="form-control" name="lokasi_offline" placeholder="Contoh: Gedung A Lantai 2, Ruang Seminar 301">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link Zoom Meeting <small class="text-muted">(opsional, untuk tombol Join Zoom)</small></label>
                    <input type="url" class="form-control" name="link_zoom" placeholder="https://zoom.us/j/...">
                </div>

                <div class="mb-4">
                    <label class="form-label">Link YouTube Live / Record</label>
                    <input type="url" class="form-control" name="link_youtube" placeholder="https://youtube.com/...">  
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-light btn-modern border">Batal</a>
                    <button type="submit" class="btn btn-primary btn-modern">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
(function() {
    var now = new Date();
    var pad = function(n) { return String(n).padStart(2, '0'); };
    document.getElementById('tanggal').value   = now.getFullYear() + '-' + pad(now.getMonth()+1) + '-' + pad(now.getDate());
    document.getElementById('jam_mulai').value = pad(now.getHours()) + ':' + pad(now.getMinutes());
    var selesai = new Date(now.getTime() + 60 * 60 * 1000);
    document.getElementById('jam_selesai').value = pad(selesai.getHours()) + ':' + pad(selesai.getMinutes());
})();

function isi_nama_dosen(sel) {
    var opt = sel.options[sel.selectedIndex];
    document.getElementById('nama_dosen').value = opt ? (opt.dataset.nama || '') : '';
}

function toggle_tipe_kelas() {
    var tipe = document.querySelector('input[name="tipe_kelas"]:checked');
    document.getElementById('seksi_online').style.display  = (tipe && tipe.value === 'online')  ? 'block' : 'none';
    document.getElementById('seksi_offline').style.display = (tipe && tipe.value === 'offline') ? 'block' : 'none';
}
</script>
