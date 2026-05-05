<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style>
    .timeline-sm .timeline-sm-item .timeline-sm-date {
        position: absolute;
        left: -162px;
    }

    .timeline-sm { 
        padding-left: 159px;
    }

    .timeline-sm .timeline-sm-item {
        position: relative;
        padding-bottom: 20px;
        padding-left: 17px;
        border-left: 2px solid var(--ct-gray-300);
    }

    .date_time[readonly] {
        background-color: #ffffff;
        opacity: 1;
    }

    .select2-container--open {
        z-index: 9999999;
    }

    .div_show {
        display: block;
    }

    .div_hide {
        display: none;
    }
</style>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Detail Startup</h4>
                    </div>
                </div>
            </div>     

            <?php if (session()->getFlashdata('msg') !== NULL) { ?>
                <div class="alert <?php if (session()->getFlashdata('msg')[0] == 'success') {
                    echo 'alert-success';
                } else {
                    echo 'alert-danger';
                } ?> alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?php echo session()->getFlashdata('msg')[1]; ?>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-lg-3 col-xl-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php if ($data[0]['status_ajuan'] == 'Pending' && session()->get('user_role') === 'admin') { ?>
                                    <a type="submit" class="dropdown-item" onclick="verifikasi_startup(<?php echo $data[0]['id_startup']; ?>, <?php echo session()->get('user_id'); ?>)"><i class="mdi mdi-check me-1"></i>Verifikasi Startup</a>
                                    <a type="submit" class="dropdown-item" onclick="tolak_startup(<?php echo $data[0]['id_startup']; ?>, <?php echo session()->get('user_id'); ?>)"><i class="mdi mdi-close me-1"></i>Tolak Startup</a>
                                    <?php } ?>
                                    <a href="<?php echo base_url('v_data_startup'); ?>" class="dropdown-item"><i class="mdi mdi-keyboard-backspace"></i> Kembali</a>
                                </div>
                            </div>
                                    
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
                            <img src="<?= $logo_url ?>" class="rounded img-thumbnail mt-4" alt="profile-image" style="width:10rem;height:10rem;object-fit:contain;">

                            <h4 class="mb-0 mt-3"><?php echo $data[0]['nama_perusahaan']; ?></h4>
                            <p class="text-muted small mb-2" style="text-transform:capitalize;">
                                <?= esc(strtolower($data[0]['nama_klaster'] ?? '-')) ?>
                            </p>

                            <div class="text-start mt-3">
                                <h4 class="font-13 text-uppercase">Deskripsi :</h4>
                                <p class="text-muted font-13 mb-3" style="text-align: justify;">
                                <?php echo $data[0]['deskripsi_bidang_usaha'] ?: '-'; ?>
                                </p>
                            
                                <p class="text-muted mb-2 font-13"><strong>Tahun Berdiri : </strong><span class="badge bg-secondary"><?php echo $data[0]['tahun_berdiri'] ?: '-'; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Tahun Daftar : </strong><span class="badge bg-secondary"><?php echo $data[0]['tahun_daftar'] ?: '-'; ?></span></p>
                                
                                <?php if ($data[0]['status_startup'] == 'Aktif' || $data[0]['status_startup'] == 'aktif') { ?>
                                    <p class="text-muted mb-2 font-13"><strong>Status Startup : </strong> <span class="badge bg-success">Aktif</span></p>
                                <?php } else { ?>
                                    <p class="text-muted mb-2 font-13"><strong>Status Startup : </strong> <span class="badge bg-danger">Tidak Aktif</span></p>
                                <?php } ?>
                                
                                <?php if (strtolower($data[0]['status_ajuan']) == 'ajuan' || strtolower($data[0]['status_ajuan']) == 'pending') { ?>
                                    <p class="text-muted mb-2 font-13"><strong>Status Ajuan : </strong> <span class="badge bg-info">Pending</span></p>
                                <?php } else if (strtolower($data[0]['status_ajuan']) == 'verifikasi' || strtolower($data[0]['status_ajuan']) == 'diterima') { ?>
                                    <p class="text-muted mb-2 font-13"><strong>Status Ajuan : </strong> <span class="badge bg-success">Verifikasi</span></p>
                                <?php } else if (strtolower($data[0]['status_ajuan']) == 'tolak' || strtolower($data[0]['status_ajuan']) == 'ditolak') { ?>
                                    <p class="text-muted mb-2 font-13"><strong>Status Ajuan : </strong> <span class="badge bg-danger">Ditolak</span></p>
                                <?php } ?>
                            </div>                                    

                            <ul class="social-list list-inline mt-3 mb-0">
                                <?php if($data[0]['nomor_whatsapp']) { ?>
                                <li class="list-inline-item">
                                    <a href="https://wa.me/<?php echo $data[0]['nomor_whatsapp']; ?>" target="_blank" class="social-list-item border-success text-success"><i class="mdi mdi-whatsapp"></i></a>
                                </li>
                                <?php } ?>
                                <?php if($data[0]['email_perusahaan']) { ?>
                                <li class="list-inline-item">
                                    <a href="mailto:<?php echo $data[0]['email_perusahaan']; ?>" class="social-list-item border-danger text-danger"><i class="mdi mdi-email-outline"></i></a>
                                </li>
                                <?php } ?>
                                <?php if($data[0]['website_perusahaan']) { ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo $data[0]['website_perusahaan']; ?>" target="_blank" class="social-list-item border-primary text-primary"><i class="mdi mdi-web"></i></a>
                                </li>
                                <?php } ?>
                                <?php if($data[0]['linkedin_perusahaan']) { ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo $data[0]['linkedin_perusahaan']; ?>" target="_blank" class="social-list-item border-info text-info"><i class="mdi mdi-linkedin"></i></a>
                                </li>
                                <?php } ?>
                                <?php if($data[0]['instagram_perusahaan']) { ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo $data[0]['instagram_perusahaan']; ?>" target="_blank" class="social-list-item border-pink text-pink"><i class="mdi mdi-instagram"></i></a>
                                </li>
                                <?php } ?>
                            </ul>   
                        </div>                                 
                    </div> <!-- end card -->
                </div> <!-- end col-->

                <div class="col-lg-9 col-xl-9">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#startup" data-bs-toggle="tab" aria-expanded="false" class="nav-link startup active">
                                        <i class="mdi mdi-home"></i> Startup
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#lokasi" data-bs-toggle="tab" aria-expanded="false" class="nav-link lokasi">
                                        <i class="mdi mdi-map-marker"></i> Lokasi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#globe" data-bs-toggle="tab" aria-expanded="false" class="nav-link globe">
                                        <i class="mdi mdi-earth"></i> Globe
                                    </a>
                                </li>
                            </ul>
                            
                            <div class="tab-content"> 
                                <!-- Tab Informasi Startup -->
                                <div class="tab-pane show active" id="startup">
                                    <h5 class="mb-1 bg-light p-2">
                                        <div class="float-end" style="margin-top: -5px;">
                                            <a href="<?= base_url('v_edit_startup/' . $data[0]['uuid_startup']) ?>" class="btn btn-primary btn-xs waves-effect waves-light"><i class="mdi mdi-pencil"></i></a>
                                        </div>
                                        <i class="mdi mdi-office-building me-1"></i> INFORMASI STARTUP
                                    </h5>
                                    <dl class="row mt-3">
                                        <dt class="col-sm-3">Target Pemasaran</dt>
                                        <dd class="col-sm-9"><?php echo $data[0]['target_pemasaran'] ?: '-'; ?></dd>

                                        <dt class="col-sm-3">Fokus Pelanggan</dt>
                                        <dd class="col-sm-9"><?php echo $data[0]['fokus_pelanggan'] ?: '-'; ?></dd>

                                        <dt class="col-sm-3">Dosen Pembina</dt>
                                        <dd class="col-sm-9"><?php echo $data[0]['nama_dosen'] ?: '-'; ?></dd>

                                        <dt class="col-sm-3">Alamat</dt>
                                        <dd class="col-sm-9"><?php echo $data[0]['alamat'] ?: '-'; ?></dd>

                                        <dt class="col-sm-3">Program Yang Diikuti</dt>
                                        <dd class="col-sm-9"><?php echo $data[0]['nama_program'] ?: '-'; ?></dd>
                                    </dl>

                                    <h5 class="mb-3 mt-4 bg-light p-2">
                                        <div class="float-end" style="margin-top: -5px;">
                                            <a type="button" onclick="tambah_informasi_tim(<?php echo $data[0]['id_startup']; ?>)" class="btn btn-primary btn-xs waves-effect waves-light text-white"><i class="mdi mdi-plus"></i></a>
                                        </div>
                                        <i class="mdi mdi-account-group me-1"></i> INFORMASI TIM
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table nowrap w-100 table-bordered" id="tabel-tim">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center" style="width: 15px;">#</th>
                                                    <th class="text-center">Nama Lengkap</th>
                                                    <th class="text-center">Jabatan</th>
                                                    <th class="text-center">Kontak</th>
                                                    <th class="text-center">Perguruan Tinggi</th>
                                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($data_tim)){ $no = 1; foreach ($data_tim as $row) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?>.</td>
                                                    <td><?php echo esc($row->nama_lengkap); ?></td>
                                                    <td><?php echo esc($row->jabatan_tim); ?></td>
                                                    <td><small><?php echo esc($row->email); ?><br><?php echo esc($row->no_whatsapp); ?></small></td>
                                                    <td><?php echo esc($row->nama_perguruan_tinggi); ?></td>
                                                    <td class="text-center">
                                                        <a type="button" onclick="ubah_informasi_tim(<?php echo $row->id_startup_tim; ?>)" class="btn btn-warning btn-xs waves-effect waves-light text-white"><i class="mdi mdi-pencil"></i></a>
                                                        <a type="button" onclick="hapus_informasi_tim(<?php echo $row->id_startup_tim; ?>)" class="btn btn-danger btn-xs waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $no++; } } else { ?>
                                                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data tim</td></tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Tab Lokasi -->
                                <div class="tab-pane" id="lokasi">
                                    <h5 class="mb-3 bg-light p-2">
                                        <i class="mdi mdi-map-marker me-1"></i> LOKASI PERUSAHAAN
                                    </h5>
                                    <?php if (!empty($data[0]['latitude']) && !empty($data[0]['longitude'])): ?>
                                        <div id="map-detail" style="height:400px;border-radius:4px;border:1px solid #dee2e6;"></div>
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
                                                setTimeout(function() { window.mapDetail.invalidateSize(); }, 100);
                                            });
                                        </script>
                                    <?php else: ?>
                                        <p class="text-center text-muted py-5">Titik koordinat lokasi startup belum ditentukan</p>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Tab Globe -->
                                <div class="tab-pane" id="globe">
                                    <h5 class="mb-3 bg-light p-2">
                                        <i class="mdi mdi-earth me-1"></i> GLOBE INTERAKTIF
                                    </h5>
                                    <style>
                                        .globe-marker-detail-wrap { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; pointer-events: all !important; }
                                        .globe-marker-detail { width: 14px; height: 14px; border-radius: 50%; background: #818cf8; box-shadow: 0 0 8px 3px rgba(129,140,248,0.9); position: relative; pointer-events: none; }
                                        .globe-marker-detail::after { content: ''; position: absolute; inset: -5px; border-radius: 50%; background: rgba(129,140,248,0.35); animation: pulse-ring-d 1.6s ease-out infinite; }
                                        @keyframes pulse-ring-d { 0% { transform: scale(0.6); opacity: 1; } 100% { transform: scale(2.4); opacity: 0; } }
                                        #globe-detail-tooltip { position: fixed; background: rgba(0,0,0,0.82); color: #fff; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; pointer-events: none; display: none; z-index: 99999; white-space: nowrap; transform: translate(12px, -50%); }
                                    </style>
                                    <div id="globe-detail-tooltip"></div>
                                    <div id="globe-detail-wrap" style="width:100%;height:420px;background:#000d1a;border-radius:4px;overflow:hidden;"></div>
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
                            </div> <!-- end tab content -->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- container -->
    </div> <!-- content -->
</div>

<!-- Modals -->
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
                    <button type="submit" class="btn btn-danger btn-simpan-tolak"><i class="mdi mdi-close me-1"></i> Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function initDetailStartup() {
    window.verifikasi_startup = function(id, idp) {
        if(confirm('Verifikasi startup ini?')) {
            $.ajax({ url: "<?= base_url('startup/proses_verifikasi_startup') ?>", type: 'post', data: { id_startup: id, id_pengguna: idp },
                success: function() { location.reload(); }
            });
        }
    }

    window.tolak_startup = function(id, idp) { 
        $('#tolak_id_s').val(id); 
        $('#tolak_id_p').val(idp); 
        var modalEl = document.getElementById('modal_tolak');
        if (modalEl) {
            var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.show();
        }
    }

    $('#form_tolak').off('submit').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if(this.checkValidity()) {
            $('.btn-simpan-tolak').prop('disabled', true).html('<i class="mdi mdi-spin mdi-loading"></i> Loading...');
            $.ajax({ url: "<?= base_url('startup/proses_tolak_startup') ?>", type: 'post', data: formData, cache: false, contentType: false, processData: false,
                success: function(msg) { 
                    var d = typeof msg === 'string' ? JSON.parse(msg) : msg; 
                    if(d.status) { 
                        var modalEl = document.getElementById('modal_tolak');
                        if (modalEl) {
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                        }
                        setTimeout(() => { location.reload(); }, 1000); 
                    } else {
                        $('.btn-simpan-tolak').prop('disabled', false).html('<i class="mdi mdi-close me-1"></i> Tolak');
                    }
                }
            });
        } else { $(this).addClass('was-validated'); }
        return false;
    });

    window.tambah_informasi_tim = function() { 
        $('#form_tim')[0].reset(); 
        $('#id_startup_tim').val(''); 
        $('#modal_tim .modal-title').html('<i class="mdi mdi-account-plus me-1"></i> Tambah Anggota Tim'); 
        var modalEl = document.getElementById('modal_tim');
        if (modalEl) {
            var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.show();
        }
    }

    window.ubah_informasi_tim = function(id) {
        $('#modal_tim .modal-title').html('<i class="mdi mdi-account-edit me-1"></i> Edit Anggota Tim');
        var modalEl = document.getElementById('modal_tim');
        if (modalEl) {
            var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.show();
        }
        $.ajax({ url: "<?= base_url('startup/get_startup_tim') ?>", type: 'post', data: { id_startup_tim: id },
            success: function(msg) { 
                var d = typeof msg === 'string' ? JSON.parse(msg) : msg;
                $('#id_startup_tim').val(d[0].id_startup_tim); $('#nama_lengkap').val(d[0].nama_lengkap);
                $('#jabatan_tim').val(d[0].jabatan_tim); $('#jenis_kelamin').val(d[0].jenis_kelamin);
                $('#no_whatsapp').val(d[0].no_whatsapp); $('#email').val(d[0].email);
                $('#nama_perguruan_tinggi').val(d[0].nama_perguruan_tinggi);
            }
        });
    }

    $('#form_tim').off('submit').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('.btn-simpan-tim').prop('disabled', true).html('<i class="mdi mdi-spin mdi-loading"></i> Loading...');
        var url = $('#id_startup_tim').val() == '' ? "<?= base_url('startup/proses_tambah_informasi_tim') ?>" : "<?= base_url('startup/proses_ubah_informasi_tim') ?>";
        if(this.checkValidity()) {
            $.ajax({ url: url, type: 'post', data: formData, cache: false, contentType: false, processData: false,
                success: function(msg) { 
                    try {
                        var d = typeof msg === 'string' ? JSON.parse(msg) : msg;
                        if(d.status) { 
                            var modalEl = document.getElementById('modal_tim');
                            if (modalEl) {
                                var modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) modal.hide();
                            }
                            if(typeof Swal !== "undefined") {
                                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data tim berhasil disimpan', showConfirmButton: false, timer: 1500 }).then(() => {
                                    location.reload();
                                }); 
                            } else {
                                location.reload();
                            }
                        } else { 
                            $('.btn-simpan-tim').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan'); 
                            if(typeof Swal !== "undefined") Swal.fire('Gagal!', 'Data gagal disimpan.', 'error');
                        }
                    } catch(e) {
                        $('.btn-simpan-tim').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan');
                        console.error(msg);
                        if(typeof Swal !== "undefined") Swal.fire('Error!', 'Terjadi kesalahan sistem di server.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    $('.btn-simpan-tim').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan');
                    if(typeof Swal !== "undefined") Swal.fire('Error!', 'Gagal menghubungi server.', 'error');
                }
            });
        } else { $(this).addClass('was-validated'); $('.btn-simpan-tim').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan'); }
        return false;
    });

    window.hapus_informasi_tim = function(id) {
        if(typeof Swal !== "undefined") {
            Swal.fire({ title: 'Hapus Anggota Tim?', text: 'Data tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
            .then((r) => { if(r.isConfirmed) {
                $.ajax({ url: "<?= base_url('startup/proses_hapus_informasi_tim') ?>", type: 'post', data: { id_startup_tim: id },
                    success: function(msg) { 
                        var d = typeof msg === 'string' ? JSON.parse(msg) : msg;
                        Swal.fire({ icon: d.status ? 'success' : 'error', title: d.status ? 'Berhasil!', showConfirmButton: false, timer: 1500 }).then(() => { 
                            if(d.status) { location.reload(); }
                        });
                    }
                });
            }});
        } else {
            if(confirm('Hapus Anggota Tim? Data tidak dapat dikembalikan.')) {
                $.ajax({ url: "<?= base_url('startup/proses_hapus_informasi_tim') ?>", type: 'post', data: { id_startup_tim: id },
                    success: function(msg) { 
                        location.reload();
                    }
                });
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', initDetailStartup);
</script>
