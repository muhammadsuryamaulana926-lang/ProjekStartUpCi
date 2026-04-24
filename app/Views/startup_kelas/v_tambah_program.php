<style>
body { background-color: #f5f5f5 !important; }
.paper-wrapper { max-width: 700px; margin: 40px auto; }
.paper-form { background-color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; border-radius: 8px; padding: 40px; }
.paper-title { font-size: 24px; font-weight: 700; color: #333; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
.form-label { font-weight: 600; color: #555; margin-bottom: 8px; }
.form-control, .form-select { border-radius: 6px; border: 1px solid #cbd5e1; padding: 10px 15px; transition: all 0.3s; }
.form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
.btn-modern { padding: 10px 24px; border-radius: 6px; font-weight: 600; transition: all 0.3s; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
</style>

<div class="container-fluid" style="background-color:#f5f5f5;padding-bottom:50px;">
    <div class="paper-wrapper">
        <div class="paper-form">
            <h2 class="paper-title">Tambah Program Baru</h2>
            <form action="<?= base_url('program/simpan_program') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Nama Program <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_program" required placeholder="Masukkan nama program, misal: Inkubasi Startup 2026">
                </div>
                <div class="mb-4">
                    <label class="form-label">Deskripsi Program</label>
                    <textarea class="form-control" name="deskripsi" rows="5" placeholder="Penjelasan singkat mengenai program..."></textarea>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('program') ?>" class="btn btn-light btn-modern border">Kembali</a>
                    <button type="submit" class="btn btn-primary btn-modern">Simpan Program</button>
                </div>
            </form>
        </div>
    </div>
</div>
