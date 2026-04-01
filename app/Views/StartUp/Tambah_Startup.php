<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Startup - SIMIK</title>
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
    
    <!-- TOPBAR SAJA (TANPA SIDEBAR) -->
    <?= view('Partials/topbar') ?>

    <main class="max-w-[995px] mx-auto px-6 pb-32 mt-12">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Startup Baru</h1>
            <p class="text-slate-500 text-base mt-2">Silahkan lengkapi informasi startup Anda pada formulir di bawah ini.</p>
        </div>

        <div class="form-card p-10 md:p-16">
            <form action="<?= base_url('save-startup') ?>" method="post" enctype="multipart/form-data" class="space-y-8">
                
                <!-- Nama Perusahaan -->
                <div class="form-row">
                    <div>
                        <label class="label-text">Nama Perusahaan <span class="text-red-500 font-bold">*</span></label>
                        <p class="text-[12px] text-slate-400 mt-1">Nama resmi entitas bisnis</p>
                    </div>
                    <input type="text" name="nama_perusahaan" required class="input-field" placeholder="Masukkan nama perusahaan">
                </div>

                <!-- Deskripsi -->
                <div class="form-row">
                    <div>
                        <label class="label-text">Deskripsi Bidang Usaha <span class="text-red-500 font-bold">*</span></label>
                        <p class="text-[12px] text-slate-400 mt-1">Jelaskan secara singkat apa yang dilakukan startup Anda</p>
                    </div>
                    <textarea name="deskripsi_bidang_usaha" rows="4" required class="input-field" placeholder="Tuliskan deskripsi startup Anda..."></textarea>
                </div>

                <!-- Kluster -->
                <div class="form-row">
                    <div>
                        <label class="label-text">Pilih Kluster <span class="text-red-500 font-bold">*</span></label>
                        <p class="text-[12px] text-slate-400 mt-1">Pilih satu atau lebih kategori yang sesuai</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach($klasters as $klaster): ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="kluster[]" value="<?= $klaster['id_klaster'] ?>" class="w-4 h-4 rounded border-slate-300 text-[#0061FF]">
                            <?= esc($klaster['nama_klaster']) ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tahun Berdiri -->
                <div class="form-row">
                    <label class="label-text">Tahun Berdiri</label>
                    <input type="number" name="tahun_berdiri" class="input-field" placeholder="2024">
                </div>

                <!-- Target Pemasaran -->
                <div class="form-row">
                    <label class="label-text">Target Pemasaran</label>
                    <input type="text" name="target_pemasaran" class="input-field" placeholder="Contoh: B2B, B2C, Government">
                </div>

                <!-- Fokus Pelanggan -->
                <div class="form-row">
                    <label class="label-text">Fokus Pelanggan</label>
                    <input type="text" name="fokus_pelanggan" class="input-field" placeholder="Contoh: Mahasiswa, Petani, UMKM">
                </div>

                <!-- Dosen Pembina -->
                <div class="form-row">
                    <label class="label-text">Dosen Pembina</label>
                    <div class="space-y-2">
                        <select name="id_dosen_pembina" class="input-field">
                            <option value="">Pilih Dosen Pembina</option>
                            <?php foreach($dosens as $dosen): ?>
                            <option value="<?= $dosen['id_dosen_pembina'] ?>"><?= esc($dosen['nama_lengkap']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-[11px] text-slate-400 italic">Jika tidak ditemukan, silahkan <a href="#" class="text-blue-500 hover:underline font-semibold">daftarkan dosen pembina</a> dulu</p>
                    </div>
                </div>

                <!-- Program -->
                <div class="form-row">
                    <label class="label-text">Program Yang Diikuti</label>
                    <select name="id_program" class="input-field">
                        <option value="">Pilih Program</option>
                        <?php foreach($programs as $program): ?>
                        <option value="<?= $program['id_program'] ?>"><?= esc($program['nama_program']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="form-row">
                    <label class="label-text">Alamat</label>
                    <textarea name="alamat" rows="3" class="input-field" placeholder="Tuliskan alamat lengkap kantor..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-4">
                    <!-- WhatsApp -->
                    <div class="space-y-4">
                        <label class="label-text">Nomor WhatsApp</label>
                        <input type="text" name="nomor_whatsapp" class="input-field" placeholder="08XXXXXXXXXX">
                    </div>
                    <!-- Email Perusahaan -->
                    <div class="space-y-4">
                        <label class="label-text">Email Perusahaan</label>
                        <input type="email" name="email_perusahaan" class="input-field" placeholder="email@perusahaan.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-4">
                    <!-- Website -->
                    <div class="space-y-4">
                        <label class="label-text">Website Perusahaan</label>
                        <input type="text" name="website_perusahaan" class="input-field" placeholder="https://...">
                    </div>
                    <!-- LinkedIn -->
                    <div class="space-y-4">
                        <label class="label-text">LinkedIn Perusahaan</label>
                        <input type="text" name="linkedin_perusahaan" class="input-field" placeholder="Link">
                    </div>
                    <!-- Instagram -->
                    <div class="space-y-4">
                        <label class="label-text">Instagram Perusahaan</label>
                        <input type="text" name="instagram_perusahaan" class="input-field" placeholder="@username">
                    </div>
                </div>

                <!-- Logo -->
                <div class="form-row">
                    <label class="label-text">Logo Perusahaan</label>
                    <div class="space-y-2">
                        <input type="file" name="logo_perusahaan" class="input-field !py-1.5 !px-2 text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-[#0061FF] file:text-white hover:file:bg-[#0056e0] cursor-pointer transition-all">
                        <p class="text-[11px] text-slate-400">Mendukung: JPG, JPEG, PNG (Maks 2MB)</p>
                    </div>
                </div>

                <!-- Tahun Daftar -->
                <div class="form-row">
                    <div class="md:w-[200px]">
                        <label class="label-text">Tahun Daftar <span class="text-red-500 font-bold">*</span></label>
                    </div>
                    <div class="flex-1">
                        <select name="tahun_daftar" required class="input-field">
                            <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                                <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <!-- Status Startup -->
                <div class="form-row">
                    <div class="md:w-[200px]">
                        <label class="label-text">Status Startup <span class="text-red-500 font-bold">*</span></label>
                    </div>
                    <div class="flex-1">
                        <select name="status_startup" required class="input-field">
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end gap-4 pt-12">
                    <a href="javascript:history.back()" class="px-6 py-2.5 text-slate-600 font-semibold text-sm hover:bg-slate-100 rounded-md transition-all">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Simpan Data Startup
                    </button>
                </div>

            </form>

            <!-- FOOTER DISATUKAN KEMBALI KE DALAM CARD -->
            <div class="mt-20 pt-10 border-t border-slate-100">
                <?= view('Partials/footer') ?>
            </div>
        </div>

        <div class="h-20"></div> <!-- Ruang di bawah kartu agar border kartu tidak nempel ke bawah layar -->

    </main>

</body>
</html>
