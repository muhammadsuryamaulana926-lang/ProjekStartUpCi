<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIMIK StartUp</title>
    <!-- Memanggil CSS Tailwind yang sudah kita build -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.01em;
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <!-- INCLUDE PARTIAL: SIDEBAR -->
        <?= view('Partials/sidebar') ?>

        <!-- MAIN LAYOUT AREA -->
        <main class="flex-1 flex flex-col min-w-0 bg-white relative overflow-hidden">
            
            <!-- INCLUDE PARTIAL: TOPBAR -->
            <?= view('Partials/topbar') ?>

            <!-- CONTENT AREA (Scrollable) -->
            <div class="flex-1 overflow-y-auto px-10 py-12 scrollbar-thin scrollbar-thumb-slate-100 scrollbar-track-transparent">
                
                <!-- CONTENT HEADER -->
                <div class="flex items-center justify-between mb-12">
                    <div class="flex items-center gap-4">
                        <h2 class="text-4xl font-black text-slate-900 tracking-tight">Katalog Startup</h2>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl shadow-sm border border-blue-100/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <button class="p-3 bg-slate-50 text-slate-400 hover:text-blue-600 border border-slate-100 rounded-2xl transition-all duration-200 shadow-sm focus:ring-4 focus:ring-blue-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 uppercase" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                        <button class="p-3 bg-slate-50 text-slate-400 hover:text-blue-600 border border-slate-100 rounded-2xl transition-all duration-200 shadow-sm focus:ring-4 focus:ring-blue-100">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                           </svg>
                        </button>
                    </div>
                </div>

                <!-- SECTION: QUICK ACCESS (Folder Cards) -->
                <div class="mb-14">
                    <h3 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8 border-l-4 border-blue-600 pl-4">Kategori Inkubasi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
                        
                        <!-- CARD 1 (Active) -->
                        <div class="bg-blue-600 p-8 rounded-[40px] shadow-2xl shadow-blue-500/30 transform hover:-translate-y-2 transition-all duration-300 group cursor-pointer border border-transparent">
                            <div class="text-[10px] font-black text-white/50 uppercase tracking-widest mb-6 border-b border-white/10 pb-4">TERBAGI PADA</div>
                            <div class="flex -space-x-3 mb-8">
                                <div class="w-10 h-10 bg-white/20 rounded-full border-2 border-blue-600 ring-2 ring-white/10 items-center justify-center flex font-black text-xs text-white">A</div>
                                <div class="w-10 h-10 bg-blue-400 rounded-full border-2 border-blue-600 ring-2 ring-white/10 items-center justify-center flex font-black text-xs text-white shadow-xl">B</div>
                                <div class="w-10 h-10 bg-slate-200 rounded-full border-2 border-blue-600 ring-2 ring-white/10 items-center justify-center flex font-black text-xs text-blue-600 shadow-xl">C</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-white/10 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white uppercase font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-black text-base uppercase tracking-wider mb-0.5 leading-none">FinTech</h4>
                                    <span class="text-[10px] font-bold text-white/60">Startup Keuangan</span>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 2 -->
                        <div class="bg-slate-50 p-8 rounded-[40px] shadow-sm hover:shadow-xl hover:bg-white border border-slate-100 transform hover:-translate-y-2 transition-all duration-300 group cursor-pointer">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-4">TERBAGI PADA</div>
                            <div class="flex -space-x-3 mb-8">
                                <div class="w-10 h-10 bg-slate-300 rounded-full border-2 border-slate-50 ring-2 ring-slate-100 items-center justify-center flex font-black text-xs text-white group-hover:border-white group-hover:ring-slate-50">E</div>
                                <div class="w-10 h-10 bg-blue-100 rounded-full border-2 border-slate-50 ring-2 ring-slate-100 items-center justify-center flex font-black text-xs text-blue-600 group-hover:border-white shadow-xl group-hover:ring-slate-50">F</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 uppercase" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-slate-800 font-black text-base uppercase tracking-wider mb-0.5 leading-none group-hover:text-blue-600 transition-colors">Edutech</h4>
                                    <span class="text-[10px] font-bold text-slate-400">Pendidikan Digital</span>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 3 -->
                        <div class="bg-slate-50 p-8 rounded-[40px] shadow-sm hover:shadow-xl hover:bg-white border border-slate-100 transform hover:-translate-y-2 transition-all duration-300 group cursor-pointer">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-4 shadow-sm">TERBAGI PADA</div>
                            <div class="flex -space-x-3 mb-8">
                                <div class="w-10 h-10 bg-slate-200 rounded-full border-2 border-slate-50 ring-2 ring-slate-100 items-center justify-center flex font-black text-xs text-slate-600 group-hover:border-white group-hover:ring-slate-50">H</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 uppercase" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-slate-800 font-black text-base uppercase tracking-wider mb-0.5 leading-none group-hover:text-blue-600 transition-colors">AgriTech</h4>
                                    <span class="text-[10px] font-bold text-slate-400">Teknologi Pertanian</span>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 4: Data Card -->
                        <div class="bg-blue-50/50 p-8 rounded-[40px] border-2 border-dashed border-blue-200 flex flex-col items-center justify-center group hover:bg-blue-100/50 cursor-pointer transition-all duration-300 shadow-xl">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-lg group-hover:scale-110 transition-transform duration-300 border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest mt-4">Tambah Kategori</span>
                        </div>

                    </div>
                </div>

                <!-- SECTION: ALL FILES (Table) -->
                <div>
                    <h3 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8 border-l-4 border-blue-600 pl-4 shadow-sm uppercase">Semua Startup Aktif</h3>
                    
                    <div class="bg-white rounded-[40px] border border-slate-50 overflow-hidden shadow-2xl shadow-slate-100/50">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80">
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Nama Startup</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 shadow-sm">Pemilik / CEO</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Terakhir Update</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Ukuran Data</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                
                                <!-- ROW 1 -->
                                <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                                    <td class="px-8 py-6 uppercase">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-black shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">S1</div>
                                            <div>
                                                <div class="text-sm font-black text-slate-900 mb-0.5 tracking-tight group-hover:text-blue-600 transition-colors uppercase">Sentra Digital</div>
                                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none uppercase">Fintech Solution</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex -space-x-2">
                                            <div class="w-8 h-8 bg-slate-800 rounded-full border-2 border-white flex items-center justify-center text-[10px] font-black tracking-widest font-bold text-white uppercase font-bold">R</div>
                                            <div class="w-8 h-8 bg-blue-400 rounded-full border-2 border-white flex items-center justify-center text-[10px] font-black tracking-widest font-bold text-white uppercase font-bold">D</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-[11px] font-black text-slate-500 uppercase tracking-wider">31 Mar 2026</div>
                                        <div class="text-[10px] font-bold text-slate-400 leading-none mt-1 uppercase tracking-widest">19:44 WIB</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-xs font-black text-slate-800 uppercase tracking-widest">2.4 GB</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-2">
                                            <button class="p-2 text-slate-300 hover:text-blue-600 hover:bg-white rounded-lg transition-all shadow-sm border border-transparent hover:border-blue-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button class="p-2 text-slate-300 hover:text-blue-600 hover:bg-white rounded-lg transition-all shadow-sm border border-transparent hover:border-blue-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ROW 2 -->
                                <tr class="hover:bg-slate-50/50 transition-colors duration-200 group uppercase shadow-sm">
                                    <td class="px-8 py-6 uppercase">
                                        <div class="flex items-center gap-4 shadow-sm">
                                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center font-black shadow-sm group-hover:bg-green-600 group-hover:text-white transition-colors">A3</div>
                                            <div>
                                                <div class="text-sm font-black text-slate-900 mb-0.5 tracking-tight group-hover:text-blue-600 transition-colors uppercase">Agro Makmur</div>
                                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none uppercase">Agritech Innovation</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 shadow-sm">
                                        <div class="flex -space-x-2">
                                            <div class="w-8 h-8 bg-blue-700 rounded-full border-2 border-white flex items-center justify-center text-[10px] font-black tracking-widest font-bold text-white uppercase font-bold">P</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 shadow-sm">
                                        <div class="text-[11px] font-black text-slate-500 uppercase tracking-wider">30 Mar 2026</div>
                                        <div class="text-[10px] font-bold text-slate-400 leading-none mt-1 uppercase tracking-widest">10:20 WIB</div>
                                    </td>
                                    <td class="px-8 py-6 shadow-sm">
                                        <div class="text-xs font-black text-slate-800 uppercase tracking-widest">540 MB</div>
                                    </td>
                                    <td class="px-8 py-6 shadow-sm">
                                        <div class="flex items-center gap-2">
                                            <button class="p-2 text-slate-300 hover:text-blue-600 hover:bg-white rounded-lg transition-all shadow-sm border border-transparent hover:border-blue-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button class="p-2 text-slate-300 hover:text-blue-600 hover:bg-white rounded-lg transition-all shadow-sm border border-transparent hover:border-blue-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

            <!-- INCLUDE PARTIAL: FOOTER -->
            <?= view('Partials/footer') ?>

        </main>

    </div>

</body>
</html>
