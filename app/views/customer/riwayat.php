<div class="history-wrapper">
    <div class="section-title">
        <i class="fas fa-history"></i> Tiket <span>Saya</span>
    </div>

    <?php if (empty($data['pemesanan'])) : ?>
        <div class="glass-panel" style="text-align: center; padding: 3rem;">
            <i class="fas fa-ticket-alt" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Anda belum pernah memesan tiket. Yuk, cari film menarik untuk ditonton!</p>
            <a href="<?= BASEURL ?>/customer" class="btn btn-primary" style="margin-top: 1.5rem;">
                <i class="fas fa-search"></i> Telusuri Film
            </a>
        </div>
    <?php else : ?>
        <div class="history-list">
            <?php foreach ($data['pemesanan'] as $p) : ?>
                <?php 
                    $isPaid = $p['status_bayar'] == 'Lunas';
                    $cardClass = $isPaid ? 'receipt-card lunas' : 'receipt-card belum-lunas';
                    $badgeClass = $isPaid ? 'payment-badge lunas' : 'payment-badge belum-lunas';
                    $statusIcon = $isPaid ? 'check-circle' : 'hourglass-half';
                ?>
                <div class="<?= $cardClass ?>">
                    <div class="receipt-header">
                        <span class="receipt-id">KODE BOOKING: <strong style="color: var(--primary); font-size: 1rem;"><?= $p['id_pemesanan'] ?></strong></span>
                        <h3 class="receipt-movie-title"><?= htmlspecialchars($p['judul']) ?></h3>
                        
                        <div class="receipt-info">
                            <span><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($p['tanggal_tayang'])) ?></span>
                            <span><i class="far fa-clock"></i> <?= date('H:i', strtotime($p['jam_tayang'])) ?> WIB</span>
                            <span><i class="fas fa-ticket-alt"></i> <?= count($p['seats']) ?> Tiket</span>
                        </div>
                        
                        <div class="receipt-seats">
                            <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nomor Kursi:</span>
                            <div class="selected-seats-badge-list">
                                <?php foreach ($p['seats'] as $seat) : ?>
                                    <span class="seat-badge"><?= $seat ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="receipt-amount-status">
                        <div style="text-align: right;">
                            <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Total Tagihan</span>
                            <span class="receipt-price">Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></span>
                        </div>
                        
                        <div style="text-align: right;">
                            <span class="<?= $badgeClass ?>">
                                <i class="fas fa-<?= $statusIcon ?>"></i> <?= $p['status_bayar'] ?>
                            </span>
                            
                            <?php if (!$isPaid) : ?>
                                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.4rem; max-width: 200px; line-height: 1.2;">
                                    Tunjukkan kode booking ke kasir untuk melakukan pembayaran.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
