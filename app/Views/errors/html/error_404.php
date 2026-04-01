<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - SIMIK</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-gradient-premium {
            background: radial-gradient(circle at top right, #f8fafc 0%, #ffffff 50%, #f1f5f9 100%);
        }
        .text-glow {
            text-shadow: 0 0 40px rgba(0, 97, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-premium min-h-screen flex items-center justify-center p-8 antialiased overflow-hidden">
    
    <div class="max-w-[750px] w-full text-center relative">
        
        <!-- Background Number (Decorative) -->
        <div class="absolute inset-0 flex items-center justify-center -z-10 select-none">
            <span class="text-[280px] font-black text-slate-100/50 tracking-tighter">404</span>
        </div>

        <!-- Main Content -->
        <div class="relative z-10">
            
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-[32px] shadow-2xl shadow-blue-500/10 border border-slate-100 mb-10 transform -rotate-12 transition-transform hover:rotate-0 duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#0061FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-7xl font-black text-slate-900 tracking-tighter mb-4 uppercase text-glow">Opss!</h1>
            <h2 class="text-xs font-black text-[#0061FF] tracking-[0.6em] uppercase mb-12">Halaman Tidak Ditemukan</h2>
            
            <div class="max-w-md mx-auto mb-16">
                <p class="text-sm font-black text-slate-400 tracking-widest leading-loose uppercase">
                    <?php if (ENVIRONMENT !== 'production') : ?>
                        <?= nl2br(esc($message)) ?>
                    <?php else : ?>
                        Maaf, kami tidak dapat menemukan halaman yang Anda cari. <br> Pastikan alamat URL sudah benar atau kembali ke menu utama.
                    <?php endif; ?>
                </p>
            </div>

            <!-- Action Buttons Full Width on small screens -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-5 uppercase">
                <a href="<?= base_url('dashboard') ?>" class="w-full sm:w-auto px-12 py-5 bg-[#0061FF] text-white text-[11px] font-black tracking-widest rounded-2xl hover:bg-blue-600 transition-all shadow-2xl shadow-blue-500/25 active:scale-95 flex items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    KEMBALI KE BERANDA
                </a>
                <button onclick="window.history.back()" class="w-full sm:w-auto px-12 py-5 bg-white border border-slate-200 text-slate-400 text-[11px] font-black tracking-widest rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center gap-3 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    KEMBALI KE SEBELUMNYA
                </button>
            </div>

        </div>

    </div>

    <!-- Footer Decoration -->
    <div class="fixed bottom-10 left-0 right-0 text-center">
        <p class="text-[10px] font-black text-slate-300 tracking-[0.5em] uppercase">
            &copy; 2026 SIMIK - SISTEM INFORMASI MANAJEMEN INKUBASI
        </p>
    </div>

</body>
</html>
