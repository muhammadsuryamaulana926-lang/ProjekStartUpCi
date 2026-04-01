<!-- TOPBAR: Refined Logic for Logo & Search Display -->
<?php 
    $uri = service('uri');
    $currentPage = $uri->getSegment(1);
?>
<header class="h-20 bg-white flex items-center justify-between px-10 border-b border-slate-50 relative z-40">
    
    <!-- BRAND LOGO (Hanya muncul di halaman Tambah Startup / No Sidebar) -->
    <div class="w-48 flex items-center">
        <?php if ($currentPage == 'tambah-startup' || $currentPage == 'edit-startup'): ?>
            <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK" class="h-10 w-auto">
        <?php endif; ?>
    </div>

    <!-- EMPTY SPACE (Replacing Search Bar) -->
    <div class="flex-1"></div>

    <!-- ICONS & PROFILE (Right) -->
    <div class="flex items-center gap-4">
        <div class="hidden md:flex items-center gap-1 text-slate-300">
            <button class="p-2.5 text-slate-400 hover:text-[#0061FF] hover:bg-slate-50 rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
        </div>

        <div class="relative ml-2" id="profileDropdownContainer">
            <button onclick="toggleDropdown()" class="flex items-center gap-3 p-1.5 pr-4 hover:bg-slate-50 rounded-full transition-all">
                <div class="w-10 h-10 bg-[#0061FF] rounded-full flex items-center justify-center text-white font-black shadow-lg border-2 border-white">
                    <span>J</span>
                </div>
                <div class="hidden sm:block text-left">
                    <div class="text-[11px] font-black text-slate-800 uppercase tracking-wider">Suryaa</div>
                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-tight">Admin</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Logout Dropdown ... (tetap seperti sebelumnya) -->
            <div id="logoutDropdown" class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-50 overflow-hidden transform transition-all duration-200 origin-top-right z-[100]">
                <div class="p-4 border-b border-slate-50 bg-slate-50/50">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Akun Anda</p>
                    <p class="text-xs font-bold text-slate-800">Surya@startup.itb.ac.id</p>
                </div>
                <div class="p-2 border-t border-slate-50">
                    <button onclick="window.location.href='<?= base_url('/') ?>'" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-black text-red-500 hover:bg-red-50 rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleDropdown() {
        const d = document.getElementById('logoutDropdown');
        d.classList.toggle('hidden');
    }
    window.addEventListener('click', function(e) {
        const c = document.getElementById('profileDropdownContainer');
        const d = document.getElementById('logoutDropdown');
        if (!c.contains(e.target)) d.classList.add('hidden');
    });
</script>
