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
.btn-modern { border-radius: 6px; font-weight: 500; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.info-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-size: 14px; color: #475569; }
.info-row strong { color: #1e293b; }
.peserta-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 8px; }
.avatar-kecil { width: 34px; height: 34px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; color: #475569; flex-shrink: 0; }
.form-control { border-radius: 6px; border: 1px solid #cbd5e1; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
.countdown-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px 20px; text-align: center; }
/* Meeting card */
.akses-card {
    display: flex; align-items: center; gap: 16px;
    background: #f0f7ff; border: 1px solid #bfdbfe;
    border-radius: 12px; padding: 18px 20px;
}
.akses-card-icon {
    width: 52px; height: 52px; border-radius: 12px;
    background: #3b82f6; color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; flex-shrink: 0;
}
.akses-card-body { flex: 1; }
.akses-card-title { font-weight: 700; font-size: 15px; color: #1e293b; }
.akses-card-sub { font-size: 12px; color: #64748b; margin-top: 2px; }
/* Custom video player */
.video-player-wrap {
    position: relative; width: 100%; border-radius: 12px;
    overflow: hidden; background: #000;
    aspect-ratio: 16/9; box-shadow: 0 8px 24px rgba(0,0,0,0.18);
}
.video-thumb {
    width: 100%; height: 100%; object-fit: cover;
    display: block; transition: transform 0.3s;
}
.video-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.15) 50%, transparent 100%);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    cursor: pointer;
}
.video-overlay:hover .video-thumb { transform: scale(1.03); }
.play-btn {
    width: 68px; height: 68px; border-radius: 50%;
    background: rgba(255,255,255,0.95);
    display: flex; align-items: center; justify-content: center;
    font-size: 32px; color: #1e293b;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    transition: transform 0.2s, background 0.2s;
    margin-bottom: 12px;
}
.video-overlay:hover .play-btn { transform: scale(1.1); background: #fff; }
.video-title {
    position: absolute; bottom: 16px; left: 20px; right: 20px;
    color: #fff; font-size: 14px; font-weight: 600;
    text-shadow: 0 1px 4px rgba(0,0,0,0.5);
}
</style>

<div class="container-fluid py-4" style="background-color: #f5f5f5;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-xl-9">

            <?php if (session()->getFlashdata('success')): ?>
            <script data-flashdata>Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 2500, showConfirmButton: false });</script>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <script data-flashdata>Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('error') ?>' });</script>
            <?php endif; ?>

            <div class="mb-4">
                <?php
                    $from     = service('request')->getGet('from');
                    $role_now = session()->get('user_role');
                    if ($from === 'kalender') {
                        $back_url = base_url('jadwal_kelas');
                    } elseif ($role_now === 'pemateri' && $bisa_kelola) {
                        $back_url = base_url('v_dashboard');
                    } elseif (in_array($role_now, ['admin','superadmin'])) {
                        $back_url = base_url('program/detail_program/' . $program['id_program']);
                    } else {
                        $back_url = base_url('program');
                    }
                ?>
                <a href="<?= $back_url ?>" class="btn btn-light btn-modern border">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Info Kelas -->
            <div class="paper-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h4 class="font-weight-bold text-dark mb-0"><?= esc($kelas['nama_kelas']) ?></h4>
                    <span class="badge <?= $kelas['status_kelas'] == 'aktif' ? 'bg-primary' : ($kelas['status_kelas'] == 'selesai' ? 'bg-success' : 'bg-danger') ?> px-3 py-2">
                        <?= ucfirst($kelas['status_kelas']) ?>
                    </span>
                </div>

                <?php if (!empty($kelas['deskripsi'])): ?>
                    <p class="text-muted small mb-3"><?= esc($kelas['deskripsi']) ?></p>
                <?php endif; ?>

                <div class="info-row"><i class="mdi mdi-book-open-variant text-primary"></i><strong>Program:</strong> <?= esc($program['nama_program'] ?? '-') ?></div>
                <div class="info-row"><i class="mdi mdi-calendar text-primary"></i><strong>Tanggal:</strong> <?= !empty($kelas['tanggal']) && $kelas['tanggal'] != '0000-00-00' ? date('d M Y', strtotime($kelas['tanggal'])) : '-' ?></div>
                <div class="info-row"><i class="mdi mdi-clock text-primary"></i><strong>Waktu:</strong> <?= !empty($kelas['jam_mulai']) && $kelas['jam_mulai'] != '00:00:00' ? date('H:i', strtotime($kelas['jam_mulai'])) : '-' ?> - <?= !empty($kelas['jam_selesai']) && $kelas['jam_selesai'] != '00:00:00' ? date('H:i', strtotime($kelas['jam_selesai'])) : '-' ?> WIB</div>
                <?php if (!empty($kelas['nama_dosen'])): ?>
                <div class="info-row"><i class="mdi mdi-account-tie text-primary"></i><strong>Pemateri:</strong> <?= esc($kelas['nama_dosen']) ?></div>
                <?php endif; ?>
                <?php if (!empty($kelas['tipe_kelas'])): ?>
                <div class="info-row"><i class="mdi mdi-laptop text-primary"></i><strong>Tipe:</strong> <?= ucfirst($kelas['tipe_kelas']) ?>
                    <?php if ($kelas['tipe_kelas'] === 'online' && !empty($kelas['platform_online'])): ?>
                        — <?= esc($kelas['platform_online']) ?>
                    <?php elseif ($kelas['tipe_kelas'] === 'offline' && !empty($kelas['lokasi_offline'])): ?>
                        — <?= esc($kelas['lokasi_offline']) ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php
                $jam_mulai   = strtotime($kelas['tanggal'] . ' ' . $kelas['jam_mulai']);
                $jam_selesai = strtotime($kelas['tanggal'] . ' ' . $kelas['jam_selesai']);
                $sekarang    = time();
                $buka_presensi = $jam_mulai - 1800; // 30 menit sebelum
            ?>

                        <!-- Section untuk peserta (bukan admin) -->
            <?php if (!$bisa_kelola && $sudah_join): ?>

                <?php if ($sekarang < $buka_presensi): ?>
                <!-- Belum waktunya -->
                <div class="paper-card text-center">
                    <div class="countdown-box mb-3">
                        <div class="text-muted small mb-1">Kelas dibuka dalam</div>
                        <div id="countdown" class="fw-bold text-primary" style="font-size:2rem; letter-spacing:2px;">--:--:--</div>
                        <div class="text-muted small mt-1">Kelas dibuka 30 menit sebelum dimulai</div>
                    </div>
                </div>

                <?php else: ?>
                <!-- Tab untuk peserta -->
                <div class="paper-card">
                    <?php
                        $ada_meeting = !empty($kelas['link_meeting']) || !empty($kelas['link_zoom']);
                        $ada_video   = !empty($kelas['link_youtube']);
                        $tab_aktif_pertama = $ada_meeting ? 'akses' : ($ada_video ? 'media' : 'materi');
                    ?>
                    <ul class="nav nav-tabs mb-4" id="pesertaTab">
                        <?php if ($ada_meeting): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab_aktif_pertama === 'akses' ? 'active' : '' ?>" data-bs-toggle="tab" href="#ptab-akses"><i class="mdi mdi-video me-1"></i> Akses Kelas</a>
                        </li>
                        <?php endif; ?>
                        <?php if ($ada_video): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab_aktif_pertama === 'media' ? 'active' : '' ?>" data-bs-toggle="tab" href="#ptab-media"><i class="mdi mdi-play-circle me-1"></i> Media Kelas</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab_aktif_pertama === 'materi' ? 'active' : '' ?>" data-bs-toggle="tab" href="#ptab-materi"><i class="mdi mdi-folder-open me-1"></i> Materi <span class="badge bg-secondary ms-1"><?= count($materi) ?></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#ptab-tugas"><i class="mdi mdi-clipboard-text me-1"></i> Tugas <span class="badge bg-secondary ms-1"><?= count($tugas_list) ?></span></a>
                        </li>
                    </ul>

                    <div class="tab-content">

                    <!-- Tab Akses Kelas -->
                    <?php if ($ada_meeting): ?>
                    <div class="tab-pane fade <?= $tab_aktif_pertama === 'akses' ? 'show active' : '' ?>" id="ptab-akses">
                        <div class="akses-card">
                            <div class="akses-card-icon"><i class="mdi mdi-video-outline"></i></div>
                            <div class="akses-card-body">
                                <div class="akses-card-title">Link Meeting Kelas</div>
                                <div class="akses-card-sub"><?= esc($kelas['platform_online'] ?? 'Online Meeting') ?> &bull; <?= date('d M Y', strtotime($kelas['tanggal'])) ?>, <?= date('H:i', strtotime($kelas['jam_mulai'])) ?>–<?= date('H:i', strtotime($kelas['jam_selesai'])) ?> WIB</div>
                            </div>
                            <a href="<?= esc(!empty($kelas['link_meeting']) ? $kelas['link_meeting'] : $kelas['link_zoom']) ?>" target="_blank" class="btn btn-primary btn-modern px-4">
                                <i class="mdi mdi-launch"></i> Masuk Kelas
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Tab Media Kelas -->
                    <?php if ($ada_video):
                        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $kelas['link_youtube'], $yt_m);
                        $yt_id_peserta = $yt_m[1] ?? null;
                    ?>
                    <div class="tab-pane fade <?= $tab_aktif_pertama === 'media' ? 'show active' : '' ?>" id="ptab-media">
                        <?php if ($yt_id_peserta): ?>
                        <a href="<?= base_url('program/nonton_kelas/' . $kelas['id_kelas']) ?>" class="text-decoration-none d-block">
                            <div class="video-player-wrap">
                                <img src="https://img.youtube.com/vi/<?= esc($yt_id_peserta) ?>/maxresdefault.jpg"
                                     onerror="this.src='https://img.youtube.com/vi/<?= esc($yt_id_peserta) ?>/hqdefault.jpg'"
                                     alt="<?= esc($kelas['nama_kelas']) ?>" class="video-thumb">
                                <div class="video-overlay">
                                    <div class="play-btn"><i class="mdi mdi-play"></i></div>
                                    <div class="video-title"><?= esc($kelas['nama_kelas']) ?></div>
                                </div>
                            </div>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Tab Materi -->
                    <div class="tab-pane fade <?= $tab_aktif_pertama === 'materi' ? 'show active' : '' ?>" id="ptab-materi">
                        <?php if (empty($materi)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="mdi mdi-file-document-outline" style="font-size:40px; color:#cbd5e1;"></i>
                                <p class="mt-2 small">Belum ada materi yang diunggah.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($materi as $m): ?>
                            <?php
                                $ikon_map = [
                                    'pdf'  => ['mdi-file-pdf-box', '#ef4444', '#fef2f2'],
                                    'ppt'  => ['mdi-file-powerpoint', '#f97316', '#fff7ed'],
                                    'pptx' => ['mdi-file-powerpoint', '#f97316', '#fff7ed'],
                                    'doc'  => ['mdi-file-word', '#3b82f6', '#eff6ff'],
                                    'docx' => ['mdi-file-word', '#3b82f6', '#eff6ff'],
                                    'xls'  => ['mdi-file-excel', '#22c55e', '#f0fdf4'],
                                    'xlsx' => ['mdi-file-excel', '#22c55e', '#f0fdf4'],
                                    'zip'  => ['mdi-folder-zip', '#a855f7', '#faf5ff'],
                                    'png'  => ['mdi-file-image', '#06b6d4', '#ecfeff'],
                                    'jpg'  => ['mdi-file-image', '#06b6d4', '#ecfeff'],
                                ];
                                $tipe_m = strtolower($m['tipe_file'] ?? '');
                                $ikon   = $ikon_map[$tipe_m] ?? ['mdi-file-document', '#64748b', '#f8fafc'];
                            ?>
                            <div class="peserta-item">
                                <div class="d-flex align-items-center gap-3 flex-grow-1">
                                    <div class="avatar-kecil" style="background:<?= $ikon[2] ?>; color:<?= $ikon[1] ?>; border-radius:8px;">
                                        <i class="mdi <?= $ikon[0] ?>"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="text-dark small"><?= esc($m['judul']) ?></strong>
                                        <?php if (!empty($m['deskripsi'])): ?><div class="text-muted" style="font-size:12px;"><?= esc($m['deskripsi']) ?></div><?php endif; ?>
                                        <div class="text-muted" style="font-size:11px;"><?= esc($m['diunggah_oleh']) ?> &bull; <?= date('d M Y, H:i', strtotime($m['dibuat_pada'])) ?></div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 ms-2 flex-shrink-0">
                                    <?php if (!empty($m['link_berbagi'])): ?>
                                        <a href="<?= esc($m['link_berbagi']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded"><i class="mdi mdi-open-in-new"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($m['nama_file'])): ?>
                                        <?php $bisa_prev = in_array(strtolower($m['tipe_file'] ?? ''), ['pdf','png','jpg','jpeg','gif','doc','docx','ppt','pptx','xls','xlsx']); ?>
                                        <?php if ($bisa_prev): ?>
                                        <button type="button" class="btn btn-sm btn-outline-info rounded"
                                            onclick="buka_preview('<?= base_url('materi_kelas/preview_materi/' . $m['id_materi']) ?>', '<?= esc($m['judul']) ?>', '<?= strtolower($m['tipe_file'] ?? '') ?>')">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Tab Tugas -->
                    <div class="tab-pane fade" id="ptab-tugas">
                        <?php if (empty($tugas_list)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="mdi mdi-clipboard-text-outline" style="font-size:40px; color:#cbd5e1;"></i>
                                <p class="mt-2 small">Belum ada tugas untuk kelas ini.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($tugas_list as $t): ?>
                            <?php $jawaban_saya = array_filter($semua_jawaban[$t['id_tugas']] ?? [], fn($j) => $j['nama_peserta'] === $nama_peserta); ?>
                            <div class="border rounded p-3 mb-3">
                                <strong class="text-dark"><?= esc($t['judul']) ?></strong>
                                <?php if (!empty($t['instruksi'])): ?>
                                    <p class="text-muted small mt-1 mb-2"><?= nl2br(esc($t['instruksi'])) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($jawaban_saya)): ?>
                                    <?php foreach ($jawaban_saya as $j): ?>
                                    <div class="bg-light rounded p-2 mt-2" style="font-size:13px;">
                                        <div class="text-muted" style="font-size:11px;">Jawaban saya &bull; <?= date('d M Y, H:i', strtotime($j['dibuat_pada'])) ?></div>
                                        <?php if (!empty($j['jawaban_teks'])): ?><div class="mt-1"><?= nl2br(esc($j['jawaban_teks'])) ?></div><?php endif; ?>
                                        <?php if (!empty($j['nama_file'])): ?>
                                            <a href="<?= base_url('tugas_kelas/download/jawaban/' . $j['id_jawaban']) ?>" class="btn btn-xs btn-outline-success rounded mt-1" style="font-size:12px; padding:2px 10px;">
                                                <i class="mdi mdi-download"></i> Unduh Jawaban
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($j['komentar'])): ?>
                                            <div class="mt-1 p-2 rounded" style="background:#fffbeb; border:1px solid #fde68a; font-size:12px;">
                                                <strong>Komentar Pemateri:</strong> <?= nl2br(esc($j['komentar'])) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <form action="<?= base_url('tugas_kelas/simpan_jawaban') ?>" method="POST" enctype="multipart/form-data" class="mt-2">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_tugas" value="<?= $t['id_tugas'] ?>">
                                        <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                        <input type="hidden" name="from" value="<?= base_url('presensi_kelas/detail_kelas/' . $kelas['id_kelas']) ?>">
                                        <div class="mb-2">
                                            <textarea class="form-control" name="jawaban_teks" rows="3" placeholder="Tulis jawaban kamu..."></textarea>
                                        </div>
                                        <div class="mb-2">
                                            <input type="file" class="form-control form-control-sm" name="file_jawaban">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-warning"><i class="mdi mdi-send"></i> Kirim Jawaban</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    </div><!-- end tab-content -->
                </div>
                <?php endif; ?>
            <?php elseif (!$bisa_kelola && !$sudah_join): ?>
            <div class="paper-card text-center py-4">
                <p class="text-muted">Anda harus bergabung ke program ini untuk mengakses kelas.</p>
                <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-primary btn-modern">Gabung Program</a>
            </div>
            <?php endif; ?>

            <!-- Daftar Presensi (hanya admin/pemateri) -->
            <?php if ($bisa_kelola): ?>
            <div class="paper-card">
                <ul class="nav nav-tabs mb-4" id="kelasTab">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-materi">Materi Kelas <span class="badge bg-secondary ms-1"><?= count($materi) ?></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-akses">Media Kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-tugas">Tugas <span class="badge bg-secondary ms-1"><?= count($tugas_list) ?></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-hadir">Kehadiran <span class="badge bg-secondary ms-1"><?= count($presensi) ?></span></a>
                    </li>
                </ul>

                <div class="tab-content">

                <!-- Tab Materi Kelas -->
                <div class="tab-pane fade show active" id="tab-materi">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#modalUploadMateri">
                        <i class="mdi mdi-upload"></i> Tambah Materi
                    </button>
                </div>

                <p class="fw-semibold text-dark mb-3 border-bottom pb-2">Daftar Materi <span class="badge bg-secondary ms-1"><?= count($materi) ?></span></p>

                <?php if (empty($materi)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="mdi mdi-file-document-outline" style="font-size:40px; color:#cbd5e1;"></i>
                        <p class="mt-2 small">Belum ada materi yang diunggah.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($materi as $m): ?>
                    <?php
                        $ikon_map = [
                            'pdf'  => ['mdi-file-pdf-box', '#ef4444', '#fef2f2'],
                            'ppt'  => ['mdi-file-powerpoint', '#f97316', '#fff7ed'],
                            'pptx' => ['mdi-file-powerpoint', '#f97316', '#fff7ed'],
                            'doc'  => ['mdi-file-word', '#3b82f6', '#eff6ff'],
                            'docx' => ['mdi-file-word', '#3b82f6', '#eff6ff'],
                            'xls'  => ['mdi-file-excel', '#22c55e', '#f0fdf4'],
                            'xlsx' => ['mdi-file-excel', '#22c55e', '#f0fdf4'],
                            'zip'  => ['mdi-folder-zip', '#a855f7', '#faf5ff'],
                            'png'  => ['mdi-file-image', '#06b6d4', '#ecfeff'],
                            'jpg'  => ['mdi-file-image', '#06b6d4', '#ecfeff'],
                        ];
                        $tipe_m = strtolower($m['tipe_file'] ?? '');
                        $ikon   = $ikon_map[$tipe_m] ?? ['mdi-file-document', '#64748b', '#f8fafc'];
                    ?>
                    <div class="peserta-item">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <div class="avatar-kecil" style="background:<?= $ikon[2] ?>; color:<?= $ikon[1] ?>; border-radius:8px;">
                                <i class="mdi <?= $ikon[0] ?>"></i>
                            </div>
                            <div class="flex-grow-1">
                                <strong class="text-dark small"><?= esc($m['judul']) ?></strong>
                                <?php if (!empty($m['deskripsi'])): ?><div class="text-muted" style="font-size:12px;"><?= esc($m['deskripsi']) ?></div><?php endif; ?>
                                <div class="text-muted" style="font-size:11px;"><?= esc($m['diunggah_oleh']) ?> &bull; <?= date('d M Y, H:i', strtotime($m['dibuat_pada'])) ?></div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 ms-2 flex-shrink-0">
                            <?php if (!empty($m['link_berbagi'])): ?>
                                <a href="<?= esc($m['link_berbagi']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded"><i class="mdi mdi-open-in-new"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($m['nama_file'])): ?>
                                <?php $bisa_prev = in_array(strtolower($m['tipe_file'] ?? ''), ['pdf','png','jpg','jpeg','gif','doc','docx','ppt','pptx','xls','xlsx']); ?>
                                <?php if ($bisa_prev): ?>
                                <button type="button" class="btn btn-sm btn-outline-info rounded"
                                    onclick="buka_preview('<?= base_url('materi_kelas/preview_materi/' . $m['id_materi']) ?>', '<?= esc($m['judul']) ?>', '<?= strtolower($m['tipe_file'] ?? '') ?>')">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($bisa_kelola): ?>
                            <form action="<?= base_url('materi_kelas/hapus_materi') ?>" method="POST" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_materi" value="<?= $m['id_materi'] ?>">
                                <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded" onclick="return swalConfirm(this.closest('form'))"><i class="mdi mdi-delete"></i></button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>

                <!-- Tab Akses Kelas -->
                <div class="tab-pane fade" id="tab-akses">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMedia">
                        <i class="mdi mdi-plus-circle"></i> Tambah Media Kelas
                    </button>
                </div>
                <?php
                    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $kelas['link_youtube'] ?? '', $yt_m);
                    $yt_id = $yt_m[1] ?? null;
                ?>
                <?php if (!empty($kelas['link_zoom'])): ?>
                <div class="akses-card mb-4">
                    <div class="akses-card-icon"><i class="mdi mdi-video-outline"></i></div>
                    <div class="akses-card-body">
                        <div class="akses-card-title">Link Meeting Kelas</div>
                        <div class="akses-card-sub"><?= esc($kelas['platform_online'] ?? 'Online Meeting') ?> &bull; <?= date('d M Y', strtotime($kelas['tanggal'])) ?>, <?= date('H:i', strtotime($kelas['jam_mulai'])) ?>–<?= date('H:i', strtotime($kelas['jam_selesai'])) ?> WIB</div>
                    </div>
                    <a href="<?= esc($kelas['link_zoom']) ?>" target="_blank" class="btn btn-primary btn-modern px-4">
                        <i class="mdi mdi-launch"></i> Buka Meeting
                    </a>
                </div>
                <?php endif; ?>
                <?php if ($yt_id): ?>
                <a href="<?= base_url('program/nonton_kelas/' . $kelas['id_kelas']) ?>" class="text-decoration-none d-block">
                    <div class="video-player-wrap">
                        <img src="https://img.youtube.com/vi/<?= esc($yt_id) ?>/maxresdefault.jpg"
                             onerror="this.src='https://img.youtube.com/vi/<?= esc($yt_id) ?>/hqdefault.jpg'"
                             alt="<?= esc($kelas['nama_kelas']) ?>" class="video-thumb">
                        <div class="video-overlay">
                            <div class="play-btn"><i class="mdi mdi-play"></i></div>
                            <div class="video-title"><?= esc($kelas['nama_kelas']) ?></div>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
                <?php if (empty($kelas['link_zoom']) && !$yt_id): ?>
                    <div class="text-center text-muted py-4">
                        <i class="mdi mdi-link-off" style="font-size:40px; color:#cbd5e1;"></i>
                        <p class="mt-2 small">Belum ada media kelas yang ditambahkan.</p>
                    </div>
                <?php endif; ?>
                </div>

                <!-- Tab Tugas -->
                <div class="tab-pane fade" id="tab-tugas">
                <?php if (session()->get('user_role') === 'pemateri'): ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">
                        <i class="mdi mdi-plus"></i> Tambah Tugas
                    </button>
                </div>
                <?php endif; ?>
                <?php if (empty($tugas_list)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="mdi mdi-clipboard-text-outline" style="font-size:40px; color:#cbd5e1;"></i>
                        <p class="mt-2 small">Belum ada tugas untuk kelas ini.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($tugas_list as $t): ?>
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong class="text-dark"><?= esc($t['judul']) ?></strong>
                                <div class="text-muted" style="font-size:11px;"><?= esc($t['dibuat_oleh']) ?> &bull; <?= date('d M Y, H:i', strtotime($t['dibuat_pada'])) ?></div>
                            </div>
                            <span class="badge bg-secondary"><?= count($semua_jawaban[$t['id_tugas']] ?? []) ?> jawaban</span>
                        </div>
                        <?php if (!empty($t['instruksi'])): ?>
                            <p class="text-muted small mb-2"><?= nl2br(esc($t['instruksi'])) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($t['link_file']) || !empty($t['nama_file'])): ?>
                        <div class="d-flex gap-2 mb-2">
                            <?php if (!empty($t['link_file'])): ?>
                            <a href="<?= esc($t['link_file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded">
                                <i class="mdi mdi-link-variant"></i> Buka File Tugas
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($t['nama_file'])): ?>
                            <a href="<?= base_url('tugas_kelas/download/tugas/' . $t['id_tugas']) ?>" class="btn btn-sm btn-outline-success rounded">
                                <i class="mdi mdi-download"></i> Unduh File
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php $jawaban_list = $semua_jawaban[$t['id_tugas']] ?? []; ?>
                        <?php if (!empty($jawaban_list)): ?>
                        <div class="mt-2 border-top pt-2">
                            <div class="fw-semibold small text-muted mb-2">Sudah Mengumpulkan <span class="badge bg-success"><?= count($jawaban_list) ?></span></div>
                            <?php foreach ($jawaban_list as $j): ?>
                            <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                                <div class="avatar-kecil"><?= strtoupper(substr($j['nama_peserta'], 0, 1)) ?></div>
                                <div class="flex-grow-1">
                                    <strong class="small"><?= esc($j['nama_peserta']) ?></strong>
                                    <div class="text-muted" style="font-size:11px;"><?= date('d M Y, H:i', strtotime($j['dibuat_pada'])) ?></div>
                                </div>
                                <span class="badge bg-success"><i class="mdi mdi-check"></i> Selesai</span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>

                <!-- Tab Daftar Hadir -->
                <div class="tab-pane fade" id="tab-hadir">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPresensi">
                        <i class="mdi mdi-check-circle-outline"></i> Konfirmasi Kehadiran
                    </button>
                </div>
                <?php if (empty($presensi)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="mdi mdi-account-group-outline" style="font-size:40px; color:#cbd5e1;"></i>
                        <p class="mt-2 small">Belum ada peserta yang presensi.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($presensi as $p): ?>
                    <div class="peserta-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-kecil"><?= strtoupper(substr($p['nama_peserta'], 0, 1)) ?></div>
                            <div>
                                <div class="fw-semibold small text-dark"><?= esc($p['nama_peserta']) ?></div>
                                <?php if (!empty($p['kondisi_hadir'])): ?>
                                    <span class="badge bg-primary mt-1" style="font-size:10px;"><?= esc($p['kondisi_hadir']) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($p['catatan'])): ?>
                                    <div class="text-muted" style="font-size:12px;"><?= esc($p['catatan']) ?></div>
                                <?php endif; ?>
                                <div class="text-muted" style="font-size:11px;"><?= date('d M Y, H:i', strtotime($p['dibuat_pada'])) ?></div>
                            </div>
                        </div>
                        <form action="<?= base_url('presensi_kelas/hapus_presensi') ?>" method="POST" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_presensi" value="<?= $p['id_presensi'] ?>">
                            <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded"
                                onclick="return swalConfirm(this.closest('form'))" title="Hapus">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>
                </div><!-- end tab-content -->
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php if ($sekarang < $buka_presensi && !$bisa_kelola && $sudah_join): ?>
<script>
var target = <?= $buka_presensi * 1000 ?>;
function update_countdown() {
    var sisa = Math.max(0, Math.floor((target - Date.now()) / 1000));
    var j = Math.floor(sisa / 3600);
    var m = Math.floor((sisa % 3600) / 60);
    var s = sisa % 60;
    document.getElementById('countdown').textContent =
        String(j).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    if (sisa <= 0) location.reload();
}
update_countdown();
setInterval(update_countdown, 1000);
</script>
<?php endif; ?>

<!-- Modal Upload Materi -->
<div class="modal fade" id="modalUploadMateri" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Materi Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('materi_kelas/simpan_materi') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required placeholder="Contoh: Slide Presentasi Sesi 1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" placeholder="Keterangan singkat (opsional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Link Berbagi</label>
                        <input type="url" class="form-control" name="link_berbagi" placeholder="https://drive.google.com/...">
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-semibold">Upload File</label>
                        <input type="file" class="form-control" name="file_materi" accept=".pdf,.ppt,.pptx,.doc,.docx,.xls,.xlsx,.zip,.png,.jpg">
                        <small class="text-muted">PDF, PPT, DOC, XLS, ZIP, Gambar</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-upload"></i> Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Kehadiran -->
<div class="modal fade" id="modalTambahPresensi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Kehadiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('presensi_kelas/simpan_presensi_batch') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                <input type="hidden" name="id_program" value="<?= esc($program['id_program']) ?>">
                <div class="modal-body p-0">
                    <?php
                    $sudah_presensi_nama = array_column($presensi, 'nama_peserta');
                    ?>
                    <?php if (empty($sudah_akses)): ?>
                        <div class="text-center text-muted py-4">
                            <i class="mdi mdi-account-off-outline" style="font-size:40px; color:#cbd5e1;"></i>
                            <p class="mt-2 small">Belum ada peserta yang mengakses kelas.</p>
                        </div>
                    <?php else: ?>
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom bg-light">
                            <span class="text-muted small">
                                <?= count($sudah_akses) ?> sudah akses &bull;
                                <span class="text-success fw-semibold"><?= count($sudah_presensi_nama) ?> sudah hadir</span> &bull;
                                <span class="text-danger fw-semibold"><?= count($belum_presensi) ?> belum dikonfirmasi</span>
                            </span>
                            <?php if (!empty($belum_presensi)): ?>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="ceklisSemua()">
                                <i class="mdi mdi-check-all"></i> Ceklis Semua
                            </button>
                            <?php endif; ?>
                        </div>
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%" class="text-center">
                                        <?php if (!empty($belum_presensi)): ?>
                                        <input type="checkbox" id="chkAll" onchange="toggleAll(this)">
                                        <?php endif; ?>
                                    </th>
                                    <th>Nama Peserta</th>
                                    <th width="20%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sudah_akses as $sa):
                                    $sudah = in_array($sa['nama_peserta'], $sudah_presensi_nama);
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if (!$sudah): ?>
                                        <input class="form-check-input peserta-check" type="checkbox"
                                            name="peserta[]" value="<?= esc($sa['nama_peserta']) ?>"
                                            id="chk_<?= md5($sa['nama_peserta']) ?>">
                                        <?php else: ?>
                                        <i class="mdi mdi-check-circle text-success" style="font-size:18px;"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <label class="<?= !$sudah ? 'form-check-label' : '' ?> w-100 mb-0"
                                            <?= !$sudah ? 'for="chk_' . md5($sa['nama_peserta']) . '"' : '' ?>>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-kecil"><?= strtoupper(substr($sa['nama_peserta'], 0, 1)) ?></div>
                                                <span class="<?= $sudah ? 'text-muted' : '' ?>"><?= esc($sa['nama_peserta']) ?></span>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($sudah): ?>
                                            <span class="badge bg-success">Sudah Hadir</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Belum Dikonfirmasi</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
                <?php if (!empty($belum_presensi)): ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-check"></i> Konfirmasi</button>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<script>
function ceklisSemua() {
    document.querySelectorAll('.peserta-check').forEach(c => c.checked = true);
    var chkAll = document.getElementById('chkAll');
    if (chkAll) chkAll.checked = true;
}
function toggleAll(el) {
    document.querySelectorAll('.peserta-check').forEach(c => c.checked = el.checked);
}

// Aktifkan tab berdasarkan parameter URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    if (activeTab) {
        document.querySelectorAll('#kelasTab .nav-link').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        
        const targetTab = document.querySelector(`#kelasTab a[href="#${activeTab}"]`);
        const targetPane = document.querySelector(`#${activeTab}`);
        if (targetTab && targetPane) {
            targetTab.classList.add('active');
            targetPane.classList.add('show', 'active');
        }
    }
});
</script>

<!-- Modal Tambah Tugas -->
<div class="modal fade" id="modalTambahTugas" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tugas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('tugas_kelas/simpan_tugas') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                <input type="hidden" name="from_detail" value="1">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Tugas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required placeholder="Contoh: Tugas Membuat Proposal Bisnis">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Instruksi Tugas <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="instruksi" rows="4" placeholder="Jelaskan detail tugas yang harus dikerjakan..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Link Google Drive / File Online</label>
                        <input type="url" class="form-control" name="link_file" placeholder="https://drive.google.com/file/d/...">
                        <small class="text-muted">Link file tugas dari Google Drive, Dropbox, atau platform lainnya</small>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-semibold">Upload File Pendukung (Opsional)</label>
                        <input type="file" class="form-control" name="file_tugas" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.png,.jpg">
                        <small class="text-muted">PDF, DOC, PPT, XLS, ZIP, Gambar</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Preview Materi -->
<div class="modal fade" id="modalPreviewMateri" tabindex="-1" style="--bs-modal-width:90vw;">
    <div class="modal-dialog modal-dialog-centered" style="max-width:90vw; height:90vh;">
        <div class="modal-content" style="height:90vh;">
            <div class="modal-header py-2">
                <h6 class="modal-title" id="judulPreview"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="height:100%; overflow:hidden;">
                <iframe id="iframePreview" src="" style="width:100%; height:100%; border:none;"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Media Kelas -->
<div class="modal fade" id="modalTambahMedia" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Media Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('kelas/ubah_kelas') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kelas" value="<?= esc($kelas['id_kelas']) ?>">
                <input type="hidden" name="from_detail" value="1">
                <input type="hidden" name="active_tab" value="tab-akses">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Link YouTube</label>
                        <input type="url" class="form-control" name="link_youtube" 
                            value="<?= esc($kelas['link_youtube'] ?? '') ?>" 
                            placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-muted">Link video YouTube untuk rekaman kelas</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Link Meeting</label>
                        <input type="url" class="form-control" name="link_zoom" 
                            value="<?= esc($kelas['link_zoom'] ?? '') ?>" 
                            placeholder="https://zoom.us/j/...">
                        <small class="text-muted">Link Zoom, Google Meet, atau platform meeting lainnya</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function buka_preview(url, judul, tipe) {
    document.getElementById('judulPreview').textContent = judul;
    var tipe_office = ['doc','docx','ppt','pptx','xls','xlsx'];
    var src = tipe_office.indexOf(tipe) !== -1
        ? 'https://docs.google.com/viewer?url=' + encodeURIComponent(url) + '&embedded=true'
        : url;
    document.getElementById('iframePreview').src = src;
    new bootstrap.Modal(document.getElementById('modalPreviewMateri')).show();
}
document.getElementById('modalPreviewMateri').addEventListener('hidden.bs.modal', function() {
    document.getElementById('iframePreview').src = '';
});
</script>
