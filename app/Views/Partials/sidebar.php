<!-- SIDEBAR: Dynamic Active Menu with Cut-out Illusion -->
<style>
    .nav-active {
        background-color: white !important;
        color: #1926A6 !important;
        border-radius: 50px 0 0 50px;
        position: relative;
        margin-right: -24px;
        padding-left: 32px !important;
        box-shadow: 15px 0 0 0 white;
    }

    .nav-active::before {
        content: "";
        position: absolute;
        top: -30px;
        right: 0;
        width: 30px;
        height: 30px;
        background-color: transparent;
        border-bottom-right-radius: 30px;
        box-shadow: 15px 15px 0 15px white;
    }

    .nav-active::after {
        content: "";
        position: absolute;
        bottom: -30px;
        right: 0;
        width: 30px;
        height: 30px;
        background-color: transparent;
        border-top-right-radius: 30px;
        box-shadow: 15px -15px 0 15px white;
    }

    .nav-item-hover:hover:not(.nav-active) {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    /* ANIMASI SIDEBAR ENTRANCE */
    @keyframes sidebarSlideIn {
        from { transform: translateX(-100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .sidebar-entrance {
        animation: sidebarSlideIn 0.8s cubic-bezier(0.7, 0, 0.3, 1) forwards;
    }
</style>

<?php 
    $uri = service('uri');
    $currentPage = $uri->getSegment(1); // Mendapatkan segment pertama dari URL (dashboard/data-startup)
?>

<aside id="mainSidebar" class="w-72 flex flex-col min-h-screen bg-white relative z-50 transition-all duration-300">
    
    <!-- BRAND / LOGO (Area Putih) -->
    <div class="h-20 flex items-center px-8 bg-white">
        <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK" class="h-12 w-auto">
    </div>

    <!-- BODY SIDEBAR (Warna #0061FF) -->
    <div class="flex-1 bg-[#0061FF] text-white rounded-tr-[45px] flex flex-col px-6 py-10 relative overflow-visible">
        
        <nav class="flex-1 space-y-6 mt-4 overflow-visible">
            
            <!-- Link Dashboard -->
            <div onclick="window.location.href='<?= base_url('dashboard') ?>'" 
                 class="<?= ($currentPage == 'dashboard') ? 'nav-active' : 'nav-item-hover text-white/50' ?> flex items-center gap-4 py-4 px-5 cursor-pointer transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?= ($currentPage == 'dashboard') ? 'text-[#0061FF]' : 'text-white/50 group-hover:text-white' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-extrabold text-[12px] uppercase tracking-widest leading-none <?= ($currentPage == 'dashboard') ? 'text-[#0061FF]' : '' ?>">Dashboard</span>
            </div>

            <!-- Link Data Startup -->
            <div onclick="window.location.href='<?= base_url('data-startup') ?>'" 
                 class="<?= ($currentPage == 'data-startup') ? 'nav-active' : 'nav-item-hover text-white/50' ?> flex items-center gap-4 py-4 px-5 cursor-pointer transition-all duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?= ($currentPage == 'data-startup') ? 'text-[#0061FF]' : 'text-white/50 group-hover:text-white' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="font-bold text-[11px] tracking-widest <?= ($currentPage == 'data-startup') ? 'text-[#0061FF]' : '' ?>">Data Startup</span>
            </div>          
        </nav>

        <!-- Footer Sidebar -->
        <div class="mt-auto opacity-30 pt-4 border-t border-white/10 text-center">
            <span class="text-[9px] font-black uppercase tracking-[0.3em]">SIMIK Integrated System</span>
        </div>
        
    </div>
</aside>

<script>
    // Hanya picu animasi sidebar jika dideteksi baru saja login
    document.addEventListener("DOMContentLoaded", function() {
        const isFirstLogin = sessionStorage.getItem('isFirstLogin');
        const sidebar = document.getElementById('mainSidebar');
        
        if (isFirstLogin) {
            // Berikan class animasi secara dinamis
            sidebar.classList.add('sidebar-entrance');
            // Hapus flag setelah animasi dipicu
            sessionStorage.removeItem('isFirstLogin');
        }
    });
</script>
