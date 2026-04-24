<style>
body { background-color: #f5f5f5 !important; }
.paper-wrapper { max-width: 860px; margin: 40px auto; }
.paper-form { background-color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; border-radius: 8px; padding: 40px; }
.paper-title { font-size: 24px; font-weight: 700; color: #333; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
.form-label { font-weight: 600; color: #555; margin-bottom: 8px; }
.form-control, .form-select { border-radius: 6px; border: 1px solid #cbd5e1; padding: 10px 15px; transition: all 0.3s; }
.form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
.btn-modern { padding: 10px 24px; border-radius: 6px; font-weight: 600; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.kelas-subtitle { font-size: 14px; color: #64748b; margin-bottom: 20px; }
.sesi-row { background: #f8fafc; }
.chapter-row { background: #fff; }
</style>

<div class="container-fluid" style="background-color:#f5f5f5; padding-bottom:50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title">Edit Jadwal Kelas</h2>
            <div class="kelas-subtitle">Program: <strong><?= esc($program['nama_program']) ?></strong></div>

            <form action="<?= base_url('kelas/ubah_kelas') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                <input type="hidden" name="id_program" value="<?= esc($program['id_program']) ?>">

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_kelas" required value="<?= esc($kelas['nama_kelas']) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status Kelas</label>
                        <select name="status_kelas" class="form-select">
                            <option value="aktif"      <?= $kelas['status_kelas'] == 'aktif'      ? 'selected' : '' ?>>Aktif</option>
                            <option value="selesai"    <?= $kelas['status_kelas'] == 'selesai'    ? 'selected' : '' ?>>Selesai</option>
                            <option value="dibatalkan" <?= $kelas['status_kelas'] == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi / Materi Kelas</label>
                    <textarea class="form-control" name="deskripsi" rows="3"><?= esc($kelas['deskripsi']) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= esc($kelas['tanggal']) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" name="jam_mulai" value="<?= esc($kelas['jam_mulai']) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" name="jam_selesai" value="<?= esc($kelas['jam_selesai']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dosen / Pemateri</label>
                    <input type="text" class="form-control" name="nama_dosen" value="<?= esc($kelas['nama_dosen']) ?>">
                </div>

                <!-- Multi Video Sesi -->
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">Video Rekaman Sesi</label>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="tambah_sesi()">
                            <i class="mdi mdi-plus"></i> Tambah Sesi
                        </button>
                    </div>
                    <div id="sesiContainer">
                        <?php
                        $videos = !empty($kelas_videos) ? $kelas_videos : [];
                        if (empty($videos) && !empty($kelas['link_youtube'])) {
                            $videos = [['id_kelas_video' => 0, 'judul_sesi' => 'Sesi 1', 'link_youtube' => $kelas['link_youtube'], 'link_zoom' => $kelas['link_zoom']]];
                        }
                        if (empty($videos)) {
                            $videos = [['id_kelas_video' => 0, 'judul_sesi' => 'Sesi 1', 'link_youtube' => '', 'link_zoom' => '']];
                        }
                        foreach ($videos as $i => $v):
                            $vid_id   = $v['id_kelas_video'] ?? 0;
                            $chapters = $chapters_map[$vid_id] ?? [];
                        ?>
                        <div class="sesi-row border rounded p-3 mb-3">
                            <!-- Header sesi -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold small text-muted">Sesi <?= $i + 1 ?></span>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapus_sesi(this)" <?= $i === 0 ? 'style="visibility:hidden"' : '' ?>>
                                    <i class="mdi mdi-close"></i>
                                </button>
                            </div>

                            <!-- Judul + Link -->
                            <div class="mb-2">
                                <input type="text" class="form-control form-control-sm" name="judul_sesi[]"
                                       placeholder="Judul sesi" value="<?= esc($v['judul_sesi'] ?? '') ?>" required>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <input type="url" class="form-control form-control-sm yt-link-input" name="link_youtube[]"
                                           placeholder="Link YouTube" value="<?= esc($v['link_youtube'] ?? '') ?>"
                                           oninput="ambil_durasi_video(this)">
                                </div>
                                <div class="col-md-6">
                                    <input type="url" class="form-control form-control-sm" name="link_zoom_sesi[]"
                                           placeholder="Link Zoom" value="<?= esc($v['link_zoom'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="durasi-info mb-2" style="font-size:11px; display:none;"></div>

                            <!-- Chapter -->
                            <div class="border-top pt-2">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="small fw-semibold text-secondary">
                                        <i class="mdi mdi-format-list-bulleted me-1"></i>Chapter / Timestamp
                                    </span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="tambah_chapter(this)">
                                        <i class="mdi mdi-plus"></i> Tambah Chapter
                                    </button>
                                </div>
                                <div class="chapter-container">
                                    <?php if (empty($chapters)): ?>
                                    <!-- baris kosong default -->
                                    <div class="chapter-row border rounded p-2 mb-1">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-control-sm" name="judul_chapter[<?= $i ?>][]" placeholder="Judul chapter">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control" name="mulai_menit[<?= $i ?>][]" placeholder="mm" min="0" style="max-width:60px;">
                                                    <span class="input-group-text">:</span>
                                                    <input type="number" class="form-control" name="mulai_detik_ch[<?= $i ?>][]" placeholder="ss" min="0" max="59" style="max-width:60px;">
                                                </div>
                                                <div class="text-muted" style="font-size:10px;">Mulai (mm:ss)</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control" name="selesai_menit[<?= $i ?>][]" placeholder="mm" min="0" style="max-width:60px;">
                                                    <span class="input-group-text">:</span>
                                                    <input type="number" class="form-control" name="selesai_detik_ch[<?= $i ?>][]" placeholder="ss" min="0" max="59" style="max-width:60px;">
                                                </div>
                                                <div class="text-muted" style="font-size:10px;">Selesai (mm:ss)</div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapus_chapter(this)" style="visibility:hidden">
                                                    <i class="mdi mdi-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <?php foreach ($chapters as $ci => $ch):
                                        $mm = floor($ch['mulai_detik'] / 60);
                                        $ms = $ch['mulai_detik'] % 60;
                                        $sm = floor($ch['selesai_detik'] / 60);
                                        $ss = $ch['selesai_detik'] % 60;
                                    ?>
                                    <div class="chapter-row border rounded p-2 mb-1">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-control-sm" name="judul_chapter[<?= $i ?>][]"
                                                       placeholder="Judul chapter" value="<?= esc($ch['judul_chapter']) ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control" name="mulai_menit[<?= $i ?>][]" value="<?= $mm ?>" min="0" style="max-width:60px;">
                                                    <span class="input-group-text">:</span>
                                                    <input type="number" class="form-control" name="mulai_detik_ch[<?= $i ?>][]" value="<?= $ms ?>" min="0" max="59" style="max-width:60px;">
                                                </div>
                                                <div class="text-muted" style="font-size:10px;">Mulai (mm:ss)</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control" name="selesai_menit[<?= $i ?>][]" value="<?= $sm ?>" min="0" style="max-width:60px;">
                                                    <span class="input-group-text">:</span>
                                                    <input type="number" class="form-control" name="selesai_detik_ch[<?= $i ?>][]" value="<?= $ss ?>" min="0" max="59" style="max-width:60px;">
                                                </div>
                                                <div class="text-muted" style="font-size:10px;">Selesai (mm:ss)</div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapus_chapter(this)" <?= $ci === 0 ? 'style="visibility:hidden"' : '' ?>>
                                                    <i class="mdi mdi-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-light btn-modern border">Batal</a>
                    <button type="submit" class="btn btn-primary btn-modern">Update Kelas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var jumlah_sesi = <?= count($videos) ?>;

function tambah_sesi() {
    var idx = document.querySelectorAll('#sesiContainer .sesi-row').length;
    var div = document.createElement('div');
    div.className = 'sesi-row border rounded p-3 mb-3';
    div.innerHTML =
        '<div class="d-flex justify-content-between align-items-center mb-2">' +
            '<span class="fw-semibold small text-muted">Sesi ' + (idx+1) + '</span>' +
            '<button type="button" class="btn btn-sm btn-outline-danger" onclick="hapus_sesi(this)"><i class="mdi mdi-close"></i></button>' +
        '</div>' +
        '<div class="mb-2"><input type="text" class="form-control form-control-sm" name="judul_sesi[]" placeholder="Judul sesi" required></div>' +
        '<div class="row g-2 mb-3">' +
            '<div class="col-md-6"><input type="url" class="form-control form-control-sm yt-link-input" name="link_youtube[]" placeholder="Link YouTube" oninput="ambil_durasi_video(this)"></div>' +
            '<div class="col-md-6"><input type="url" class="form-control form-control-sm" name="link_zoom_sesi[]" placeholder="Link Zoom"></div>' +
        '</div>' +
        '<div class="durasi-info mb-2" style="font-size:11px; display:none;"></div>' +
        '<div class="border-top pt-2">' +
            '<div class="d-flex align-items-center justify-content-between mb-2">' +
                '<span class="small fw-semibold text-secondary"><i class="mdi mdi-format-list-bulleted me-1"></i>Chapter / Timestamp</span>' +
                '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="tambah_chapter(this)"><i class="mdi mdi-plus"></i> Tambah Chapter</button>' +
            '</div>' +
            '<div class="chapter-container">' + buat_baris_chapter(idx, 0, true) + '</div>' +
        '</div>';
    document.getElementById('sesiContainer').appendChild(div);
    nomori_ulang_sesi();
}

function hapus_sesi(btn) {
    btn.closest('.sesi-row').remove();
    nomori_ulang_sesi();
}

function nomori_ulang_sesi() {
    document.querySelectorAll('#sesiContainer .sesi-row').forEach(function(row, i) {
        row.querySelector('.text-muted').textContent = 'Sesi ' + (i + 1);
        row.querySelector('.btn-outline-danger').style.visibility = i === 0 ? 'hidden' : '';
        row.querySelectorAll('.chapter-row input').forEach(function(inp) {
            inp.name = inp.name.replace(/\[\d+\]/, '[' + i + ']');
        });
    });
}

function buat_baris_chapter(idx_sesi, idx_chapter, sembunyikan_hapus) {
    return '<div class="chapter-row border rounded p-2 mb-1">' +
        '<div class="row g-2 align-items-center">' +
            '<div class="col-md-4"><input type="text" class="form-control form-control-sm" name="judul_chapter[' + idx_sesi + '][]" placeholder="Judul chapter"></div>' +
            '<div class="col-md-3">' +
                '<div class="input-group input-group-sm">' +
                    '<input type="number" class="form-control" name="mulai_menit[' + idx_sesi + '][]" placeholder="mm" min="0" style="max-width:60px;">' +
                    '<span class="input-group-text">:</span>' +
                    '<input type="number" class="form-control" name="mulai_detik_ch[' + idx_sesi + '][]" placeholder="ss" min="0" max="59" style="max-width:60px;">' +
                '</div>' +
                '<div class="text-muted" style="font-size:10px;">Mulai (mm:ss)</div>' +
            '</div>' +
            '<div class="col-md-3">' +
                '<div class="input-group input-group-sm">' +
                    '<input type="number" class="form-control" name="selesai_menit[' + idx_sesi + '][]" placeholder="mm" min="0" style="max-width:60px;">' +
                    '<span class="input-group-text">:</span>' +
                    '<input type="number" class="form-control" name="selesai_detik_ch[' + idx_sesi + '][]" placeholder="ss" min="0" max="59" style="max-width:60px;">' +
                '</div>' +
                '<div class="text-muted" style="font-size:10px;">Selesai (mm:ss)</div>' +
            '</div>' +
            '<div class="col-md-2 text-end">' +
                '<button type="button" class="btn btn-sm btn-outline-danger" onclick="hapus_chapter(this)"' + (sembunyikan_hapus ? ' style="visibility:hidden"' : '') + '><i class="mdi mdi-close"></i></button>' +
            '</div>' +
        '</div></div>';
}

function tambah_chapter(btn) {
    var baris_sesi   = btn.closest('.sesi-row');
    var idx_sesi     = Array.from(document.querySelectorAll('#sesiContainer .sesi-row')).indexOf(baris_sesi);
    var wadah_chapter = baris_sesi.querySelector('.chapter-container');
    var semua_baris  = wadah_chapter.querySelectorAll('.chapter-row');

    // Validasi chapter terakhir sebelum tambah baru
    if (semua_baris.length > 0) {
        var baris_terakhir  = semua_baris[semua_baris.length - 1];
        var input_judul     = baris_terakhir.querySelector('input[name*="judul_chapter"]');
        var input_sel_menit = baris_terakhir.querySelectorAll('input[type="number"]')[2];
        var input_sel_detik = baris_terakhir.querySelectorAll('input[type="number"]')[3];
        var total_selesai   = (parseInt(input_sel_menit.value)||0)*60 + (parseInt(input_sel_detik.value)||0);
        var durasi_video    = parseInt(baris_sesi.dataset.durasi || 0);

        if (!input_judul.value.trim()) {
            input_judul.classList.add('is-invalid');
            return;
        }
        if (durasi_video > 0 && total_selesai > durasi_video) {
            input_sel_menit.classList.add('is-invalid');
            input_sel_detik.classList.add('is-invalid');
            return;
        }
        if (durasi_video > 0 && total_selesai === 0) {
            input_sel_menit.classList.add('is-invalid');
            return;
        }
    }

    // Auto-fill menit mulai dari selesai chapter sebelumnya
    var detik_mulai_baru = 0;
    if (semua_baris.length > 0) {
        var baris_terakhir = semua_baris[semua_baris.length - 1];
        var sm = parseInt(baris_terakhir.querySelectorAll('input[type="number"]')[2].value) || 0;
        var ss = parseInt(baris_terakhir.querySelectorAll('input[type="number"]')[3].value) || 0;
        detik_mulai_baru = sm * 60 + ss;
    }

    var div_baru = document.createElement('div');
    div_baru.innerHTML = buat_baris_chapter(idx_sesi, semua_baris.length, false);
    var baris_baru = div_baru.firstElementChild;
    wadah_chapter.appendChild(baris_baru);

    if (detik_mulai_baru > 0) {
        var inputs = baris_baru.querySelectorAll('input[type="number"]');
        inputs[0].value = Math.floor(detik_mulai_baru / 60);
        inputs[1].value = detik_mulai_baru % 60;
    }

    wadah_chapter.querySelectorAll('.chapter-row')[0].querySelector('button').style.visibility = '';
}

function hapus_chapter(btn) {
    var wadah = btn.closest('.chapter-container');
    btn.closest('.chapter-row').remove();
    if (wadah.querySelectorAll('.chapter-row').length === 1) {
        wadah.querySelectorAll('.chapter-row')[0].querySelector('button').style.visibility = 'hidden';
    }
}

// Ekstrak YouTube ID dari URL
function ambil_yt_id(url) {
    var m = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|v\/))([\w-]{11})/);
    return m ? m[1] : null;
}

// Ambil durasi video YouTube via IFrame API
function ambil_durasi_video(input) {
    var baris_sesi = input.closest('.sesi-row');
    var el_info    = baris_sesi.querySelector('.durasi-info');
    var yt_id      = ambil_yt_id(input.value);
    if (!yt_id) { baris_sesi.dataset.durasi = 0; if (el_info) el_info.textContent = ''; return; }

    fetch('https://noembed.com/embed?url=https://www.youtube.com/watch?v=' + yt_id)
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (d.title && el_info) {
                el_info.innerHTML = '<i class="mdi mdi-youtube text-danger"></i> ' + d.title;
            }
        }).catch(function() {});

    muat_durasi_yt(yt_id, baris_sesi, el_info);
}

var yt_api_siap = false;
var antrian_durasi = [];

function muat_durasi_yt(yt_id, baris_sesi, el_info) {
    antrian_durasi.push({ yt_id: yt_id, baris_sesi: baris_sesi, el_info: el_info });
    if (!yt_api_siap) {
        if (!document.getElementById('yt-iframe-api')) {
            var tag = document.createElement('script');
            tag.id  = 'yt-iframe-api';
            tag.src = 'https://www.youtube.com/iframe_api';
            document.head.appendChild(tag);
        }
    } else {
        proses_antrian_durasi();
    }
}

window.onYouTubeIframeAPIReady = function() {
    yt_api_siap = true;
    proses_antrian_durasi();
};

function proses_antrian_durasi() {
    while (antrian_durasi.length > 0) {
        (function(item) {
            var wadah = document.createElement('div');
            wadah.style.display = 'none';
            document.body.appendChild(wadah);
            new YT.Player(wadah, {
                videoId: item.yt_id,
                events: {
                    onReady: function(e) {
                        var durasi = Math.floor(e.target.getDuration());
                        item.baris_sesi.dataset.durasi = durasi;
                        var mm = Math.floor(durasi / 60), ss = durasi % 60;
                        if (item.el_info) {
                            item.el_info.innerHTML += ' &bull; Durasi: <strong>' + mm + ':' + String(ss).padStart(2, '0') + '</strong>';
                        }
                        e.target.destroy();
                        wadah.remove();
                    }
                }
            });
        })(antrian_durasi.shift());
    }
}

// Validasi input selesai tidak melebihi durasi video
document.addEventListener('input', function(e) {
    var inp = e.target;
    if (!inp.name) return;
    if (inp.name.includes('selesai_menit') || inp.name.includes('selesai_detik_ch')) {
        var baris_sesi  = inp.closest('.sesi-row');
        var durasi      = parseInt(baris_sesi ? baris_sesi.dataset.durasi || 0 : 0);
        if (durasi === 0) return;
        var baris_ch    = inp.closest('.chapter-row');
        var inputs      = baris_ch.querySelectorAll('input[type="number"]');
        var total       = (parseInt(inputs[2].value)||0)*60 + (parseInt(inputs[3].value)||0);
        if (total > durasi) {
            inputs[2].classList.add('is-invalid');
            inputs[3].classList.add('is-invalid');
        } else {
            inputs[2].classList.remove('is-invalid');
            inputs[3].classList.remove('is-invalid');
        }
    }
    if (inp.name.includes('judul_chapter') && inp.value.trim()) {
        inp.classList.remove('is-invalid');
    }
});

// Inisialisasi durasi untuk sesi yang sudah ada link YouTube
document.querySelectorAll('.yt-link-input').forEach(function(inp) {
    if (inp.value) ambil_durasi_video(inp);
});
</script>
