<?php /* Partial: Header — dimuat di setiap halaman sebagai pembuka struktur HTML utama */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMIK StartUp</title>
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
</head>
<body>
<!-- Wrapper utama pembungkus seluruh konten aplikasi -->
<div class="app-wrapper">
