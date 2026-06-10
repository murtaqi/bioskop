<div class="auth-wrapper">
    <div class="glass-panel auth-card animate-fade-in">
        <div class="auth-header">
            <h2>Masuk</h2>
            <p>Silakan masuk ke akun CinemaTix Anda</p>
        </div>
        
        <form action="<?= BASEURL ?>/auth/valid" method="POST">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required placeholder="Masukkan username Anda" autofocus autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Masukkan password Anda">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Belum punya akun? <a href="<?= BASEURL ?>/auth/register">Daftar Sekarang</a></p>
        </div>
    </div>
</div>
