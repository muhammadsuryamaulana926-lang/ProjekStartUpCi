<?php /* Partial: Header — dimuat di setiap halaman sebagai pembuka struktur HTML utama */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMIK StartUp</title>
    <!-- Import Font Inter & Lucide Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- CSS Bootstrap untuk layout dan komponen UI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS ikon Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- CSS Select2 untuk dropdown pencarian -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- CSS kustom aplikasi -->
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
    <!-- jQuery — wajib dimuat sebelum Select2 dan SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- JS Select2 untuk dropdown dengan fitur pencarian -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- JS SweetAlert2 untuk notifikasi popup yang lebih menarik -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Plyr.io — Modern Video Player for YouTube without branding -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    <style>
        /* Global Font Override */
        body, .app-wrapper, .app-main, .sidebar, .topbar {
            font-family: 'Inter', sans-serif !important;
        }

        /* Modern Scrollbar Minimalis */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Empty State Utilities */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            text-align: center;
        }
        .empty-state-icon {
            color: #cbd5e1;
            margin-bottom: 16px;
        }
        .empty-state-text {
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
        }
        
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>

    <script>
        // Override default SweetAlert untuk Toast Minimalis
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Intercept Swal.fire specifically for success messages globally to use our Toast
        const originalSwalFire = Swal.fire;
        Swal.fire = function(...args) {
            // Check if user passed an object
            if (args.length === 1 && typeof args[0] === 'object') {
                if (args[0].icon === 'success' && (!args[0].showCancelButton)) {
                    args[0].toast = true;
                    args[0].position = 'top-end';
                    args[0].showConfirmButton = false;
                    args[0].timer = 3000;
                    args[0].customClass = { popup: 'swal2-toast-minimal' };
                }
            }
            return originalSwalFire.apply(this, args);
        };
    </script>
</head>
<body>
<!-- Wrapper utama pembungkus seluruh konten aplikasi -->
<div class="app-wrapper">
