<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Startup - SIMIK</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F1F5F9; color: #334155; }
        .form-card { 
            background: white; 
            border-radius: 4px; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            position: relative;
        }
        .label-text { 
            font-size: 14px; 
            font-weight: 600; 
            color: #475569; 
            margin-top: 12px;
            display: block; 
        }
        .input-field { 
            width: 100%; 
            padding: 10px 14px; 
            border: 1px solid #cbd5e1; 
            border-radius: 6px; 
            font-size: 14px; 
            color: #1e293b; 
            outline: none; 
            transition: all 0.2s; 
            background-color: #ffffff; 
        }
        .input-field:focus { 
            border-color: #94a3b8; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); 
        }
        .input-field::placeholder { color: #94a3b8; font-weight: 400; }
        .checkbox-label { font-size: 13px; color: #475569; display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 500; }
        .btn-primary { background-color: #0061FF; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.2s; }
        .btn-primary:hover { background-color: #0056e0; transform: translateY(-1px); }
        
        .form-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 24px;
            align-items: start;
            padding-bottom: 24px;
            border-bottom: 1px solid #f1f5f9;
        }
        .form-row:last-child { border-bottom: none; }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            .label-text { margin-top: 0; }
        }
    </style>
</head>
<body class="antialiased">
    
    <!-- TOPBAR SAJA -->
    <?= view('Partials/topbar') ?>

    <main class="max-w-[995px] mx-auto px-6 pb-32 mt-12">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight uppercase">Edit Data Startup</h1>
            <p class="text-slate-500 text-sm mt-2 uppercase tracking-widest leading-none">Perbaharui informasi profil startup yang sudah terdaftar.</p>
        </div>

        <div class="form-card p-10 md:p-16">
            <form action="<?= base_url('update-startup') ?>" method="post" enctype="multipart/form-data" class="space-y-8">
                
                <!-- Hidden Field ID -->
                <input type="hidden" name="id_startup" value="<?= $startup['id_startup'] ?>">

                <!-- Nama Perusahaan -->
                <div class="form-row">
                    <div>
                        <label class="label-text uppercase">Nama Perusahaan <span class="text-red-500 font-bold">*</span></label>
                        <p class="text-[12px] text-slate-400 mt-1 uppercase">Nama resmi entitas bisnis</p>
                    </div>
                    <input type="text" name="nama_perusahaan" value="<?= esc($startup['nama_perusahaan']) ?>" required class="input-field" placeholder="Masukkan nama perusahaan">
                </div>

                <!-- Deskripsi -->
                <div class="form-row">
                    <div>
                        <label class="label-text uppercase">Deskripsi Bidang Usaha <span class="text-red-500 font-bold">*</span></label>
                        <p class="text-[12px] text-slate-400 mt-1 uppercase">Jelaskan secara singkat apa yang dilakukan</p>
                    </div>
                    <textarea name="deskripsi_bidang_usaha" rows="4" required class="input-field" placeholder="Tuliskan deskripsi startup Anda..."><?= esc($startup['deskripsi_bidang_usaha']) ?></textarea>
                </div>

                <!-- Kluster -->
                <div class="form-row">
                    <div>
                        <label class="label-text uppercase">Pilih Kluster <span class="text-red-500 font-bold">*</span></label>
                        <p class="text-[12px] text-slate-400 mt-1 uppercase">Pilih satu atau lebih kategori</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach($klasters as $klaster): ?>
                        <label class="checkbox-label uppercase">
                            <input type="checkbox" name="kluster[]" value="<?= $klaster['id_klaster'] ?>" 
                                <?= in_array($klaster['id_klaster'], $startup['selected_klasters']) ? 'checked' : '' ?>
                                class="w-4 h-4 rounded border-slate-300 text-[#0061FF]">
                            <?= esc($klaster['nama_klaster']) ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tahun Berdiri -->
                <div class="form-row">
                    <label class="label-text uppercase">Tahun Berdiri</label>
                    <input type="number" name="tahun_berdiri" value="<?= $startup['tahun_berdiri'] ?>" class="input-field" placeholder="2024">
                </div>

                <!-- Target Pemasaran -->
                <div class="form-row">
                    <label class="label-text uppercase">Target Pemasaran</label>
                    <input type="text" name="target_pemasaran" value="<?= esc($startup['target_pemasaran']) ?>" class="input-field" placeholder="Contoh: B2B, B2C, Government">
                </div>

                <!-- Fokus Pelanggan -->
                <div class="form-row">
                    <label class="label-text uppercase">Fokus Pelanggan</label>
                    <input type="text" name="fokus_pelanggan" value="<?= esc($startup['fokus_pelanggan']) ?>" class="input-field" placeholder="Contoh: Mahasiswa, Petani, UMKM">
                </div>

                <!-- Dosen Pembina -->
                <div class="form-row">
                    <label class="label-text uppercase">Dosen Pembina</label>
                    <div class="space-y-2">
                        <select name="id_dosen_pembina" class="input-field">
                            <option value="">Pilih Dosen Pembina</option>
                            <?php foreach($dosens as $dosen): ?>
                            <option value="<?= $dosen['id_dosen_pembina'] ?>" <?= ($startup['id_dosen_pembina'] == $dosen['id_dosen_pembina']) ? 'selected' : '' ?>>
                                <?= esc($dosen['nama_lengkap']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Program -->
                <div class="form-row">
                    <label class="label-text uppercase">Program Yang Diikuti</label>
                    <select name="id_program" class="input-field">
                        <option value="">Pilih Program</option>
                        <?php foreach($programs as $program): ?>
                        <option value="<?= $program['id_program'] ?>" <?= ($startup['id_program'] == $program['id_program']) ? 'selected' : '' ?>>
                            <?= esc($program['nama_program']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="form-row">
                    <label class="label-text uppercase">Alamat</label>
                    <textarea name="alamat" rows="3" class="input-field" placeholder="Tuliskan alamat lengkap kantor..."><?= esc($startup['alamat']) ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-4">
                    <!-- WhatsApp -->
                    <div class="space-y-4">
                        <label class="label-text uppercase">Nomor WhatsApp</label>
                        <input type="text" name="nomor_whatsapp" value="<?= esc($startup['nomor_whatsapp']) ?>" class="input-field" placeholder="08XXXXXXXXXX">
                    </div>
                    <!-- Email Perusahaan -->
                    <div class="space-y-4">
                        <label class="label-text uppercase">Email Perusahaan</label>
                        <input type="email" name="email_perusahaan" value="<?= esc($startup['email_perusahaan']) ?>" class="input-field" placeholder="email@perusahaan.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-4">
                    <!-- Website -->
                    <div class="space-y-4">
                        <label class="label-text uppercase">Website Perusahaan</label>
                        <input type="text" name="website_perusahaan" value="<?= esc($startup['website_perusahaan']) ?>" class="input-field" placeholder="https://...">
                    </div>
                    <!-- LinkedIn -->
                    <div class="space-y-4">
                        <label class="label-text uppercase">LinkedIn Perusahaan</label>
                        <input type="text" name="linkedin_perusahaan" value="<?= esc($startup['linkedin_perusahaan']) ?>" class="input-field" placeholder="Link">
                    </div>
                    <!-- Instagram -->
                    <div class="space-y-4">
                        <label class="label-text uppercase">Instagram Perusahaan</label>
                        <input type="text" name="instagram_perusahaan" value="<?= esc($startup['instagram_perusahaan']) ?>" class="input-field" placeholder="@username">
                    </div>
                </div>

                <!-- Logo -->
                <div class="form-row">
                    <div>
                        <label class="label-text uppercase">Logo Perusahaan</label>
                        <p class="text-[11px] text-slate-400 uppercase mt-1">Kosongkan jika tidak ingin mengubah</p>
                    </div>
                    <div class="space-y-4">
                        <?php if ($startup['logo_perusahaan']): ?>
                            <div class="flex items-center gap-4 p-3 border border-slate-100 rounded-xl bg-slate-50/50 w-fit">
                                <img src="<?= base_url('uploads/logos/' . $startup['logo_perusahaan']) ?>" alt="Current Logo" class="w-12 h-12 object-contain">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Logo Terpasang</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="logo_perusahaan" class="input-field !py-1.5 !px-2 text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-600 hover:file:bg-slate-200 cursor-pointer transition-all">
                    </div>
                </div>

                <!-- Tahun Daftar -->
                <div class="form-row">
                    <div class="md:w-[200px]">
                        <label class="label-text uppercase">Tahun Daftar <span class="text-red-500 font-bold">*</span></label>
                    </div>
                    <div class="flex-1">
                        <select name="tahun_daftar" required class="input-field">
                            <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                                <option value="<?= $y ?>" <?= ($startup['tahun_daftar'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <!-- Status Startup -->
                <div class="form-row">
                    <div class="md:w-[200px]">
                        <label class="label-text uppercase">Status Startup <span class="text-red-500 font-bold">*</span></label>
                    </div>
                    <div class="flex-1">
                        <select name="status_startup" required class="input-field">
                            <option value="Aktif" <?= ($startup['status_startup'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                            <option value="Non-Aktif" <?= ($startup['status_startup'] == 'Non-Aktif') ? 'selected' : '' ?>>Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end gap-4 pt-12">
                    <a href="<?= base_url('data-startup') ?>" class="px-6 py-2.5 text-slate-400 font-black text-[10px] tracking-widest hover:bg-slate-50 uppercase rounded-xl transition-all">
                        Batal Perubahan
                    </a>
                    <button type="submit" class="btn-primary flex items-center gap-3 shadow-xl shadow-blue-500/20 uppercase tracking-[0.15em] text-[10px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                        Simpan Perubahan Data
                    </button>
                </div>

            </form>

            <div class="mt-20 pt-10 border-t border-slate-100 uppercase">
                <?= view('Partials/footer') ?>
            </div>
        </div>

        <div class="h-20"></div>

    </main>

</body>
</html>
