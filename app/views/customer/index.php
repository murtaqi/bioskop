<div class="catalog-wrapper">
    <div class="section-title">
        <i class="fas fa-film"></i> Sedang <span>Tayang</span>
    </div>

    <?php if (empty($data['film'])) : ?>
        <div class="glass-panel" style="text-align: center; padding: 3rem;">
            <i class="fas fa-video-slash" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Belum ada film yang dijadwalkan saat ini. Silakan kembali lagi nanti!</p>
        </div>
    <?php else : ?>
        <div class="movie-grid">
            <?php foreach ($data['film'] as $f) : ?>
                <div class="movie-card">
                    <?php if (!empty($f['foto']) && file_exists(dirname(dirname(dirname(__DIR__))) . '/public/img/' . $f['foto'])) : ?>
                        <img src="<?= BASEURL ?>/img/<?= $f['foto'] ?>" alt="<?= htmlspecialchars($f['judul']) ?>" class="movie-poster">
                    <?php else : ?>
                        <!-- Dynamic Glowing Poster Placeholder -->
                        <div class="movie-poster-placeholder">
                            <i class="fas fa-film"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="movie-body">
                        <h3 class="movie-title"><?= htmlspecialchars($f['judul']) ?></h3>
                        
                        <div class="movie-meta">
                            <span class="meta-item"><i class="fas fa-tags"></i> <?= htmlspecialchars($f['genre']) ?></span>
                            <span class="meta-item"><i class="fas fa-clock"></i> <?= htmlspecialchars($f['durasi_menit']) ?> Menit</span>
                        </div>

                        <div class="showtimes-container">
                            <h4 class="showtimes-title">Pilih Jam Tayang & Tiket</h4>
                            
                            <?php 
                            // Filter schedules for current film
                            $schedules = [];
                            foreach ($data['jadwal'] as $j) {
                                if ($j['id_film'] == $f['id_film']) {
                                    $schedules[] = $j;
                                }
                            }
                            ?>

                            <?php if (empty($schedules)) : ?>
                                <p style="font-size: 0.85rem; color: var(--text-muted); font-style: italic;">Tidak ada jadwal tayang</p>
                            <?php else : ?>
                                <div class="showtimes-list">
                                    <?php foreach ($schedules as $sch) : ?>
                                        <?php 
                                            // Format date and time
                                            $date = date('d M', strtotime($sch['tanggal_tayang']));
                                            $time = date('H:i', strtotime($sch['jam_tayang']));
                                            $price = 'Rp ' . number_format($sch['harga_tiket'], 0, ',', '.');
                                            
                                            // Determine link destination based on login state
                                            $link = isset($_SESSION['login']) ? BASEURL . '/customer/pilih_kursi/' . $sch['id_jadwal'] : BASEURL . '/auth/login';
                                        ?>
                                        <a href="<?= $link ?>" class="showtime-badge">
                                            <span class="date"><?= $date ?> - <strong><?= $time ?></strong></span>
                                            <span class="price"><?= $price ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
