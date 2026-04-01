<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Startup - SIMIK</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <script src="<?= base_url('js/sweetalert2.min.js') ?>"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        .sidebar-card { background: white; border: 1.5px solid #f1f5f9; border-radius: 0; padding: 40px; }
        .main-card { background: white; border: 1.5px solid #f1f5f9; border-radius: 0; overflow: hidden; }
        .info-header { background: #f8fafc; border-bottom: 1.5px solid #f1f5f9; padding: 20px 40px; }
        .label-text { font-size: 9px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.2em; margin-bottom: 8px; display: block; }
        .value-text { font-size: 11.5px; font-weight: 400; color: #1e293b; line-height: 1.5; text-transform: none; }
        .badge { padding: 4px 10px; border-radius: 8px; font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased uppercase">
    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR UTAMA -->
        <?= view('Partials/sidebar') ?>

        <main class="flex-1 flex flex-col min-w-0 bg-white relative">
            
            <!-- TOPBAR -->
            <?= view('Partials/topbar') ?>

            <!-- CONTENT AREA -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden px-10 py-12 bg-slate-50/30">
                
                <div class="max-w-full mx-auto">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-[480px_1fr] gap-8 items-start">
                        
                        <!-- KOLOM KIRI: PROFIL SIDEBAR -->
                        <div class="sidebar-card shadow-sm space-y-10 relative">
                            <!-- Tombol Kembali (Arrow Pojok Kiri Atas) -->
                            <button onclick="window.history.back()" class="absolute top-6 left-6 w-10 h-10 bg-slate-50 text-slate-400 hover:bg-[#0061FF] hover:text-white rounded-full flex items-center justify-center transition-all border border-slate-100 group shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </button>

                            <!-- Logo di Tengah -->
                            <div class="flex justify-center">
                                <?php if ($startup['logo_perusahaan']): ?>
                                    <img src="<?= base_url('uploads/logos/' . $startup['logo_perusahaan']) ?>" alt="Logo" class="w-40 h-40 object-contain">
                                <?php else: ?>
                                    <div class="w-40 h-40 bg-slate-50 rounded-[40px] flex items-center justify-center border border-slate-100 shadow-inner">
                                        <span class="text-5xl font-black text-slate-200"><?= strtoupper(substr($startup['nama_perusahaan'], 0, 1)) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Nama Startup -->
                            <div class="text-center">
                                <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase leading-tight"><?= $startup['nama_perusahaan'] ?></h2>
                                <p class="text-[10px] font-bold text-slate-400 mt-2 tracking-widest uppercase">Profil Entitas Bisnis</p>
                            </div>

                            <!-- Detail Info Berjejer -->
                            <div class="space-y-6 pt-8 border-t border-slate-100">
                                <div>
                                    <span class="label-text">Kluster Utama</span>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach($startup['klasters'] as $kl): ?>
                                            <span class="badge bg-blue-50 text-[#0061FF] border border-blue-100/50 normal-case font-normal"><?= $kl ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <span class="label-text">Tahun Berdiri</span>
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                            <span class="font-normal text-xs text-slate-600"><?= $startup['tahun_berdiri'] ?: '-' ?></span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="label-text">Tahun Daftar</span>
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                            <span class="font-normal text-xs text-slate-600"><?= $startup['tahun_daftar'] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="label-text">Status Startup</span>
                                    <span class="badge bg-green-50 text-green-600 border border-green-100/50 normal-case font-normal"><?= $startup['status_startup'] ?></span>
                                </div>
                                <div>
                                    <span class="label-text">Status Ajuan</span>
                                    <div class="flex items-center gap-3">
                                        <div class="w-2.5 h-2.5 bg-blue-500 rounded-full animate-pulse"></div>
                                        <span class="text-[11px] font-normal text-blue-600 tracking-widest normal-case"><?= $startup['status_ajuan'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KOLOM KANAN: INFORMASI DETAIL -->
                        <div class="space-y-8">
                            
                            <!-- LANDSCAPE HEADER (ARAHAN TOPBAR) -->
                            <div class="main-card shadow-sm">
                                <div class="info-header flex items-center justify-between bg-white px-10">
                                    <div class="flex items-center gap-4">
                                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-[0.4em]">STARTUP</h3>
                                    </div>
                                </div>

                                <!-- INFORMASI STARTUP -->
                                <div class="p-10">
                                    <div class="mb-10">
                                        <h4 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.3em]">Informasi Startup</h4>
                                    </div>
                                    <div class="grid grid-cols-2 gap-12">
                                        <div class="space-y-8">
                                            <div>
                                                <span class="label-text">Target Pemasaran</span>
                                                <p class="value-text"><?= $startup['target_pemasaran'] ?: '-' ?></p>
                                            </div>
                                            <div>
                                                <span class="label-text">Fokus Pelanggan</span>
                                                <p class="value-text"><?= $startup['fokus_pelanggan'] ?: '-' ?></p>
                                            </div>
                                            <div>
                                                <span class="label-text">Dosen Pembina</span>
                                                <p class="value-text text-blue-600"><?= $startup['nama_dosen'] ?: '-' ?></p>
                                            </div>
                                        </div>
                                        <div class="space-y-8">
                                            <div>
                                                <span class="label-text">Alamat Lengkap Kantor</span>
                                                <p class="value-text text-slate-500"><?= $startup['alamat'] ?: '-' ?></p>
                                            </div>
                                            <div>
                                                <span class="label-text">Program Yang Diikuti</span>
                                                <span class="badge bg-slate-100 text-slate-700 mt-2 block w-fit normal-case font-normal"><?= $startup['nama_program'] ?: '-' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- INFORMASI TIM -->
                                <div class="p-10 pt-0">
                                    <div class="mb-10 flex items-center justify-between">
                                        <h4 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.3em]">Informasi Tim</h4>
                                        <button onclick="openTambahAnggotaModal()" class="px-4 py-2 bg-[#0061FF] text-white text-[8px] font-black uppercase tracking-widest transition-all shadow-md active:scale-95 text-center">+ Tambah Anggota</button>
                                    </div>
                                    <div class="overflow-x-auto border border-slate-100">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-slate-50/50">
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">No</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Nama Lengkap</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Jabatan</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Jenis Kelamin</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">WhatsApp</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Email</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">LinkedIn</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Instagram</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Perguruan Tinggi</th>
                                                    <th class="px-6 py-4 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($tim)): ?>
                                                    <?php foreach($tim as $i => $t): ?>
                                                    <tr class="hover:bg-slate-50 transition-all group">
                                                        <td class="px-6 py-4 text-[10px] font-bold text-slate-400"><?= $i + 1 ?></td>
                                                        <td class="px-6 py-4 text-[10px] font-normal text-slate-700 normal-case"><?= $t['nama_lengkap'] ?></td>
                                                        <td class="px-6 py-4">
                                                            <span class="badge bg-slate-50 text-slate-400 border border-slate-100 normal-case font-normal"><?= $t['jabatan'] ?></span>
                                                        </td>
                                                        <td class="px-6 py-4 text-[10px] font-normal text-slate-600 normal-case"><?= $t['jenis_kelamin'] === 'L' ? 'Laki-laki' : ($t['jenis_kelamin'] === 'P' ? 'Perempuan' : '-') ?></td>
                                                        <td class="px-6 py-4 text-[10px] font-normal text-green-600"><?= $t['no_whatsapp'] ?: '-' ?></td>
                                                        <td class="px-6 py-4 text-[10px] font-normal text-blue-500 lowercase"><?= $t['email'] ?: '-' ?></td>
                                                        <td class="px-6 py-4 text-[10px] font-normal text-slate-500 normal-case"><?= $t['linkedin'] ?: '-' ?></td>
                                                        <td class="px-6 py-4 text-[10px] font-normal text-slate-500 normal-case"><?= $t['instagram'] ?: '-' ?></td>
                                                        <td class="px-6 py-4 text-[10px] font-normal text-slate-600 normal-case"><?= $t['nama_perguruan_tinggi'] ?: '-' ?></td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center justify-center gap-2">
                                                                <button onclick="openEditTimModal(<?= $t['id_tim'] ?>, '<?= esc($t['nama_lengkap']) ?>', '<?= esc($t['jabatan']) ?>', '<?= $t['jenis_kelamin'] ?>', '<?= $t['no_whatsapp'] ?>', '<?= $t['email'] ?>', '<?= esc($t['linkedin']) ?>', '<?= esc($t['instagram']) ?>', '<?= esc($t['nama_perguruan_tinggi']) ?>')" class="p-2 text-slate-300 hover:text-blue-600 transition-colors">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                    </svg>
                                                                </button>
                                                                <button class="p-2 text-slate-300 hover:text-red-500 transition-colors" onclick="confirmDeleteMember('<?= $t['id_tim'] ?>', '<?= $t['nama_lengkap'] ?>')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="10" class="px-6 py-10 text-center text-[9px] font-black text-slate-300 uppercase tracking-widest">Database tim startup sedang kosong</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?= view('Partials/footer') ?>
        </main>
    </div>

    <!-- MODAL EDIT STARTUP -->
    <div id="modal-edit-startup" class="hidden fixed inset-0 z-[999] flex items-center justify-center">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="document.getElementById('modal-edit-startup').classList.add('hidden')"></div>
        <div class="relative bg-white w-full mx-4 shadow-2xl z-10 max-h-[90vh] overflow-y-auto rounded-[10px]" style="max-width: 680px;">
            <!-- Header -->
            <div class="flex items-center justify-between px-8 py-6 border-b border-slate-100">
                <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.3em]">Edit Data Startup</h3>
                <button onclick="document.getElementById('modal-edit-startup').classList.add('hidden')" class="text-slate-300 hover:text-slate-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="<?= base_url('update-startup') ?>" method="post" enctype="multipart/form-data" class="px-8 py-6 space-y-4">
                <input type="hidden" name="id_startup" value="<?= $startup['id_startup'] ?>">
                <div class="space-y-4">
                    <div>
                        <label class="label-text">Nama Perusahaan <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_perusahaan" required value="<?= esc($startup['nama_perusahaan']) ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all normal-case font-normal">
                    </div>
                    <div>
                        <label class="label-text">Deskripsi Bidang Usaha <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi_bidang_usaha" rows="2" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all normal-case font-normal"><?= esc($startup['deskripsi_bidang_usaha']) ?></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label-text">Tahun Berdiri</label>
                            <input type="number" name="tahun_berdiri" value="<?= $startup['tahun_berdiri'] ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="label-text">Tahun Daftar <span class="text-red-500">*</span></label>
                            <select name="tahun_daftar" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                                <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                                    <option value="<?= $y ?>" <?= ($startup['tahun_daftar'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="label-text">Target Pemasaran</label>
                        <input type="text" name="target_pemasaran" value="<?= esc($startup['target_pemasaran']) ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all normal-case font-normal">
                    </div>
                    <div>
                        <label class="label-text">Fokus Pelanggan</label>
                        <input type="text" name="fokus_pelanggan" value="<?= esc($startup['fokus_pelanggan']) ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all normal-case font-normal">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label-text">No WhatsApp</label>
                            <input type="text" name="nomor_whatsapp" value="<?= esc($startup['nomor_whatsapp']) ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="label-text">Email</label>
                            <input type="email" name="email_perusahaan" value="<?= esc($startup['email_perusahaan']) ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all lowercase">
                        </div>
                    </div>
                    <div>
                        <label class="label-text">Website</label>
                        <input type="text" name="website_perusahaan" value="<?= esc($startup['website_perusahaan']) ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all normal-case font-normal">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label-text">LinkedIn</label>
                            <input type="text" name="linkedin_perusahaan" value="<?= esc($startup['linkedin_perusahaan']) ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="label-text">Instagram</label>
                            <input type="text" name="instagram_perusahaan" value="<?= esc($startup['instagram_perusahaan']) ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="label-text">Dosen Pembina</label>
                        <select name="id_dosen_pembina" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all normal-case font-normal">
                            <option value="">Pilih Dosen Pembina</option>
                            <?php foreach($dosens as $dosen): ?>
                            <option value="<?= $dosen['id_dosen_pembina'] ?>" <?= ($startup['id_dosen_pembina'] == $dosen['id_dosen_pembina']) ? 'selected' : '' ?>><?= esc($dosen['nama_lengkap']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="label-text">Program</label>
                        <select name="id_program" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all normal-case font-normal">
                            <option value="">Pilih Program</option>
                            <?php foreach($programs as $program): ?>
                            <option value="<?= $program['id_program'] ?>" <?= ($startup['id_program'] == $program['id_program']) ? 'selected' : '' ?>><?= esc($program['nama_program']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="label-text">Alamat</label>
                        <textarea name="alamat" rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all normal-case font-normal"><?= esc($startup['alamat']) ?></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label-text">Status Startup <span class="text-red-500">*</span></label>
                            <select name="status_startup" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                                <option value="Aktif" <?= ($startup['status_startup'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= ($startup['status_startup'] == 'Tidak Aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                                <option value="Lulus" <?= ($startup['status_startup'] == 'Lulus') ? 'selected' : '' ?>>Lulus</option>
                            </select>
                        </div>
                        <div>
                            <label class="label-text">Logo</label>
                            <input type="file" name="logo_perusahaan" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-100 text-xs outline-none file:mr-2 file:py-1 file:px-2 file:border-0 file:text-[9px] file:font-bold file:bg-slate-200 file:text-slate-600 cursor-pointer">
                        </div>
                    </div>
                    <div>
                        <label class="label-text">Kluster</label>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <?php foreach($klasters as $klaster): ?>
                            <label class="flex items-center gap-2 text-[10px] font-normal text-slate-600 normal-case cursor-pointer">
                                <input type="checkbox" name="kluster[]" value="<?= $klaster['id_klaster'] ?>" <?= in_array($klaster['id_klaster'], $startup['selected_klasters']) ? 'checked' : '' ?> class="w-3.5 h-3.5">
                                <?= esc($klaster['nama_klaster']) ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full py-4 bg-[#0061FF] text-white text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all">Simpan Perubahan</button>
                    <button type="button" onclick="document.getElementById('modal-edit-startup').classList.add('hidden')" class="w-full py-3 text-slate-400 text-[8px] font-black uppercase tracking-widest hover:text-slate-600 transition-all">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL TAMBAH ANGGOTA -->
    <div id="modal-tambah-anggota" class="hidden fixed inset-0 z-[999] flex items-center justify-center p-6 text-center">
        <!-- Backdrop Backdrop (No Blur) -->
        <div class="absolute inset-0 bg-slate-900/40 transition-all uppercase" onclick="document.getElementById('modal-tambah-anggota').classList.add('hidden')"></div>
        
        <!-- Modal Content Container (Strict Portrait - No Scroll) -->
        <div class="relative bg-white w-full max-w-[420px] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.15)] z-10 overflow-hidden rounded-[10px] border border-slate-100 flex flex-col max-h-[95vh] text-left">
            
            <!-- Modal Header -->
            <div class="px-7 py-6 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-20">
                <div>
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.3em]">Tambah Anggota</h3>
                    <p class="text-[7px] font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Profil baru</p>
                </div>
                <button onclick="document.getElementById('modal-tambah-anggota').classList.add('hidden')" class="w-8 h-8 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Form Content (Compact Portrait Grid) -->
            <div class="px-7 py-7 overflow-y-auto">
                <form action="<?= base_url('save-tim') ?>" method="post" id="form-tambah-anggota" class="space-y-5">
                    <input type="hidden" name="id_startup" value="<?= $startup['id_startup'] ?>">
                    
                    <div class="grid grid-cols-2 gap-x-5 gap-y-5">
                        <!-- Nama Lengkap (Full Row for better read) -->
                        <div class="col-span-2 space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" required 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all placeholder:text-slate-300"
                                placeholder="...">
                        </div>
                        <!-- Jabatan -->
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">Jabatan <span class="text-red-500">*</span></label>
                            <input type="text" name="jabatan" required 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all"
                                placeholder="...">
                        </div>
                        <!-- Jenis Kelamin -->
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">Gender</label>
                            <select name="jenis_kelamin" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                                <option value="">PILIH</option>
                                <option value="L">LAKI-LAKI</option>
                                <option value="P">PEREMPUAN</option>
                            </select>
                        </div>
                        <!-- No WhatsApp -->
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">WhatsApp</label>
                            <input type="text" name="no_whatsapp" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all"
                                placeholder="08XX..">
                        </div>
                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">Email</label>
                            <input type="email" name="email" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-[10px] text-slate-400 outline-none focus:bg-white focus:border-blue-500 transition-all lowercase"
                                placeholder="e@mail.com">
                        </div>
                        <!-- LinkedIn -->
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">LinkedIn</label>
                            <input type="text" name="linkedin" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-[10px] text-slate-400 outline-none focus:bg-white focus:border-blue-500 transition-all"
                                placeholder="...">
                        </div>
                        <!-- Instagram -->
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">Instagram</label>
                            <input type="text" name="instagram" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-[10px] text-slate-400 outline-none focus:bg-white focus:border-blue-500 transition-all"
                                placeholder="@..">
                        </div>
                        <!-- Perguruan Tinggi (Full Row) -->
                        <div class="col-span-2 space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">Perguruan Tinggi</label>
                            <input type="text" name="nama_perguruan_tinggi" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all placeholder:text-slate-300"
                                placeholder="...">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="px-7 py-6 border-t border-slate-50 bg-slate-50/10 flex flex-col gap-2 sticky bottom-0 z-20">
                <button type="submit" form="form-tambah-anggota" 
                    class="w-full py-4 bg-[#0061FF] text-white text-[10px] font-black uppercase tracking-widest shadow-xl shadow-blue-500/20 hover:bg-blue-600 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Simpan Anggota
                </button>
                <button type="button" onclick="document.getElementById('modal-tambah-anggota').classList.add('hidden')" 
                    class="w-full py-3 text-slate-400 text-[8px] font-black uppercase tracking-widest hover:text-slate-600 transition-all">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <script>
        function openTambahAnggotaModal() {
            const modal = document.getElementById('modal-tambah-anggota');
            modal.classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('nama_lengkap').focus();
            }, 100);
        }

        // Notifikasi Flashdata
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL!',
                text: '<?= session()->getFlashdata('success') ?>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-[20px] p-10',
                    title: 'text-sm font-black text-slate-900 tracking-[0.2em]',
                    htmlContainer: 'text-[11px] font-bold text-slate-400 uppercase tracking-widest'
                }
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'GAGAL!',
                text: '<?= session()->getFlashdata('error') ?>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-[20px] p-10',
                    title: 'text-sm font-black text-slate-900 tracking-[0.2em]',
                    htmlContainer: 'text-[11px] font-bold text-slate-400 uppercase tracking-widest'
                }
            });
        <?php endif; ?>

        function confirmDeleteMember(id, name) {
            Swal.fire({
                title: 'HAPUS ANGGOTA?',
                text: "Anda akan menghapus " + name + " dari tim startup ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0061FF',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'YA, HAPUS!',
                cancelButtonText: 'BATAL',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[20px] p-10',
                    title: 'text-sm font-black text-slate-900 tracking-[0.2em]',
                    htmlContainer: 'text-[11px] font-bold text-slate-400 uppercase tracking-widest',
                    confirmButton: 'px-8 py-3.5 text-[10px] font-black tracking-widest rounded-none shadow-xl shadow-blue-500/20',
                    cancelButton: 'px-8 py-3.5 text-[10px] font-black tracking-widest text-slate-400 rounded-none'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('delete-tim') ?>/" + id;
                }
            })
        }
    </script>

    <!-- MODAL EDIT ANGGOTA TIM -->
    <div id="modal-edit-tim" class="hidden fixed inset-0 z-[999] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40" onclick="document.getElementById('modal-edit-tim').classList.add('hidden')"></div>
        <div class="relative bg-white w-full max-w-[420px] shadow-2xl z-10 rounded-[10px] border border-slate-100 flex flex-col max-h-[95vh]">
            <div class="px-7 py-6 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-20">
                <div>
                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.3em]">Edit Anggota Tim</h3>
                    <p class="text-[7px] font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Perbarui data anggota</p>
                </div>
                <button onclick="document.getElementById('modal-edit-tim').classList.add('hidden')" class="w-8 h-8 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-7 py-7 overflow-y-auto">
                <form action="<?= base_url('update-tim') ?>" method="post" id="form-edit-tim" class="space-y-5">
                    <input type="hidden" name="id_tim" id="edit_id_tim">
                    <div class="grid grid-cols-2 gap-x-5 gap-y-5">
                        <div class="col-span-2 space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" id="edit_nama_lengkap" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Jabatan <span class="text-red-500">*</span></label>
                            <input type="text" name="jabatan" id="edit_jabatan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Gender</label>
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest">WhatsApp</label>
                            <input type="text" name="no_whatsapp" id="edit_no_whatsapp" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Email</label>
                            <input type="email" name="email" id="edit_email" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-400 outline-none focus:bg-white focus:border-blue-500 transition-all lowercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest">LinkedIn</label>
                            <input type="text" name="linkedin" id="edit_linkedin" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-400 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Instagram</label>
                            <input type="text" name="instagram" id="edit_instagram" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-400 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                        <div class="col-span-2 space-y-2">
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Perguruan Tinggi</label>
                            <input type="text" name="nama_perguruan_tinggi" id="edit_perguruan_tinggi" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 text-xs text-slate-600 outline-none focus:bg-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                </form>
            </div>
            <div class="px-7 py-6 border-t border-slate-50 bg-slate-50/10 flex flex-col gap-2 sticky bottom-0 z-20">
                <button type="submit" form="form-edit-tim" class="w-full py-4 bg-[#0061FF] text-white text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all active:scale-95">Simpan Perubahan</button>
                <button type="button" onclick="document.getElementById('modal-edit-tim').classList.add('hidden')" class="w-full py-3 text-slate-400 text-[8px] font-black uppercase tracking-widest hover:text-slate-600 transition-all">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openEditTimModal(id, nama, jabatan, jk, wa, email, linkedin, instagram, pt) {
            document.getElementById('edit_id_tim').value           = id;
            document.getElementById('edit_nama_lengkap').value     = nama;
            document.getElementById('edit_jabatan').value          = jabatan;
            document.getElementById('edit_jenis_kelamin').value    = jk;
            document.getElementById('edit_no_whatsapp').value      = wa;
            document.getElementById('edit_email').value            = email;
            document.getElementById('edit_linkedin').value         = linkedin;
            document.getElementById('edit_instagram').value        = instagram;
            document.getElementById('edit_perguruan_tinggi').value = pt;
            document.getElementById('modal-edit-tim').classList.remove('hidden');
        }
    </script>

</body>
</html>
