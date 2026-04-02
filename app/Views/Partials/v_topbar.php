<!-- TOPBAR: Bootstrap Version -->
<?php 
    $uri = service('uri');
    $currentPage = $uri->getSegment(1);
?>
<header class="topbar">
    
    <!-- BRAND LOGO (Hanya muncul di halaman Tambah/Edit Startup) -->
    <div class="topbar-brand">
        <?php if ($currentPage == 'tambah-startup' || $currentPage == 'edit-startup'): ?>
            <img src="<?= base_url('img/logo-dkst.png') ?>" alt="Logo SIMIK">
        <?php endif; ?>
    </div>

    <!-- SPACER -->
    <div class="flex-grow-1"></div>

    <!-- ICONS & PROFILE -->
    <div class="topbar-actions">
        <div class="d-none d-md-flex align-items-center gap-1">
            <button class="topbar-icon-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
        </div>

        <div class="position-relative ms-2" id="profileDropdownContainer">
            <button onclick="toggleDropdown()" class="profile-trigger">
                <div class="profile-avatar">
                    <span>J</span>
                </div>
                <div class="profile-info d-none d-sm-block text-start">
                    <div class="profile-name">Suryaa</div>
                    <div class="profile-role">Admin</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;color:var(--slate-400)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Logout Dropdown -->
            <div id="logoutDropdown" class="profile-dropdown">
                <div class="profile-dropdown-header">
                    <p class="label mb-1">Akun Anda</p>
                    <p class="email mb-0">Surya@startup.itb.ac.id</p>
                </div>
                <div class="p-2 border-top" style="border-color: var(--slate-50) !important">
                    <button onclick="window.location.href='<?= base_url('/') ?>'" class="logout-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
        d.classList.toggle('show');
    }
    window.addEventListener('click', function(e) {
        const c = document.getElementById('profileDropdownContainer');
        const d = document.getElementById('logoutDropdown');
        if (!c.contains(e.target)) d.classList.remove('show');
    });
</script>
