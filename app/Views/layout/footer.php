<?php
// Partial: Footer — penutup struktur HTML, dimuat di setiap halaman
?>
<footer class="app-footer">
    <!-- Teks hak cipta dan nama sistem -->
    <div class="d-flex align-items-center gap-2">
        <span class="copyright">Hak Cipta &copy; 2026 SIMIK DKST</span>
        <span class="copyright separator">&bull;</span>
        <span class="copyright sub">Manajemen Startup Terpadu</span>
    </div>
    <!-- Tautan navigasi footer -->
    <div class="footer-links">
        <a href="#">Bantuan</a>
        <a href="#">Kebijakan</a>
    </div>
</footer>

</div><!-- end app-main -->
</div><!-- end app-wrapper -->

<!-- JS Bootstrap untuk komponen interaktif (modal, dropdown, dll) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Helper global untuk confirm hapus pakai SweetAlert2
function swalConfirm(form) {
    Swal.fire({
        title: 'Yakin?',
        text: 'Data tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then(function(result) {
        if (result.isConfirmed) form.submit();
    });
    return false;
}
</script>
</body>
</html>
