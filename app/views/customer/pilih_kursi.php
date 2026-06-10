<?php 
    $j = $data['jadwal'];
    $booked = $data['kursi_dipesan'];
    $price = $j['harga_tiket'];
?>

<div class="glass-panel" style="margin-bottom: 2rem;">
    <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
        <a href="<?= BASEURL ?>/customer" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h2 style="margin: 0; font-size: 1.6rem; font-weight: 700; color: var(--primary);">Pilih Kursi Bioskop</h2>
    </div>
</div>

<div class="seat-selection-wrapper">
    <!-- Theater Hall Column -->
    <div class="glass-panel theater-hall">
        <!-- Screen visualizer -->
        <div class="screen-container">
            <div class="screen"></div>
            <div class="screen-text">LAYAR UTAMA</div>
        </div>

        <!-- Seat layout grid -->
        <div class="seats-grid">
            <?php 
            $rows = ['A', 'B', 'C', 'D', 'E'];
            $cols = 8;
            
            foreach ($rows as $row) : 
            ?>
                <div class="seat-row">
                    <span class="row-label"><?= $row ?></span>
                    
                    <?php 
                    for ($c = 1; $c <= $cols; $c++) : 
                        $seatId = $row . $c;
                        $isBooked = in_array($seatId, $booked);
                        $class = $isBooked ? 'seat booked' : 'seat';
                    ?>
                        <div class="<?= $class ?>" data-seat="<?= $seatId ?>">
                            <?= $c ?>
                        </div>
                    <?php endfor; ?>
                    
                    <span class="row-label"><?= $row ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Legend -->
        <div class="legend-container">
            <div class="legend-item">
                <div class="legend-color available"></div>
                <span>Tersedia</span>
            </div>
            <div class="legend-item">
                <div class="legend-color selected"></div>
                <span>Dipilih</span>
            </div>
            <div class="legend-item">
                <div class="legend-color booked"></div>
                <span>Sudah Dipesan</span>
            </div>
        </div>
    </div>

    <!-- Booking Summary Sidebar Column -->
    <div class="glass-panel checkout-card">
        <h3 class="summary-title"><i class="fas fa-ticket-alt"></i> Detail Pemesanan</h3>
        
        <div class="summary-details">
            <div class="summary-row">
                <span class="summary-label">Film:</span>
                <span class="summary-value" style="font-weight: 700; color: #fff;"><?= htmlspecialchars($j['judul']) ?></span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Genre:</span>
                <span class="summary-value"><?= htmlspecialchars($j['genre']) ?></span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Tanggal:</span>
                <span class="summary-value"><?= date('d F Y', strtotime($j['tanggal_tayang'])) ?></span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Jam Tayang:</span>
                <span class="summary-value"><?= date('H:i', strtotime($j['jam_tayang'])) ?> WIB</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Harga Tiket:</span>
                <span class="summary-value" id="ticket-price-display">Rp <?= number_format($price, 0, ',', '.') ?></span>
            </div>
            <div class="summary-row" style="flex-direction: column; gap: 0.25rem;">
                <span class="summary-label">Kursi Terpilih:</span>
                <div class="selected-seats-badge-list" id="selected-seats-display">
                    <span style="color: var(--text-muted); font-size: 0.9rem; font-style: italic;">Belum ada kursi dipilih</span>
                </div>
            </div>
            <div class="summary-row total">
                <span class="summary-label">Total Harga:</span>
                <span class="summary-value" id="total-price-display">Rp 0</span>
            </div>
        </div>

        <form action="<?= BASEURL ?>/pemesanan/pesan" method="POST" id="booking-form" data-ticket-price="<?= $price ?>">
            <input type="hidden" name="id_jadwal" value="<?= $j['id_jadwal'] ?>">
            <!-- Selected seats passed as a comma-separated string -->
            <input type="hidden" name="nomor_kursi" id="nomor_kursi_input" value="">
            
            <button type="submit" class="btn btn-primary" style="width: 100%;" id="btn-submit-booking" disabled>
                <i class="fas fa-shopping-cart"></i> Pesan Sekarang
            </button>
        </form>
    </div>
</div>

<script src="<?= BASEURL ?>/js/pilih_kursi.js"></script>

