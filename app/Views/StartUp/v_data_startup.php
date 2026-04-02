<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Startup - SIMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/sweetalert2.min.css') ?>">
    <script src="<?= base_url('js/sweetalert2.min.js') ?>"></script>
</head>
<body class="text-uppercase">
    <div class="app-wrapper">
        
        <!-- SIDEBAR -->
        <?= view('Partials/v_sidebar') ?>

        <main class="app-main">
            
            <!-- TOPBAR -->
            <?= view('Partials/v_topbar') ?>

            <!-- CONTENT -->
            <div class="app-content">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2>Data Startup</h2>
                        <p class="subtitle">Manajemen seluruh ekosistem startup</p>
                    </div>
                </div>
 
                <!-- TABLE SECTION -->
                <div class="card-premium shadow-sm">
                    
                    <!-- Table Header Actions -->
                    <div class="d-flex justify-content-end p-4 border-bottom" style="border-color: var(--slate-100) !important;">
                        <div class="d-flex flex-column gap-3 align-items-end">
                            <!-- Tombol Tambah -->
                            <button onclick="window.location.href='<?= base_url('tambah-startup') ?>'" class="btn-primary-custom" style="width:176px">
                                + Tambah
                            </button>

                            <!-- Search Bar -->
                            <div class="search-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" placeholder="CARI DATA STARTUP...">
                            </div>
                        </div>
                    </div>
 
                    <table class="table-premium">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Perusahaan</th>
                                <th>Kluster</th>
                                <th>Email</th>
                                <th>No Whatsapp</th>
                                <th>Tahun Daftar</th>
                                <th>Status Startup</th>
                                <th>Status Ajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($startups)): ?>
                                <?php foreach($startups as $i => $row): ?>
                                <tr id="row-<?= $row['uuid_startup'] ?>">
                                    <td class="text-xs fw-black text-slate-300"><?= $i + 1 ?></td>
                                    <td>
                                        <span class="company-name"><?= $row['nama_perusahaan'] ?></span>
                                    </td>
                                    <td class="text-xs fw-bold text-slate-500" style="text-transform:lowercase"><?= $row['deskripsi_bidang_usaha'] ?? '-' ?></td>
                                    <td class="text-xs fw-bold text-primary-custom text-uppercase"><?= $row['email_perusahaan'] ?></td>
                                    <td class="text-xs fw-bold text-uppercase" style="color:#16a34a"><?= $row['nomor_whatsapp'] ?></td>
                                    <td class="text-xs fw-black text-slate-400 text-uppercase"><?= $row['tahun_daftar'] ?></td>
                                    <td>
                                        <span class="badge-custom badge-green">
                                            <?= $row['status_startup'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="animate-pulse rounded-circle" style="width:6px;height:6px;background:var(--primary)"></div>
                                            <span class="text-xxs fw-black text-uppercase tracking-widest" style="color:var(--primary)"><?= $row['status_ajuan'] ?></span>
                                        </div>
                                    </td>
                                    <td id="action-<?= $row['id_startup'] ?>">
                                        <button onclick="toggleAction('<?= $row['uuid_startup'] ?>', <?= $row['id_startup'] ?>, this)" class="btn-action">
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9l-2-2H5a2 2 0 00-2 2v12z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v4m0 0l-2-2m2 2l2-2" />
                                                </svg>
                                            </div>
                                            <h3>DATA BELUM TERSEDIA</h3>
                                            <p>Saat ini basis data startup Anda masih kosong.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= view('Partials/v_footer') ?>
        </main>
    </div>

    <!-- DROPDOWN PORTAL -->
    <div id="dropdown-portal" class="dropdown-portal"></div>

    <form id="post-edit-form" action="<?= base_url('edit-startup') ?>" method="post" style="display:none;">
        <input type="hidden" name="id_startup" id="post-id-startup">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const portal = document.getElementById('dropdown-portal');
        let activeId = null;

        function toggleAction(uuid, numeric_id, btn) {
            if (activeId === uuid && portal.style.display !== 'none') {
                portal.style.display = 'none';
                activeId = null;
                return;
            }
            activeId = uuid;
            portal.innerHTML = `
                <a href="<?= base_url('detail') ?>/${uuid}">DETAIL DATA</a>
                <button onclick="submitEdit(${numeric_id})">EDIT DATA</button>
            `;

            portal.style.visibility = 'hidden';
            portal.style.display = 'block';
            const dropH = portal.offsetHeight;
            portal.style.display = 'none';
            portal.style.visibility = '';

            const rect = btn.getBoundingClientRect();
            const top = (rect.bottom + dropH > window.innerHeight)
                ? rect.top - dropH - 4
                : rect.bottom + 4;

            portal.style.top  = top + 'px';
            portal.style.left = (rect.right - 192) + 'px';
            portal.style.display = 'block';
        }

        function submitEdit(id) {
            document.getElementById('post-id-startup').value = id;
            document.getElementById('post-edit-form').submit();
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('[id^="action-"]') && !portal.contains(e.target)) {
                portal.style.display = 'none';
                activeId = null;
            }
        });

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'HAPUS STARTUP?',
                text: "Anda akan menghapus data " + name + " secara permanen dari sistem.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'YA, HAPUS!',
                cancelButtonText: 'BATAL',
                reverseButtons: true,
                showClass: { popup: 'swal2-show', backdrop: 'swal2-backdrop-show' },
                hideClass: { popup: 'swal2-hide', backdrop: 'swal2-backdrop-hide' },
                customClass: {
                    popup: 'rounded-4 p-4',
                    title: 'fw-black text-uppercase',
                    htmlContainer: 'text-muted text-uppercase small',
                    confirmButton: 'btn btn-danger px-4 py-2 fw-bold text-uppercase small',
                    cancelButton: 'btn btn-light px-4 py-2 fw-bold text-uppercase small text-muted'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // MENGGUNAKAN JQUERY AJAX
                    $.ajax({
                        url: '<?= base_url('delete-startup') ?>/' + id,
                        type: 'GET', // Aturannya GET seperti route sekarang
                        dataType: 'json',
                        success: function(response) {
                            if(response.status === 'success') {
                                // Tampilkan notifikasi
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1000,
                                    customClass: {
                                        popup: 'rounded-4 p-4',
                                        title: 'fw-black text-uppercase',
                                        htmlContainer: 'text-muted text-uppercase small'
                                    }
                                });
                                // Hapus baris dari tabel agar tidak perlu reload
                                $('#row-' + id).fadeOut(500, function(){ $(this).remove(); });
                            } else {
                                Swal.fire('Error', 'Gagal menghapus data', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                        }
                    });
                }
            })
        }

        // Notifikasi Flashdata
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL!',
                text: '<?= session()->getFlashdata('success') ?>',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                showClass: { popup: 'swal2-show', backdrop: 'swal2-backdrop-show' },
                hideClass: { popup: 'swal2-hide', backdrop: 'swal2-backdrop-hide' },
                customClass: {
                    popup: 'rounded-4 p-4',
                    title: 'fw-black text-uppercase',
                    htmlContainer: 'text-muted text-uppercase small'
                }
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'GAGAL!',
                text: '<?= session()->getFlashdata('error') ?>',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                showClass: { popup: 'swal2-show', backdrop: 'swal2-backdrop-show' },
                hideClass: { popup: 'swal2-hide', backdrop: 'swal2-backdrop-hide' },
                customClass: {
                    popup: 'rounded-4 p-4',
                    title: 'fw-black text-uppercase',
                    htmlContainer: 'text-muted text-uppercase small'
                }
            });
        <?php endif; ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>
