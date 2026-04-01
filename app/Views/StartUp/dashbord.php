<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIMIK StartUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
</head>
<body>

    <div class="app-wrapper">
        
        <!-- SIDEBAR -->
        <?= view('Partials/sidebar') ?>

        <!-- MAIN LAYOUT -->
        <main class="app-main">
            
            <!-- TOPBAR -->
            <?= view('Partials/topbar') ?>

            <!-- CONTENT -->
            <div class="app-content">
                
                <!-- HEADER -->
                <div class="page-header">
                    <div class="d-flex align-items-center gap-3">
                        <h2>Katalog Startup</h2>
                        <div class="p-2 rounded-3" style="background: rgba(0,97,255,0.08);">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:var(--primary)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-light border rounded-3 p-2" style="border-color: var(--slate-100) !important;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:var(--slate-400)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                        <button class="btn btn-light border rounded-3 p-2" style="border-color: var(--slate-100) !important;">
                           <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:var(--slate-400)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                           </svg>
                        </button>
                    </div>
                </div>

                <!-- KATEGORI INKUBASI -->
                <div class="mb-5">
                    <h3 class="section-title">Kategori Inkubasi</h3>
                    
                    <div class="row g-4">
                        
                        <!-- CARD 1 (Active) -->
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="category-card category-card-active">
                                <div class="text-xxs fw-black text-uppercase tracking-widest mb-4 pb-3" style="color:rgba(255,255,255,0.5); border-bottom:1px solid rgba(255,255,255,0.1)">TERBAGI PADA</div>
                                <div class="d-flex mb-4" style="margin-left: -4px;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs text-white" style="width:40px;height:40px;background:rgba(255,255,255,0.2);border:2px solid var(--primary);margin-right:-8px;">A</div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs text-white" style="width:40px;height:40px;background:#60a5fa;border:2px solid var(--primary);margin-right:-8px;">B</div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs" style="width:40px;height:40px;background:var(--slate-200);border:2px solid var(--primary);color:var(--primary);">C</div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-2 rounded-3" style="background:rgba(255,255,255,0.1)">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#fff" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="fw-black fs-6 text-uppercase mb-0 text-white" style="letter-spacing:0.1em">FinTech</h4>
                                        <span class="text-xxs fw-bold" style="color:rgba(255,255,255,0.6)">Startup Keuangan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 2 -->
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="category-card category-card-default">
                                <div class="text-xxs fw-black text-slate-400 text-uppercase tracking-widest mb-4 pb-3" style="border-bottom:1px solid var(--slate-100)">TERBAGI PADA</div>
                                <div class="d-flex mb-4" style="margin-left: -4px;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs text-white" style="width:40px;height:40px;background:var(--slate-300);border:2px solid var(--slate-50);margin-right:-8px;">E</div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs" style="width:40px;height:40px;background:rgba(0,97,255,0.1);border:2px solid var(--slate-50);color:var(--primary);">F</div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-2 rounded-3" style="background:rgba(0,97,255,0.08);color:var(--primary)">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="fw-black fs-6 text-uppercase text-slate-800 mb-0" style="letter-spacing:0.1em">Edutech</h4>
                                        <span class="text-xxs fw-bold text-slate-400">Pendidikan Digital</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 3 -->
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="category-card category-card-default">
                                <div class="text-xxs fw-black text-slate-400 text-uppercase tracking-widest mb-4 pb-3" style="border-bottom:1px solid var(--slate-100)">TERBAGI PADA</div>
                                <div class="d-flex mb-4" style="margin-left: -4px;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs" style="width:40px;height:40px;background:var(--slate-200);border:2px solid var(--slate-50);color:var(--slate-600);">H</div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-2 rounded-3" style="background:rgba(0,97,255,0.08);color:var(--primary)">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="fw-black fs-6 text-uppercase text-slate-800 mb-0" style="letter-spacing:0.1em">AgriTech</h4>
                                        <span class="text-xxs fw-bold text-slate-400">Teknologi Pertanian</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 4: Tambah -->
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="category-card category-card-add">
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-white shadow mb-3" style="width:48px;height:48px;border:1px solid rgba(0,97,255,0.1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:var(--primary)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <span class="text-xxs fw-black text-uppercase tracking-widest" style="color:var(--primary)">Tambah Kategori</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SEMUA STARTUP AKTIF -->
                <div>
                    <h3 class="section-title">Semua Startup Aktif</h3>
                    
                    <div class="card-premium shadow-sm">
                        <table class="table-premium">
                            <thead>
                                <tr>
                                    <th>Nama Startup</th>
                                    <th>Pemilik / CEO</th>
                                    <th>Terakhir Update</th>
                                    <th>Ukuran Data</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ROW 1 -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center fw-black" style="width:40px;height:40px;background:rgba(0,97,255,0.1);color:var(--primary);font-size:11px;">S1</div>
                                            <div>
                                                <div class="company-name">Sentra Digital</div>
                                                <div class="text-xxs fw-bold text-slate-400 text-uppercase tracking-widest">Fintech Solution</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex" style="margin-left:-4px">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs text-white" style="width:32px;height:32px;background:var(--slate-800);border:2px solid #fff;margin-right:-6px">R</div>
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs text-white" style="width:32px;height:32px;background:#60a5fa;border:2px solid #fff">D</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm-custom fw-black text-slate-500 text-uppercase tracking-wider">31 Mar 2026</div>
                                        <div class="text-xxs fw-bold text-slate-400 text-uppercase tracking-widest mt-1">19:44 WIB</div>
                                    </td>
                                    <td>
                                        <div class="text-xs fw-black text-slate-800 text-uppercase tracking-widest">2.4 GB</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <button class="btn-action">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button class="btn-action">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ROW 2 -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center fw-black" style="width:40px;height:40px;background:rgba(34,197,94,0.1);color:#16a34a;font-size:11px;">A3</div>
                                            <div>
                                                <div class="company-name">Agro Makmur</div>
                                                <div class="text-xxs fw-bold text-slate-400 text-uppercase tracking-widest">Agritech Innovation</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex" style="margin-left:-4px">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-xxs text-white" style="width:32px;height:32px;background:#1d4ed8;border:2px solid #fff">P</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm-custom fw-black text-slate-500 text-uppercase tracking-wider">30 Mar 2026</div>
                                        <div class="text-xxs fw-bold text-slate-400 text-uppercase tracking-widest mt-1">10:20 WIB</div>
                                    </td>
                                    <td>
                                        <div class="text-xs fw-black text-slate-800 text-uppercase tracking-widest">540 MB</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <button class="btn-action">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button class="btn-action">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <?= view('Partials/footer') ?>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
