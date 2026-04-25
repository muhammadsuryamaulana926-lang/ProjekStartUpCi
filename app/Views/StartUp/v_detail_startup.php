<style>
body { background-color: #f5f5f5 !important; }
.paper-card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 24px;
}
.section-header {
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #555;
    background: #f8f9fa;
    border-radius: 6px;
    padding: 10px 14px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.label-text { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin-bottom: 4px; }
.value-text { font-size: 14px; font-weight: 500; color: #334155; }
.nav-tabs.nav-bordered { border-bottom: 2px solid #dee2e6; display: flex; flex-wrap: nowrap; overflow-x: auto; gap: 4px; }
.nav-tabs.nav-bordered .nav-link { font-size: 14px; font-weight: 600; color: #64748b; border: none; border-bottom: 2px solid transparent; padding: 10px 16px; margin-bottom: -2px; background: transparent !important; white-space: nowrap; }
.nav-tabs.nav-bordered .nav-link.active { color: #0d6efd; border-bottom: 2px solid #0d6efd; }
.nav-tabs.nav-bordered .nav-link:hover:not(.active) { color: #333; }
.timeline-sm { padding-left: 20px; }
.timeline-sm .timeline-sm-item { position: relative; padding-bottom: 20px; padding-left: 20px; border-left: 2px solid #dee2e6; }
.timeline-sm .timeline-sm-item:before { content: ''; position: absolute; left: -6px; top: 0; width: 10px; height: 10px; border-radius: 50%; background: #0d6efd; border: 2px solid #fff; }
.timeline-sm .timeline-sm-item .timeline-sm-date { font-size: 12px; color: #64748b; font-weight: 600; display: block; margin-bottom: 4px; }
</style>

<div class="container-fluid py-4" style="background-color:#f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-11">

            <?php if (session()->getFlashdata('msg') !== NULL): ?>
            <div class="alert alert-<?= session()->getFlashdata('msg')[0] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show mb-4" role="alert">
                <?= session()->getFlashdata('msg')[1] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Sidebar Profil -->
                <div class="col-lg-3">
                    <div class="paper-card text-center">
                        <!-- Logo -->
                        <div class="mb-3" style="height:100px;display:flex;align-items:center;justify-content:center;">
                            <?php
                                $logo = $data[0]['logo_perusahaan'] ?? '';
                                if ($logo && file_exists(FCPATH . 'uploads/file_startup/logo_startup/' . $logo)) {
                                    $logo_url = base_url('uploads/file_startup/logo_startup/' . $logo);
                                } elseif ($logo && file_exists(FCPATH . 'uploads/logos/' . $logo)) {
                                    $logo_url = base_url('uploads/logos/' . $logo);
                                } else {
                                    $logo_url = base_url('img/logo-dkst.png');
                                }
                            ?>
                            <img src="<?= $logo_url ?>" style="max-height:100px;max-width:100%;object-fit:contain;">
                        </div>

                        <h5 class="fw-bold mb-1" style="text-transform:capitalize;"><?= esc(strtolower($data[0]['nama_perusahaan'])) ?></h5>
                        <p class="text-muted small mb-2" style="text-transform:capitalize;">
                            <?= is_array($data[0]['klasters']) ? esc(strtolower(implode(', ', $data[0]['klasters']))) : esc(strtolower($data[0]['klasters'])) ?>
                        </p>

                        <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary"><?= esc($data[0]['status_startup']) ?></span>
                            <span class="badge bg-success"><?= esc($data[0]['status_ajuan']) ?></span>
                        </div>

                        <hr>

                        <div class="text-start mb-3">
                            <p class="label-text">Deskripsi</p>
                            <p class="small text-muted mb-0"><?= esc($data[0]['deskripsi_bidang_usaha'] ?: '-') ?></p>
                        </div>

                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <p class="label-text">Berdiri</p>
                                <p class="fw-bold mb-0"><?= esc($data[0]['tahun_berdiri'] ?: '-') ?></p>
                            </div>
                            <div class="col-6">
                                <p class="label-text">Daftar</p>
                                <p class="fw-bold mb-0"><?= esc($data[0]['tahun_daftar'] ?: '-') ?></p>
                            </div>
                        </div>

                        <hr>

                        <!-- Kontak -->
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <?php if($data[0]['nomor_whatsapp']): ?>
                            <a href="https://wa.me/<?= $data[0]['nomor_whatsapp'] ?>" target="_blank" class="btn btn-sm btn-outline-success" title="WhatsApp"><i class="mdi mdi-whatsapp"></i></a>
                            <?php endif; ?>
                            <?php if($data[0]['email_perusahaan']): ?>
                            <a href="mailto:<?= $data[0]['email_perusahaan'] ?>" class="btn btn-sm btn-outline-danger" title="Email"><i class="mdi mdi-email-outline"></i></a>
                            <?php endif; ?>
                            <?php if($data[0]['website_perusahaan']): ?>
                            <a href="<?= $data[0]['website_perusahaan'] ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Website"><i class="mdi mdi-web"></i></a>
                            <?php endif; ?>
                        </div>

                        <!-- Aksi -->
                        <div class="d-grid gap-2">
                            <?php if ($data[0]['status_ajuan'] == 'Pending' && session()->get('user_role') === 'admin'): ?>
                            <button onclick="verifikasi_startup(<?= $data[0]['id_startup'] ?>, <?= session()->get('user_id') ?>)" class="btn btn-success btn-sm"><i class="mdi mdi-check-circle"></i> Verifikasi</button>
                            <button onclick="tolak_startup(<?= $data[0]['id_startup'] ?>, <?= session()->get('user_id') ?>)" class="btn btn-danger btn-sm"><i class="mdi mdi-close-circle"></i> Tolak</button>
                            <?php endif; ?>
                            <?php if (session()->get('user_role') !== 'pemilik_startup'): ?>
                            <a href="<?= base_url('v_data_startup') ?>" class="btn btn-light btn-sm border"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Konten Tab -->
                <div class="col-lg-9">
                    <div class="paper-card">
                        <ul class="nav nav-tabs nav-bordered mb-4">
                            <li class="nav-item"><a href="#startup" data-bs-toggle="tab" class="nav-link active"><i class="mdi mdi-home me-1"></i>Startup</a></li>
                            <li class="nav-item"><a href="#lokasi" data-bs-toggle="tab" class="nav-link"><i class="mdi mdi-map-marker me-1"></i>Lokasi</a></li>
                            <li class="nav-item"><a href="#globe" data-bs-toggle="tab" class="nav-link"><i class="mdi mdi-earth me-1"></i>Globe</a></li>
                        </ul>

                        <div class="tab-content">
                            <!-- Tab Informasi Startup -->
                            <div class="tab-pane show active" id="startup">
                                <div class="section-header">
                                    <span><i class="mdi mdi-information-outline me-1"></i> Informasi Startup</span>
                                    <a href="<?= base_url('v_edit_startup/' . $data[0]['uuid_startup']) ?>" class="btn btn-warning btn-sm text-white"><i class="mdi mdi-pencil"></i></a>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <p class="label-text">Target Pemasaran</p>
                                        <p class="value-text" style="text-transform:capitalize;"><?= esc(strtolower($data[0]['target_pemasaran'] ?: '-')) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">Fokus Pelanggan</p>
                                        <p class="value-text" style="text-transform:capitalize;"><?= esc(strtolower($data[0]['fokus_pelanggan'] ?: '-')) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">Dosen Pembina</p>
                                        <p class="value-text" style="text-transform:capitalize;"><?= esc(strtolower($data[0]['nama_dosen'] ?: '-')) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">Alamat</p>
                                        <p class="value-text" style="text-transform:capitalize;"><?= esc(strtolower($data[0]['alamat'] ?: '-')) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">Program Yang Diikuti</p>
                                        <p class="value-text" style="text-transform:capitalize;"><?= esc(strtolower($data[0]['nama_program'] ?: '-')) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">LinkedIn</p>
                                        <p class="value-text"><?= esc($data[0]['linkedin_perusahaan'] ?: '-') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">Instagram</p>
                                        <p class="value-text"><?= esc($data[0]['instagram_perusahaan'] ?: '-') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">Lokasi</p>
                                        <p class="value-text">
                                            <?php if (!empty($data[0]['latitude']) && !empty($data[0]['longitude'])): ?>
                                                <?php
                                                    $url_peta = session()->get('user_role') === 'pemilik_startup'
                                                        ? base_url('v_lokasi_startup_saya') . '?lat=' . $data[0]['latitude'] . '&lng=' . $data[0]['longitude']
                                                        : base_url('v_detail_lokasi_startup') . '?lat=' . $data[0]['latitude'] . '&lng=' . $data[0]['longitude'];
                                                ?>
                                                <a href="<?= $url_peta ?>"><i class="mdi mdi-map-marker"></i> Lihat di Peta</a>
                                            <?php else: ?>-<?php endif; ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="section-header">
                                    <span><i class="mdi mdi-account-group me-1"></i> Informasi Tim</span>
                                    <button onclick="tambah_informasi_tim()" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Tambah</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr><th>Nama</th><th>Jabatan</th><th>Kontak</th><th>Universitas</th><th class="text-center">Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($data_tim)): foreach ($data_tim as $row): ?>
                                            <tr>
                                                <td><?= esc($row->nama_lengkap) ?></td>
                                                <td><?= esc($row->jabatan_tim) ?></td>
                                                <td><small><?= esc($row->email) ?><br><?= esc($row->no_whatsapp) ?></small></td>
                                                <td><?= esc($row->nama_perguruan_tinggi) ?></td>
                                                <td class="text-center">
                                                    <button onclick="ubah_informasi_tim(<?= $row->id_startup_tim ?>)" class="btn btn-sm btn-warning text-white me-1"><i class="mdi mdi-pencil"></i></button>
                                                    <button onclick="hapus_informasi_tim(<?= $row->id_startup_tim ?>)" class="btn btn-sm btn-danger"><i class="mdi mdi-trash-can"></i></button>
                                                </td>
                                            </tr>
                                            <?php endforeach; else: ?>
                                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data tim</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Lokasi -->
                            <div class="tab-pane" id="lokasi">
                                <div class="section-header"><span><i class="mdi mdi-map-marker me-1"></i> Lokasi Perusahaan</span></div>
                                <?php if (!empty($data[0]['latitude']) && !empty($data[0]['longitude'])): ?>
                                    <div id="map-detail" style="height:400px;border-radius:6px;border:1px solid #dee2e6;"></div>
                                    <p class="mt-2 text-muted small"><i class="mdi mdi-map-marker"></i> Lat: <?= $data[0]['latitude'] ?>, Lng: <?= $data[0]['longitude'] ?></p>
                                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
                                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                                    <script>
                                        document.querySelector('a[href="#lokasi"]').addEventListener('shown.bs.tab', function() {
                                            if (window.mapDetail) return;
                                            window.mapDetail = L.map('map-detail').setView([<?= $data[0]['latitude'] ?>, <?= $data[0]['longitude'] ?>], 15);
                                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(window.mapDetail);
                                            L.marker([<?= $data[0]['latitude'] ?>, <?= $data[0]['longitude'] ?>])
                                                .addTo(window.mapDetail)
                                                .bindPopup('<b><?= esc($data[0]['nama_perusahaan']) ?></b><br><?= esc($data[0]['alamat'] ?? '') ?>')
                                                .openPopup();
                                        });
                                    </script>
                                <?php else: ?>
                                    <p class="text-center text-muted py-5">Titik koordinat lokasi startup belum ditentukan</p>
                                <?php endif; ?>
                            </div>

                            <!-- Tab Globe -->
                            <div class="tab-pane" id="globe">
                                <div class="section-header"><span><i class="mdi mdi-earth me-1"></i> Globe Interaktif — Siklus Siang &amp; Malam</span></div>
                                <style>
                                    .globe-marker-detail-wrap {
                                        width: 30px; height: 30px;
                                        display: flex; align-items: center; justify-content: center;
                                        cursor: pointer;
                                        pointer-events: all !important;
                                    }
                                    .globe-marker-detail {
                                        width: 14px; height: 14px;
                                        border-radius: 50%;
                                        background: #818cf8;
                                        box-shadow: 0 0 8px 3px rgba(129,140,248,0.9);
                                        position: relative;
                                        pointer-events: none;
                                    }
                                    .globe-marker-detail::after {
                                        content: '';
                                        position: absolute;
                                        inset: -5px;
                                        border-radius: 50%;
                                        background: rgba(129,140,248,0.35);
                                        animation: pulse-ring-d 1.6s ease-out infinite;
                                    }
                                    @keyframes pulse-ring-d {
                                        0%   { transform: scale(0.6); opacity: 1; }
                                        100% { transform: scale(2.4); opacity: 0; }
                                    }
                                    #globe-detail-tooltip {
                                        position: fixed;
                                        background: rgba(0,0,0,0.82);
                                        color: #fff;
                                        padding: 6px 12px;
                                        border-radius: 8px;
                                        font-size: 12px;
                                        font-weight: 600;
                                        pointer-events: none;
                                        display: none;
                                        z-index: 99999;
                                        white-space: nowrap;
                                        transform: translate(12px, -50%);
                                    }
                                </style>
                                <div id="globe-detail-tooltip"></div>
                                <div id="globe-detail-wrap" style="width:100%;height:420px;background:#000d1a;border-radius:8px;overflow:hidden;"></div>
                                <script src="//unpkg.com/globe.gl"></script>
                                <script>
                                    document.querySelector('a[href="#globe"]').addEventListener('shown.bs.tab', function() {
                                        if (window.globeDetail) return;
                                        var el = document.getElementById('globe-detail-wrap');
                                        <?php
                                            $hasLoc = !empty($data[0]['latitude']) && !empty($data[0]['longitude']);
                                            $lat = $hasLoc ? (float)$data[0]['latitude'] : -2.5;
                                            $lng = $hasLoc ? (float)$data[0]['longitude'] : 118.0;
                                            $points = $hasLoc ? json_encode([[
                                                'lat'  => (float)$data[0]['latitude'],
                                                'lng'  => (float)$data[0]['longitude'],
                                                'name' => $data[0]['nama_perusahaan'],
                                            ]]) : '[]';
                                        ?>
                                        var points = <?= $points ?>;
                                        window.globeDetail = Globe()(el)
                                            .width(el.offsetWidth)
                                            .height(420)
                                            .globeImageUrl('//unpkg.com/three-globe/example/img/earth-day.jpg')
                                            .backgroundImageUrl('//unpkg.com/three-globe/example/img/night-sky.png')
                                            .atmosphereAltitude(0.18)
                                            .htmlElementsData(points)
                                            .htmlLat('lat')
                                            .htmlLng('lng')
                                            .htmlAltitude(0.01)
                                            .htmlElement(function(d) {
                                                var wrap = document.createElement('div');
                                                wrap.className = 'globe-marker-detail-wrap';
                                                var dot = document.createElement('div');
                                                dot.className = 'globe-marker-detail';
                                                wrap.appendChild(dot);
                                                var tip = document.getElementById('globe-detail-tooltip');
                                                wrap.addEventListener('mouseenter', function(e) {
                                                    tip.textContent = d.name;
                                                    tip.style.display = 'block';
                                                    tip.style.left = (e.clientX + 14) + 'px';
                                                    tip.style.top  = e.clientY + 'px';
                                                });
                                                wrap.addEventListener('mousemove', function(e) {
                                                    tip.style.left = (e.clientX + 14) + 'px';
                                                    tip.style.top  = e.clientY + 'px';
                                                });
                                                wrap.addEventListener('mouseleave', function() {
                                                    tip.style.display = 'none';
                                                });
                                                return wrap;
                                            });
                                        window.globeDetail.pointOfView({ lat: <?= $lat ?>, lng: <?= $lng ?>, altitude: 1.5 }, 1000);
                                        window.globeDetail.controls().autoRotate = true;
                                        window.globeDetail.controls().autoRotateSpeed = 0.4;
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tim -->
<div id="modal_tim" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_tim">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="mdi mdi-account-group me-1"></i> Data Anggota Tim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_startup" value="<?= $data[0]['id_startup'] ?>">
                    <input type="hidden" name="id_startup_tim" id="id_startup_tim">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan_tim" id="jabatan_tim" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. WhatsApp</label>
                            <input type="text" name="no_whatsapp" id="no_whatsapp" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Perguruan Tinggi</label>
                            <input type="text" name="nama_perguruan_tinggi" id="nama_perguruan_tinggi" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-simpan-tim"><i class="mdi mdi-content-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div id="modal_tolak" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_tolak">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="mdi mdi-close-circle me-1"></i> Tolak Startup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_startup" id="tolak_id_s">
                    <input type="hidden" name="id_pengguna" id="tolak_id_p">
                    <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea name="catatan_tolak" class="form-control" rows="4" required placeholder="Tuliskan alasan penolakan..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="mdi mdi-close me-1"></i> Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    function verifikasi_startup(id, idp) {
        if(confirm('Verifikasi startup ini?')) {
            $.ajax({ url: "<?= base_url('startup/proses_verifikasi_startup') ?>", type: 'post', data: { id_startup: id, id_pengguna: idp },
                success: function() { location.reload(); }
            });
        }
    }

    function tolak_startup(id, idp) { $('#tolak_id_s').val(id); $('#tolak_id_p').val(idp); $('#modal_tolak').modal('show'); }

    $('#form_tolak').submit(function() {
        var formData = new FormData(this);
        if(this.checkValidity()) {
            $.ajax({ url: "<?= base_url('startup/proses_tolak_startup') ?>", type: 'post', data: formData, cache: false, contentType: false, processData: false,
                success: function(msg) { var d = jQuery.parseJSON(msg); if(d.status) { $('#modal_tolak').modal('hide'); setTimeout(() => location.reload(), 1000); } }
            });
        } else { $(this).addClass('was-validated'); }
        return false;
    });

    function tambah_informasi_tim() { $('#form_tim')[0].reset(); $('#id_startup_tim').val(''); $('#modal_tim .modal-title').html('<i class="mdi mdi-account-plus me-1"></i> Tambah Anggota Tim'); $('#modal_tim').modal('show'); }

    function ubah_informasi_tim(id) {
        $('#modal_tim .modal-title').html('<i class="mdi mdi-account-edit me-1"></i> Edit Anggota Tim');
        $('#modal_tim').modal('show');
        $.ajax({ url: "<?= base_url('startup/get_startup_tim') ?>", type: 'post', data: { id_startup_tim: id },
            success: function(msg) { var d = jQuery.parseJSON(msg);
                $('#id_startup_tim').val(d[0].id_startup_tim); $('#nama_lengkap').val(d[0].nama_lengkap);
                $('#jabatan_tim').val(d[0].jabatan_tim); $('#jenis_kelamin').val(d[0].jenis_kelamin);
                $('#no_whatsapp').val(d[0].no_whatsapp); $('#email').val(d[0].email);
                $('#nama_perguruan_tinggi').val(d[0].nama_perguruan_tinggi);
            }
        });
    }

    $('#form_tim').submit(function() {
        var formData = new FormData(this);
        $('.btn-simpan-tim').prop('disabled', true).html('<i class="mdi mdi-spin mdi-loading"></i> Loading...');
        var url = $('#id_startup_tim').val() == '' ? "<?= base_url('startup/proses_tambah_informasi_tim') ?>" : "<?= base_url('startup/proses_ubah_informasi_tim') ?>";
        if(this.checkValidity()) {
            $.ajax({ url: url, type: 'post', data: formData, cache: false, contentType: false, processData: false,
                success: function(msg) { 
                    try {
                        var d = jQuery.parseJSON(msg);
                        if(d.status) { 
                            $('#modal_tim').modal('hide'); 
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data tim berhasil disimpan', showConfirmButton: false, timer: 1500 }).then(() => location.reload()); 
                        } else { 
                            $('.btn-simpan-tim').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan'); 
                            Swal.fire('Gagal!', 'Data gagal disimpan.', 'error');
                        }
                    } catch(e) {
                        $('.btn-simpan-tim').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan');
                        console.error(msg);
                        Swal.fire('Error!', 'Terjadi kesalahan sistem di server.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    $('.btn-simpan-tim').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan');
                    Swal.fire('Error!', 'Gagal menghubungi server.', 'error');
                }
            });
        } else { $(this).addClass('was-validated'); $('.btn-simpan-tim').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan'); }
        return false;
    });

    function hapus_informasi_tim(id) {
        Swal.fire({ title: 'Hapus Anggota Tim?', text: 'Data tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
        .then((r) => { if(r.isConfirmed) {
            $.ajax({ url: "<?= base_url('startup/proses_hapus_informasi_tim') ?>", type: 'post', data: { id_startup_tim: id },
                success: function(msg) { var d = jQuery.parseJSON(msg);
                    Swal.fire({ icon: d.status ? 'success' : 'error', title: d.status ? 'Berhasil!' : 'Gagal!', showConfirmButton: false, timer: 1500 }).then(() => { if(d.status) location.reload(); });
                }
            });
        }});
    }

    window.verifikasi_startup = verifikasi_startup;
    window.tolak_startup = tolak_startup;
    window.tambah_informasi_tim = tambah_informasi_tim;
    window.ubah_informasi_tim = ubah_informasi_tim;
    window.hapus_informasi_tim = hapus_informasi_tim;
});
</script>
