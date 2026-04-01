<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIMIK StartUp</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; }
        @keyframes fadeCycle {
            0% { opacity: 0; transform: translateY(10px); }
            5% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(10px); }
        }
        .animate-fade-custom { animation: fadeCycle 20s ease-in-out forwards; }
        .glass-line { width: 1px; height: 40px; background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.5), transparent); }

        /* ANIMASI SPLIT LOGIN */
        .login-panel-left { transition: transform 0.8s cubic-bezier(0.7, 0, 0.3, 1); }
        .login-panel-right { transition: transform 0.8s cubic-bezier(0.7, 0, 0.3, 1); }
        
        .is-logging-in .login-panel-left { transform: translateX(-100%); }
        .is-logging-in .login-panel-right { transform: translateX(100%); }
        
        /* Overlay Transisi Halus */
        .transition-overlay {
            position: fixed;
            inset: 0;
            background: #0061FF;
            z-index: 50;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.6s cubic-bezier(0.7, 0, 0.3, 1);
            pointer-events: none;
        }
        .is-logging-in .transition-overlay { transform: scaleX(1); transition-delay: 0.4s; }
    </style>
</head>
<body class="bg-white overflow-hidden text-slate-800" id="loginBody">

    <div class="transition-overlay"></div>

    <div class="flex flex-col lg:flex-row min-h-screen overflow-hidden">
        
        <!-- BAGIAN KIRI: Form Login Terpusat -->
        <div id="leftPanel" class="login-panel-left w-full lg:w-5/12 flex flex-col justify-center px-8 sm:px-16 lg:px-20 xl:px-24 bg-white relative z-30 shadow-2xl">
            
            <div class="max-w-md w-full mx-auto text-center">
                <!-- LOGO DI TENGAH -->
                <div class="mb-6 flex justify-center">
                    <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK" class="h-10 lg:h-12 w-auto opacity-90">
                </div>

                <!-- GARIS ABU-ABU PEMBATAS -->
                <div class="w-full h-px bg-slate-100 mb-8"></div>

                <!-- HEADER TEKS -->
                <div class="mb-10 text-center">
                    <h1 class="text-3xl lg:text-4xl font-black text-slate-900 mb-3 tracking-tight">Selamat Datang</h1>
                    <p class="text-slate-500 font-medium text-base leading-relaxed">
                        Masuk ke dasbor manajemen startup Anda untuk memantau pertumbuhan hari ini.
                    </p>
                </div>

                <!-- FORM INPUT -->
                <form action="#" method="POST" class="space-y-4 text-left" onsubmit="return false;">
                    <div class="flex flex-col group">
                        <div class="flex overflow-hidden border border-slate-200 rounded-xl focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-300">
                            <!-- Background diubah ke bg-white -->
                            <input type="email" name="email" class="w-full px-5 py-4 bg-white outline-none font-medium placeholder:text-slate-400 text-sm" placeholder="contoh@gmail.com">
                            <div class="bg-slate-50 px-4 flex items-center border-l border-slate-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col group">
                        <div class="flex overflow-hidden border border-slate-200 rounded-xl focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-300">
                            <!-- Background diubah ke bg-white -->
                            <input type="password" name="password" id="password" class="w-full px-5 py-4 bg-white outline-none font-medium placeholder:text-slate-400 text-sm" placeholder="*******">
                            <div class="bg-slate-50 px-4 flex items-center border-l border-slate-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="show-pass" onclick="togglePassword()" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 cursor-pointer">
                            <label for="show-pass" class="ml-2 text-sm font-semibold text-slate-500 cursor-pointer">Tampilkan kata sandi</label>
                        </div>
                        <a href="#" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">Lupa Password?</a>
                    </div>

                    <!-- Tombol Masuk -->
                    <button type="button" 
                            id="loginButton"
                            onclick="startLoginProcess()"
                            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl transition-all duration-300 transform active:scale-[0.98] text-base uppercase tracking-widest">
                        Masuk
                    </button>

                    <!-- Tautan Daftar -->
                    <div class="text-center mt-6">
                        <p class="text-slate-400 font-bold text-sm">
                            Belum punya akun? <a href="#" class="text-blue-600 font-bold hover:underline">Daftar Sekarang</a>
                        </p>
                    </div>
                </form>

                <div class="mt-10 pt-6 border-t border-slate-50">
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                        Hak Cipta © 2026 SIMIK DKST
                    </p>
                </div>
            </div>
        </div>

        <!-- BAGIAN KANAN: Video Background -->
        <div id="rightPanel" class="login-panel-right hidden lg:block lg:w-7/12 relative bg-white overflow-hidden">
            <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-full object-cover object-bottom">
                <source src="<?= base_url('vidio/WhatsApp Video 2026-03-31 at 18.53.37.mp4') ?>" type="video/mp4">
            </video>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white px-20">
                <div class="animate-fade-custom p-12 drop-shadow-[0_4px_12px_rgba(0,0,0,0.6)] text-center text-white">
                    <h2 class="text-8xl font-black mb-4 tracking-tighter uppercase text-white">StartUp</h2>
                    <div class="w-24 h-2 bg-blue-500 mb-8 mx-auto rounded-full shadow-lg shadow-blue-500/50"></div>
                    <p class="text-2xl font-bold leading-relaxed max-w-xl text-white">
                        Wujudkan ide brilian Anda menjadi kenyataan bersama sistem manajemen inkubasi bisnis masa depan.
                    </p>
                </div>
            </div>

            <div class="absolute bottom-16 w-full flex items-center justify-center gap-12 text-white/60">
                <div class="flex flex-col items-center gap-3">
                    <span class="text-[10px] font-black tracking-[0.3em] uppercase drop-shadow-md text-white">Inovasi</span>
                    <div class="glass-line"></div>
                </div>
                <div class="flex flex-col items-center gap-3">
                    <span class="text-[10px] font-black tracking-[0.3em] uppercase drop-shadow-md text-white">Pertumbuhan</span>
                    <div class="glass-line"></div>
                </div>
                <div class="flex flex-col items-center gap-3">
                    <span class="text-[10px] font-black tracking-[0.3em] uppercase drop-shadow-md text-white">Kesuksesan</span>
                    <div class="glass-line"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- SCRIPT UNTUK LOGIN PROCESS & TOGGLE PASSWORD -->
    <script>
        function startLoginProcess() {
            // Set flag untuk memicu animasi sidebar hanya saat pertama kali login
            sessionStorage.setItem('isFirstLogin', 'true');

            // Tambahkan class untuk memicu animasi split
            document.body.classList.add('is-logging-in');
            
            // Tunggu animasi selesai, lalu pindah halaman
            setTimeout(() => {
                window.location.href = '<?= base_url('dashboard') ?>';
            }, 900);
        }

        function togglePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>
