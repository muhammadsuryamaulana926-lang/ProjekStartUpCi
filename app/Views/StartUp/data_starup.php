<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Startup - SIMIK</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <script src="<?= base_url('js/sweetalert2.min.js') ?>"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }</style>
</head>
<body class="bg-white text-slate-800 antialiased uppercase">
    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        <?= view('Partials/sidebar') ?>

        <main class="flex-1 flex flex-col min-w-0 bg-white relative">
            
            <!-- TOPBAR -->
            <?= view('Partials/topbar') ?>

            <!-- CONTENT -->
            <div class="flex-1 overflow-y-auto px-10 py-12">

                <!-- Page Header -->
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Data Startup</h2>
                        <p class="text-slate-400 text-[10px] uppercase font-black tracking-[0.3em] mt-2 border-l-4 border-[#0061FF] pl-4">Manajemen seluruh ekosistem startup</p>
                    </div>
                </div>
 
                <!-- TABLE SECTION -->
                <div class="bg-white rounded-none border border-slate-100 shadow-sm uppercase">
                    
                    <!-- Table Header Actions -->
                     <div class="px-10 py-8 flex justify-end bg-white border-b border-slate-100">
                         <div class="flex flex-col gap-4 w-max items-end">
                             <!-- Tombol Tambah -->
                             <button onclick="window.location.href='<?= base_url('tambah-startup') ?>'" class="w-44 px-7 py-3 bg-[#0061FF] text-white text-[9px] font-black uppercase tracking-[0.3em] rounded-none transition-all hover:bg-black">
                               + Tambah
                             </button>

                             <!-- Search Bar -->
                             <div class="w-60 relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 group-focus-within:text-[#0061FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" placeholder="CARI DATA STARTUP..." 
                                       class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-none focus:bg-white focus:border-[#0061FF] outline-none transition-all duration-300 font-bold text-slate-600 text-[9px] tracking-widest shadow-none">
                             </div>
                         </div>
                    </div>
 
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80">
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">No</th>
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">Nama Perusahaan</th>
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">Kluster</th>
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">Email</th>
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">No Whatsapp</th>
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">Tahun Daftar</th>
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">Status Startup</th>
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">Status Ajuan</th>
                                <th class="px-8 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <?php if(!empty($startups)): ?>
                                <?php foreach($startups as $i => $row): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-6 text-[10px] font-black text-slate-300"><?= $i + 1 ?></td>
                                    <td class="px-8 py-6">
                                        <span class="text-[11px] font-black text-slate-900 group-hover:text-[#0061FF] tracking-tight transition-colors uppercase"><?= $row['nama_perusahaan'] ?></span>
                                    </td>
                                    <td class="px-8 py-6 text-[10px] font-bold text-slate-500 lowercase font-bold font-bold"><?= $row['deskripsi_bidang_usaha'] ?? '-' ?></td>
                                    <td class="px-8 py-6 text-[10px] font-bold text-[#0061FF] lowercase font-bold font-bold uppercase"><?= $row['email_perusahaan'] ?></td>
                                    <td class="px-8 py-6 text-[10px] font-bold text-green-600 font-bold font-bold uppercase font-bold"><?= $row['nomor_whatsapp'] ?></td>
                                    <td class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase font-bold font-bold"><?= $row['tahun_daftar'] ?></td>
                                    <td class="px-8 py-6 uppercase font-bold">
                                        <span class="px-3 py-1 bg-green-50 text-green-600 text-[9px] font-black uppercase tracking-widest rounded-lg font-bold font-bold">
                                            <?= $row['status_startup'] ?>
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 uppercase font-bold uppercase font-bold uppercase font-bold">
                                         <div class="flex items-center gap-2 uppercase font-bold uppercase font-bold">
                                            <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse shadow-sm font-bold font-bold font-bold uppercase font-bold"></div>
                                            <span class="text-[9px] font-black text-blue-600 tracking-widest uppercase font-bold"><?= $row['status_ajuan'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6" id="action-<?= $row['id_startup'] ?>">
                                        <button onclick="toggleAction('<?= $row['uuid_startup'] ?>', <?= $row['id_startup'] ?>, this)" class="p-2 text-slate-300 hover:text-black rounded-xl transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="p-24 text-center uppercase">
                                        <div class="flex flex-col items-center justify-center py-10">
                                            <!-- Ikon Folder Kosong Premium -->
                                            <div class="w-28 h-28 bg-slate-50/50 rounded-[45px] flex items-center justify-center mb-8 shadow-inner border border-slate-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9l-2-2H5a2 2 0 00-2 2v12z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v4m0 0l-2-2m2 2l2-2" />
                                                </svg>
                                            </div>
                                            <!-- Teks Heading -->
                                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.4em] mb-3">DATA BELUM TERSEDIA</h3>
                                            <!-- Teks Deskripsi -->
                                            <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest leading-none">Saat ini basis data startup Anda masih kosong.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= view('Partials/footer') ?>
        </main>
    </div>

    <!-- DROPDOWN PORTAL langsung di body, di luar semua wrapper -->
    <div id="dropdown-portal" style="display:none; position:fixed; z-index:9999; width:192px;" class="bg-white rounded-2xl shadow-2xl p-2"></div>

    <form id="post-edit-form" action="<?= base_url('edit-startup') ?>" method="post" style="display:none;">
        <input type="hidden" name="id_startup" id="post-id-startup">
    </form>

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
                <a href="<?= base_url('detail') ?>/${uuid}" class="flex items-center gap-3 px-4 py-3 text-[10px] font-black text-slate-600 hover:bg-[#0061FF] hover:text-white rounded-xl transition-all tracking-widest">DETAIL DATA</a>
                <button onclick="submitEdit(${numeric_id})" class="w-full text-left flex items-center gap-3 px-4 py-3 text-[10px] font-black text-slate-600 hover:bg-green-600 hover:text-white rounded-xl transition-all tracking-widest">EDIT DATA</button>
            `;

            // Ukur tinggi asli
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
                customClass: {
                    popup: 'rounded-[20px] p-10',
                    title: 'text-sm font-black text-slate-900 tracking-[0.2em]',
                    htmlContainer: 'text-[11px] font-bold text-slate-400 uppercase tracking-widest',
                    confirmButton: 'px-8 py-3.5 text-[10px] font-black tracking-widest rounded-none shadow-xl shadow-red-500/20',
                    cancelButton: 'px-8 py-3.5 text-[10px] font-black tracking-widest text-slate-400 rounded-none'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('delete-startup') ?>/' + id;
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
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-[20px] p-10',
                    title: 'text-sm font-black text-slate-900 tracking-[0.2em]',
                    htmlContainer: 'text-[11px] font-bold text-slate-400 uppercase tracking-widest'
                }
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'GAGAL!',
                text: '<?= session()->getFlashdata('error') ?>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-[20px] p-10',
                    title: 'text-sm font-black text-slate-900 tracking-[0.2em]',
                    htmlContainer: 'text-[11px] font-bold text-slate-400 uppercase tracking-widest'
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>
