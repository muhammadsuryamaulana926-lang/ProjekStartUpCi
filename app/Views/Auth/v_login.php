<?php /* View: Halaman Login — form autentikasi user dengan animasi split panel dan video background */ ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIMIK StartUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
    <style>
        body {
            overflow: hidden;
        }

        @keyframes fadeCycle {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            5% {
                opacity: 1;
                transform: translateY(0);
            }

            90% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(10px);
            }
        }

        .animate-fade-custom {
            animation: fadeCycle 20s ease-in-out forwards;
        }

        .glass-line {
            width: 1px;
            height: 40px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        /* ANIMASI SPLIT LOGIN */
        .login-panel-left {
            transition: transform 0.7s cubic-bezier(0.76, 0, 0.24, 1);
        }

        .login-panel-right {
            transition: transform 0.7s cubic-bezier(0.76, 0, 0.24, 1);
        }

        .is-logging-in .login-panel-left {
            transform: translateX(-100%);
        }

        .is-logging-in .login-panel-right {
            transform: translateX(100%);
        }

        /* Overlay Transisi Halus */
        .transition-overlay {
            position: fixed;
            inset: 0;
            background: #0061FF;
            z-index: 50;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.5s cubic-bezier(0.76, 0, 0.24, 1);
            pointer-events: none;
        }

        .is-logging-in .transition-overlay {
            transform: scaleX(1);
            transition-delay: 0.5s;
        }

        /* Login Form Styles */
        .login-wrapper {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .login-left {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 4rem;
            background: #fff;
            position: relative;
            z-index: 30;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        @media (min-width: 992px) {
            .login-left {
                width: 41.666%;
                padding: 2rem 5rem;
            }

            .login-right {
                display: block !important;
                width: 58.333%;
            }
        }

        .login-right {
            display: none;
            position: relative;
            background: #fff;
            overflow: hidden;
        }

        .login-right video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: bottom;
        }

        .login-right .overlay-content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 0 5rem;
        }

        .login-right .bottom-labels {
            position: absolute;
            bottom: 4rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .input-group-login {
            display: flex;
            overflow: hidden;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            transition: all 0.3s;
        }

        .input-group-login:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 97, 255, 0.1);
        }

        .input-group-login input {
            flex: 1;
            padding: 1rem 1.25rem;
            background: #fff;
            border: none;
            outline: none;
            font-weight: 500;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--slate-800);
        }

        .input-group-login input::placeholder {
            color: var(--slate-400);
        }

        .input-group-login .input-icon {
            background: var(--slate-50);
            padding: 0 1rem;
            display: flex;
            align-items: center;
            border-left: 1px solid var(--slate-200);
        }

        .input-group-login .input-icon svg {
            width: 20px;
            height: 20px;
            color: var(--slate-400);
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: #fff;
            font-weight: 900;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-login:hover {
            background: var(--primary-hover);
        }

        .btn-login:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body id="loginBody">

    <div class="transition-overlay"></div>

    <div class="login-wrapper">

        <!-- Bagian kiri: form login dengan input email, password, dan tombol masuk -->
        <div id="leftPanel" class="login-panel-left login-left">

            <div style="max-width:448px;width:100%;margin:0 auto;text-align:center">
                <!-- LOGO -->
                <div class="mb-4 d-flex justify-content-center">
                    <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK" style="height:40px;width:auto;opacity:0.9">
                </div>

                <!-- GARIS PEMBATAS -->
                <div class="mb-4" style="width:100%;height:1px;background:var(--slate-100)"></div>

                <!-- HEADER TEKS -->
                <div class="mb-5 text-center">
                    <h1 class="fw-black text-slate-900 mb-3 tracking-tight" style="font-size:2rem">Selamat Datang</h1>
                    <p class="text-slate-500 fw-medium" style="font-size:16px;line-height:1.6">
                        Masuk ke dasbor manajemen startup Anda untuk memantau pertumbuhan hari ini.
                    </p>
                </div>

                <!-- FORM INPUT -->
                <!-- Form login: dikirim ke endpoint authenticate dengan metode POST -->
                <form id="form-login" action="<?= base_url('authenticate') ?>" method="POST" class="text-start">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <div class="input-group-login">
                            <input type="email" name="email" placeholder="contoh@gmail.com">
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group-login">
                            <input type="password" name="password" id="password" placeholder="*******">
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2 mb-3">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="show-pass" onclick="togglePassword()" class="form-check-input me-2" style="width:16px;height:16px;cursor:pointer">
                            <label for="show-pass" class="fw-semibold text-slate-500" style="font-size:14px;cursor:pointer">Tampilkan kata sandi</label>
                        </div>
                        <a href="#" class="fw-bold text-decoration-none" style="font-size:14px;color:var(--primary)">Lupa Password?</a>
                    </div>
                    
                    <!-- Tampilkan pesan error jika login gagal (dari flashdata session) -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-3 p-3 rounded-3 text-center" style="background:#fff1f2;border:1px solid #fecdd3">
                            <span class="fw-bold text-uppercase" style="font-size:12px;color:#e11d48">
                                <?= session()->getFlashdata('error') ?>
                            </span>
                        </div>
                    <?php endif; ?>


                    <!-- Tombol submit form login -->
                    <button type="submit" class="btn-login">Masuk</button>

                    <!-- Tautan pendaftaran akun baru -->
                    <div class="text-center mt-4">
                        <p class="text-slate-400 fw-bold" style="font-size:14px">
                            Belum punya akun? <a href="#" class="fw-bold text-decoration-none" style="color:var(--primary)">Daftar Sekarang</a>
                        </p>
                    </div>
                </form>

                <div class="mt-5 pt-4 border-top" style="border-color:#e2e8f0 !important">
                    <p class="text-slate-400 fw-bold text-uppercase tracking-widest mb-0" style="font-size:10px">
                        Hak Cipta &copy; 2026 SIMIK DKST
                    </p>
                </div>
            </div>
        </div>

        <!-- Bagian kanan: video background dengan teks motivasi -->
        <div id="rightPanel" class="login-panel-right login-right">
            <video autoplay muted loop playsinline>
                <source src="<?= base_url('vidio/WhatsApp Video 2026-03-31 at 18.53.37.mp4') ?>" type="video/mp4">
            </video>

            <div class="overlay-content">
                <div class="animate-fade-custom p-5 text-center" style="filter: drop-shadow(0 4px 12px rgba(0,0,0,0.6));">
                    <h2 class="fw-black mb-4 text-uppercase text-white tracking-tight" style="font-size:5rem">StartUp</h2>
                    <p class="fw-bold text-white" style="font-size:1.5rem;line-height:1.6;max-width:500px">
                        Wujudkan ide brilian Anda menjadi kenyataan bersama sistem manajemen inkubasi bisnis masa depan.
                    </p>
                </div>
            </div>

            <div class="bottom-labels">
                <div class="d-flex flex-column align-items-center gap-2">
                    <span class="text-xxs fw-black tracking-mega text-uppercase text-white" style="filter:drop-shadow(0 2px 4px rgba(0,0,0,0.5))">Inovasi</span>
                    <div class="glass-line"></div>
                </div>
                <div class="d-flex flex-column align-items-center gap-2">
                    <span class="text-xxs fw-black tracking-mega text-uppercase text-white" style="filter:drop-shadow(0 2px 4px rgba(0,0,0,0.5))">Pertumbuhan</span>
                    <div class="glass-line"></div>
                </div>
                <div class="d-flex flex-column align-items-center gap-2">
                    <span class="text-xxs fw-black tracking-mega text-uppercase text-white" style="filter:drop-shadow(0 2px 4px rgba(0,0,0,0.5))">Kesuksesan</span>
                    <div class="glass-line"></div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Jalankan animasi split panel saat form login disubmit, lalu submit setelah animasi selesai
        document.getElementById('form-login').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            document.body.classList.add('is-logging-in');
            // Submit setelah animasi split + overlay biru selesai (~1 detik)
            setTimeout(() => form.submit(), 1000);
        });

        // Toggle visibilitas password antara teks dan bintang
        function togglePassword() {
            var x = document.getElementById("password");
            x.type = x.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>