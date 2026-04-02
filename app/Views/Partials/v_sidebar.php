<!-- SIDEBAR: Dynamic Active Menu with Cut-out Illusion (Bootstrap Version) -->
<?php 
    $uri = service('uri');
    $currentPage = $uri->getSegment(1);
?>

<aside id="mainSidebar" class="sidebar">
    
    <!-- BRAND / LOGO -->
    <div class="sidebar-brand">
        <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK">
    </div>

    <!-- BODY SIDEBAR -->
    <div class="sidebar-body">
        
        <nav class="sidebar-nav">
            
            <!-- Link Dashboard -->
            <div onclick="window.location.href='<?= base_url('dashboard') ?>'" 
                 class="nav-link-item <?= ($currentPage == 'dashboard') ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="nav-label">Dashboard</span>
            </div>

            <!-- Link Data Startup -->
            <div onclick="window.location.href='<?= base_url('data-startup') ?>'" 
                 class="nav-link-item <?= ($currentPage == 'data-startup') ? 'nav-active' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="nav-label">Data Startup</span>
            </div>          
        </nav>

        <!-- Footer Sidebar -->
        <div class="sidebar-footer">
            SIMIK Integrated System
        </div>
        
    </div>
</aside>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const isFirstLogin = sessionStorage.getItem('isFirstLogin');
        const sidebar = document.getElementById('mainSidebar');
        
        if (isFirstLogin) {
            sidebar.classList.add('sidebar-entrance');
            sessionStorage.removeItem('isFirstLogin');
        }
    });
</script>
