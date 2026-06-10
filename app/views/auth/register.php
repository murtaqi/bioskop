<div class="auth-wrapper">
    <div class="glass-panel auth-card animate-fade-in">
        <div class="auth-header">
            <h2>Daftar Akun</h2>
            <p>Buat akun baru untuk memesan tiket bioskop</p>
        </div>
        
        <form action="<?= BASEURL ?>/auth/authenticate" method="POST">
            <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" required placeholder="Nama Lengkap Anda" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="no_telp" class="form-label">Nomor Telepon</label>
                <input type="tel" id="no_telp" name="no_telp" class="form-control" required placeholder="Contoh: 08123456789" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required placeholder="Pilih username unik" autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
            </div>

            <div class="form-group">
                <label for="password2" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password2" name="password2" class="form-control" required placeholder="Ulangi password Anda">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                <i class="fas fa-user-plus"></i> Daftar Akun
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Sudah punya akun? <a href="<?= BASEURL ?>/auth/login">Masuk disini</a></p>
        </div>
    </div>
</div>
