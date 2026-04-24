<?php /* View: Halaman Login */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIMIK StartUp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif !important; }
        body { overflow: hidden; margin: 0; background: #000; }

        @keyframes fadeCycle {
            0%   { opacity: 0; transform: translateY(10px); }
            5%   { opacity: 1; transform: translateY(0); }
            90%  { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(10px); }
        }
        .animate-fade-custom { animation: fadeCycle 20s ease-in-out forwards; }
        .glass-line { width:1px; height:40px; background:linear-gradient(to bottom,transparent,rgba(255,255,255,0.5),transparent); }

        /* ══ OVERLAY BIRU SAAT LOGIN ══ */
        .transition-overlay {
            position: fixed; inset: 0; background: #0061FF;
            z-index: 9999; transform: scaleX(0); transform-origin: center;
            transition: transform 0.5s cubic-bezier(0.76,0,0.24,1);
            pointer-events: none;
        }
        .is-logging-in .transition-overlay {
            transform: scaleX(1);
            transition-delay: 0.5s;
        }

        /* ══ WRAPPER UTAMA ══ */
        .login-wrapper {
            width: 100vw; height: 100vh;
            overflow: hidden; position: relative;
        }

        /* ══ PANEL FORM (kiri) ══ */
        .panel-form {
            position: absolute;
            top: 0; left: 0; width: 41.666%; height: 100%;
            background: #fff;
            display: flex; flex-direction: column; justify-content: center;
            padding: 2rem 5rem;
            z-index: 10;
            box-shadow: 4px 0 24px rgba(0,0,0,0.1);
            /* Animasi split login */
            transition: transform 0.7s cubic-bezier(0.76,0,0.24,1),
                        left 0.8s cubic-bezier(0.76,0,0.24,1),
                        top 0.8s cubic-bezier(0.76,0,0.24,1),
                        width 0.8s cubic-bezier(0.76,0,0.24,1),
                        height 0.8s cubic-bezier(0.76,0,0.24,1);
        }

        /* ══ PANEL VIDEO (kanan) ══ */
        .panel-video {
            position: absolute;
            top: 0; left: 41.666%; width: 58.334%; height: 100%;
            overflow: hidden;
            transition: transform 0.7s cubic-bezier(0.76,0,0.24,1),
                        left 0.8s cubic-bezier(0.76,0,0.24,1),
                        top 0.8s cubic-bezier(0.76,0,0.24,1),
                        width 0.8s cubic-bezier(0.76,0,0.24,1),
                        height 0.8s cubic-bezier(0.76,0,0.24,1);
        }
        .panel-video video {
            position: absolute; top:0; left:0;
            width:100%; height:100%; object-fit:cover;
        }
        .panel-video .overlay-content {
            position: absolute; inset: 0;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            color: #fff; padding: 0 5rem; text-align: center;
        }
        .panel-video .bottom-labels {
            position: absolute; bottom: 4rem; width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 3rem;
        }

        /* ══ ANIMASI SPLIT SAAT LOGIN ══ */
        .is-logging-in .panel-form  { transform: translateX(-100%); }
        .is-logging-in .panel-video { transform: translateX(100%); }

        /* ══ STATE: SWAPPED (Daftar) — form kanan, video kiri ══ */
        .login-wrapper.swapped .panel-form  { left: 58.334%; box-shadow: -4px 0 24px rgba(0,0,0,0.1); }
        .login-wrapper.swapped .panel-video { left: 0; }

        /* ══ STATE: VERTICAL (Lupa Password) — video atas, form bawah ══ */
        .login-wrapper.vertical .panel-video {
            top: 0; left: 0; width: 100%; height: 45%;
        }
        .login-wrapper.vertical .panel-form {
            top: 45%; left: 0; width: 100%; height: 55%;
            padding: 1.5rem 35%;
            box-shadow: 0 -4px 24px rgba(0,0,0,0.1);
        }
        @media (max-width: 1200px) { .login-wrapper.vertical .panel-form { padding: 1.5rem 20%; } }
        @media (max-width: 768px)  { .login-wrapper.vertical .panel-form { padding: 1.5rem 2rem; } }
        @media (max-width: 991px)  {
            .panel-form  { width: 100%; padding: 2rem; }
            .panel-video { display: none; }
            .login-wrapper.swapped .panel-form,
            .login-wrapper.vertical .panel-form { left: 0; width: 100%; top: 0; height: 100%; padding: 2rem; }
        }

        /* ══ FORM CONTENT FADE ══ */
        .form-content {
            max-width: 400px; width: 100%; margin: 0 auto;
            transition: opacity 0.3s, transform 0.3s;
        }
        .form-content.hidden {
            opacity: 0; transform: translateY(8px);
            pointer-events: none; position: absolute;
            width: 1px; height: 1px; overflow: hidden;
        }

        /* ══ INPUT ══ */
        .input-group-login {
            display: flex; overflow: hidden;
            border: 1px solid #dee2e6; border-radius: 6px; background: #fff;
        }
        .input-group-login input {
            flex: 1; padding: 0.75rem 1rem;
            background: #fff; border: none; outline: none;
            font-size: 14px; color: #212529;
        }
        .input-group-login input::placeholder { color: #adb5bd; }
        .input-group-login .input-icon {
            background: #fff; padding: 0 0.75rem;
            display: flex; align-items: center;
            border-left: 1px solid #dee2e6;
        }
        .input-group-login .input-icon svg { width: 18px; height: 18px; color: #adb5bd; }

        /* ══ TOMBOL ══ */
        .btn-auth {
            width: 100%; padding: 0.85rem;
            background: #0061FF; color: #fff;
            font-weight: 400; border: none; border-radius: 6px;
            cursor: pointer; font-size: 15px;
            text-transform: uppercase; letter-spacing: 0.1em;
            transition: background 0.2s;
        }
        .btn-auth:hover { background: #0052d9; }
        .btn-auth:active { transform: scale(0.98); }

        /* ══ LOGO POJOK (hanya saat vertical) ══ */
        .logo-corner {
            display: none; position: fixed;
            top: 16px; left: 20px; z-index: 100;
        }
    </style>
</head>
<body id="loginBody">

<div class="transition-overlay"></div>

<div class="logo-corner" id="logoCorner">
    <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo" style="height:32px;">
</div>

<div class="login-wrapper" id="loginWrapper">

    <!-- Panel Form -->
    <div class="panel-form" id="panelForm">

        <!-- Form Login -->
        <div class="form-content" id="formLogin">
            <div class="mb-4 text-center">
                <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo" style="height:36px;">
            </div>
            <div class="mb-4" style="height:1px;background:#f1f5f9;"></div>
            <div class="mb-4 text-center">
                <h1 style="font-size:1.75rem;font-weight:700;">Selamat Datang</h1>
                <p class="text-muted" style="font-size:14px;line-height:1.6;">Masuk ke dasbor manajemen startup Anda.</p>
            </div>
            <form id="form-login" action="<?= base_url('authenticate') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label small mb-1">Email</label>
                    <div class="input-group-login">
                        <input type="email" name="email" placeholder="contoh@gmail.com">
                        <div class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small mb-1">Kata Sandi</label>
                    <div class="input-group-login">
                        <input type="password" name="password" id="password" placeholder="*******">
                        <div class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3" style="font-size:13px;">
                    <label style="cursor:pointer;color:#6c757d;">
                        <input type="checkbox" onclick="togglePassword()" class="form-check-input me-1" style="width:14px;height:14px;">
                        Tampilkan kata sandi
                    </label>
                    <a href="#" onclick="keVertical(event)" class="text-decoration-none" style="color:#0061FF;">Lupa Password?</a>
                </div>
                <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-3 p-3 rounded text-center" style="background:#fff1f2;border:1px solid #fecdd3;font-size:12px;color:#e11d48;">
                    <?= session()->getFlashdata('error') ?>
                </div>
                <?php endif; ?>
                <button type="submit" class="btn-auth">Masuk</button>
                <div class="text-center mt-4" style="font-size:13px;color:#adb5bd;">
                    Belum punya akun?
                    <a href="#" onclick="keSwapped(event)" class="text-decoration-none" style="color:#0061FF;">Daftar Sekarang</a>
                </div>
            </form>
            <div class="mt-4 pt-3 border-top text-center" style="font-size:10px;color:#adb5bd;text-transform:uppercase;letter-spacing:0.05em;">
                Hak Cipta &copy; 2026 SIMIK DKST
            </div>
        </div>

        <!-- Form Daftar -->
        <div class="form-content hidden" id="formDaftar">
            <div class="mb-4 text-center">
                <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo" style="height:36px;">
            </div>
            <div class="mb-4" style="height:1px;background:#f1f5f9;"></div>
            <div class="mb-4 text-center">
                <h1 style="font-size:1.75rem;font-weight:700;">Buat Akun</h1>
                <p class="text-muted" style="font-size:14px;line-height:1.6;">Daftarkan startup Anda ke sistem SIMIK.</p>
            </div>
            <form>
                <div class="mb-3">
                    <label class="form-label small mb-1">Nama Lengkap</label>
                    <div class="input-group-login">
                        <input type="text" placeholder="Nama lengkap Anda">
                        <div class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small mb-1">Email</label>
                    <div class="input-group-login">
                        <input type="email" placeholder="contoh@gmail.com">
                        <div class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small mb-1">Kata Sandi</label>
                    <div class="input-group-login">
                        <input type="password" placeholder="*******">
                        <div class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                    </div>
                </div>
                <button type="submit" class="btn-auth">Daftar</button>
                <div class="text-center mt-4" style="font-size:13px;color:#adb5bd;">
                    Sudah punya akun?
                    <a href="#" onclick="keDefault(event)" class="text-decoration-none" style="color:#0061FF;">Masuk</a>
                </div>
            </form>
            <div class="mt-4 pt-3 border-top text-center" style="font-size:10px;color:#adb5bd;text-transform:uppercase;letter-spacing:0.05em;">
                Hak Cipta &copy; 2026 SIMIK DKST
            </div>
        </div>

        <!-- Form Lupa Password -->
        <div class="form-content hidden" id="formLupa">
            <div class="mb-4 text-center">
                <h1 style="font-size:1.75rem;font-weight:700;">Lupa Password?</h1>
                <p class="text-muted" style="font-size:14px;line-height:1.6;">Masukkan email Anda untuk menerima tautan reset password.</p>
            </div>
            <form>
                <div class="mb-3">
                    <label class="form-label small mb-1">Email</label>
                    <div class="input-group-login">
                        <input type="email" placeholder="contoh@gmail.com">
                        <div class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                    </div>
                </div>
                <button type="submit" class="btn-auth">Kirim Tautan Reset</button>
                <div class="text-center mt-4">
                    <a href="#" onclick="keDefault(event)" class="text-decoration-none"
                       style="font-size:13px;color:#0061FF;border:1px solid #0061FF;border-radius:999px;padding:6px 20px;display:inline-block;transition:all 0.2s;"
                       onmouseover="this.style.background='#0061FF';this.style.color='#fff';"
                       onmouseout="this.style.background='transparent';this.style.color='#0061FF';">
                        &larr; Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

    </div>

    <!-- Panel Video -->
    <div class="panel-video" id="panelVideo">
        <video autoplay muted loop playsinline>
            <source src="<?= base_url('vidio/ssstik.io_1777016178477.mp4') ?>" type="video/mp4">
        </video>
        <div class="overlay-content">
            <div class="animate-fade-custom" style="filter:drop-shadow(0 4px 12px rgba(0,0,0,0.6));">
                <h2 style="font-size:4rem;font-weight:800;color:#fff;text-transform:uppercase;margin-bottom:1rem;">StartUp</h2>
                <p style="font-size:1.2rem;color:#fff;line-height:1.6;max-width:500px;">
                    Wujudkan ide brilian Anda menjadi kenyataan bersama sistem manajemen inkubasi bisnis masa depan.
                </p>
            </div>
        </div>
        <div class="bottom-labels">
            <div class="d-flex flex-column align-items-center gap-2">
                <span style="font-size:10px;font-weight:700;text-transform:uppercase;color:rgba(255,255,255,0.7);letter-spacing:0.1em;">Inovasi</span>
                <div class="glass-line"></div>
            </div>
            <div class="d-flex flex-column align-items-center gap-2">
                <span style="font-size:10px;font-weight:700;text-transform:uppercase;color:rgba(255,255,255,0.7);letter-spacing:0.1em;">Pertumbuhan</span>
                <div class="glass-line"></div>
            </div>
            <div class="d-flex flex-column align-items-center gap-2">
                <span style="font-size:10px;font-weight:700;text-transform:uppercase;color:rgba(255,255,255,0.7);letter-spacing:0.1em;">Kesuksesan</span>
                <div class="glass-line"></div>
            </div>
        </div>
    </div>

</div>

<script>
    // ── Submit login: animasi split lalu submit ──
    document.getElementById('form-login').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        document.body.classList.add('is-logging-in');
        setTimeout(function() { form.submit(); }, 1000);
    });

    function togglePassword() {
        var x = document.getElementById('password');
        x.type = x.type === 'password' ? 'text' : 'password';
    }

    // ── Ganti form dengan fade ──
    function tampilForm(id) {
        ['formLogin','formDaftar','formLupa'].forEach(function(f) {
            document.getElementById(f).classList.add('hidden');
        });
        setTimeout(function() {
            document.getElementById(id).classList.remove('hidden');
        }, 350);
    }

    // ── Daftar: form geser kanan, video geser kiri ──
    function keSwapped(e) {
        e.preventDefault();
        var w = document.getElementById('loginWrapper');
        w.classList.remove('vertical');
        w.classList.add('swapped');
        document.getElementById('logoCorner').style.display = 'none';
        tampilForm('formDaftar');
    }

    // ── Lupa Password: video atas, form bawah ──
    function keVertical(e) {
        e.preventDefault();
        var w = document.getElementById('loginWrapper');
        w.classList.remove('swapped');
        w.classList.add('vertical');
        document.getElementById('logoCorner').style.display = 'block';
        tampilForm('formLupa');
    }

    // ── Kembali ke default ──
    function keDefault(e) {
        e.preventDefault();
        var w = document.getElementById('loginWrapper');
        w.classList.remove('swapped', 'vertical');
        document.getElementById('logoCorner').style.display = 'none';
        tampilForm('formLogin');
    }
</script>
</body>
</html>
