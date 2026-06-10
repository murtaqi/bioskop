<div class="admin-schedules-wrapper">
    <div class="section-title">
        <i class="fas fa-calendar-alt"></i> Kelola <span>Jadwal Tayang</span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
        <!-- Schedule List Table Column -->
        <div class="glass-panel">
            <h3 style="margin-bottom: 1rem; font-weight: 700; font-size: 1.3rem;"><i class="fas fa-list"></i> Daftar Jadwal</h3>
            
            <?php if (empty($data['jadwal'])) : ?>
                <p style="color: var(--text-muted); text-align: center; padding: 2rem;">Belum ada jadwal tayang yang ditambahkan.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>ID Jadwal</th>
                                <th>Film</th>
                                <th>Tanggal</th>
                                <th>Jam Tayang</th>
                                <th>Harga Tiket</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['jadwal'] as $j) : ?>
                                <tr>
                                    <td><strong style="color: var(--primary);"><?= $j['id_jadwal'] ?></strong></td>
                                    <td><strong><?= htmlspecialchars($j['judul']) ?></strong><br><small style="color: var(--text-muted);"><?= htmlspecialchars($j['genre']) ?></small></td>
                                    <td><?= date('d M Y', strtotime($j['tanggal_tayang'])) ?></td>
                                    <td><strong><?= date('H:i', strtotime($j['jam_tayang'])) ?> WIB</strong></td>
                                    <td>Rp <?= number_format($j['harga_tiket'], 0, ',', '.') ?></td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm" onclick="prepareEditJadwal(<?= htmlspecialchars(json_encode($j)) ?>)" style="padding: 0.3rem 0.6rem;">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <a href="<?= BASEURL ?>/jadwal/hapus/<?= $j['id_jadwal'] ?>" class="btn btn-danger btn-sm" style="padding: 0.3rem 0.6rem;" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Semua pemesanan terkait akan ikut terhapus!')">
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
            <h3 id="form-title" style="margin-bottom: 1.25rem; font-weight: 700; font-size: 1.3rem; color: var(--primary);">Tambah Jadwal Baru</h3>
            
            <?php if (empty($data['film'])) : ?>
                <p style="color: var(--danger); font-size: 0.9rem; font-style: italic;">Tambahkan film terlebih dahulu sebelum mengatur jadwal tayang!</p>
                <a href="<?= BASEURL ?>/film" class="btn btn-secondary btn-sm" style="width: 100%; margin-top: 1rem;"><i class="fas fa-film"></i> Kelola Film</a>
            <?php else : ?>
                <form action="<?= BASEURL ?>/jadwal/tambah" method="POST" id="jadwal-form">
                    <!-- ID Hidden Field for Edit mode -->
                    <input type="hidden" name="id_jadwal" id="input-id-jadwal" value="">
                    
                    <div class="form-group">
                        <label for="input-film" class="form-label">Pilih Film</label>
                        <select name="id_film" id="input-film" class="form-control" required style="background-color: #0f1624;">
                            <option value="">-- Pilih Film --</option>
                            <?php foreach ($data['film'] as $f) : ?>
                                <option value="<?= $f['id_film'] ?>"><?= htmlspecialchars($f['judul']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-tanggal" class="form-label">Tanggal Tayang</label>
                        <input type="date" name="tanggal_tayang" id="input-tanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="input-jam" class="form-label">Jam Tayang</label>
                        <input type="time" name="jam_tayang" id="input-jam" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="input-harga" class="form-label">Harga Tiket (Rp)</label>
                        <input type="number" name="harga_tiket" id="input-harga" class="form-control" required min="1000" step="500" placeholder="Contoh: 35000">
                    </div>

                    <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                        <button type="submit" class="btn btn-primary" id="btn-submit-form" style="flex: 1;">
                            <i class="fas fa-plus"></i> Tambah Jadwal
                        </button>
                        <button type="button" class="btn btn-secondary" id="btn-cancel-edit" style="display: none;" onclick="resetJadwalForm()">
                            Batal
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="<?= BASEURL ?>/js/jadwal.js"></script>

