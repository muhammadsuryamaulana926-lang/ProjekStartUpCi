<style>
/* Desain UI: Kertas HVS Putih */
body {
    background-color: #f5f5f5 !important;
}
.paper-wrapper {
    max-width: 600px;
    margin: 40px auto;
}
.paper-form {
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 40px;
}
.paper-title {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    margin-bottom: 25px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}
.form-label {
    font-weight: 600;
    color: #555;
    margin-bottom: 8px;
}
.form-control {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 10px 15px;
    transition: all 0.3s;
}
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.btn-modern {
    padding: 10px 24px;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.kelas-subtitle {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 20px;
}
</style>

<div class="container-fluid" style="background-color: #f5f5f5; min-h-screen: 100vh; padding-bottom: 50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title">Tambah Peserta Manual</h2>
            <div class="kelas-subtitle">Program: <strong><?= esc($program['nama_program']) ?></strong></div>
            
            <form action="<?= base_url('peserta_program/simpan_peserta_program') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_program" value="<?= esc($program['id_program']) ?>">
                
                <div class="mb-4">
                    <label class="form-label">Nama Lengkap Peserta <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_peserta" required placeholder="Masukkan nama peserta...">
                    <small class="text-muted mt-2 d-block">Admin dapat menambahkan nama secara manual ke dalam program ini.</small>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="<?= base_url('program/detail_program/' . $program['id_program']) ?>" class="btn btn-light btn-modern border">Batal</a>
                    <button type="submit" class="btn btn-primary btn-modern">Tambahkan Peserta</button>
                </div>
            </form>
        </div>
    </div>
</div>
