<div class="admin-films-wrapper">
    <div class="section-title">
        <i class="fas fa-film"></i> Kelola <span>Film</span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
        <!-- Film List Table Column -->
        <div class="glass-panel">
            <h3 style="margin-bottom: 1rem; font-weight: 700; font-size: 1.3rem;"><i class="fas fa-list"></i> Daftar Film</h3>
            
            <?php if (empty($data['film'])) : ?>
                <p style="color: var(--text-muted); text-align: center; padding: 2rem;">Belum ada film yang ditambahkan.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>ID Film</th>
                                <th>Judul</th>
                                <th>Genre</th>
                                <th>Durasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['film'] as $f) : ?>
                                <tr>
                                    <td><strong style="color: var(--primary);"><?= $f['id_film'] ?></strong></td>
                                    <td><strong><?= htmlspecialchars($f['judul']) ?></strong></td>
                                    <td><?= htmlspecialchars($f['genre']) ?></td>
                                    <td><?= htmlspecialchars($f['durasi_menit']) ?> Menit</td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm" onclick="prepareEditFilm(<?= htmlspecialchars(json_encode($f)) ?>)" style="padding: 0.3rem 0.6rem;">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <a href="<?= BASEURL ?>/film/hapus/<?= $f['id_film'] ?>" class="btn btn-danger btn-sm" style="padding: 0.3rem 0.6rem;" onclick="return confirm('Apakah Anda yakin ingin menghapus film ini? Semua jadwal yang terkait juga akan dihapus!')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Add/Edit Form Column -->
        <div class="glass-panel" id="form-panel">
            <h3 id="form-title" style="margin-bottom: 1.25rem; font-weight: 700; font-size: 1.3rem; color: var(--primary);">Tambah Film Baru</h3>
            
            <form action="<?= BASEURL ?>/film/tambah" method="POST" id="film-form">
                <!-- ID Hidden Field for Edit mode -->
                <input type="hidden" name="id_film" id="input-id-film" value="">
                
                <div class="form-group">
                    <label for="input-judul" class="form-label">Judul Film</label>
                    <input type="text" name="judul" id="input-judul" class="form-control" required placeholder="Contoh: Avengers: Endgame" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="input-genre" class="form-label">Genre</label>
                    <input type="text" name="genre" id="input-genre" class="form-control" required placeholder="Contoh: Aksi, Sci-Fi" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="input-durasi" class="form-label">Durasi (Menit)</label>
                    <input type="number" name="durasi_menit" id="input-durasi" class="form-control" required min="1" placeholder="Contoh: 150">
                </div>

                <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" id="btn-submit-form" style="flex: 1;">
                        <i class="fas fa-plus"></i> Tambah Film
                    </button>
                    <button type="button" class="btn btn-secondary" id="btn-cancel-edit" style="display: none;" onclick="resetFilmForm()">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASEURL ?>/js/film.js"></script>

