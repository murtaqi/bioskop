<?php
    $bookings = $data['pemesanan'];
    
    // Calculate dashboard statistics
    $totalBookings = count($bookings);
    $totalRevenue = 0;
    $unpaidCount = 0;
    $paidCount = 0;
    
    foreach ($bookings as $b) {
        if ($b['status_bayar'] == 'Lunas') {
            $totalRevenue += $b['total_harga'];
            $paidCount++;
        } else {
            $unpaidCount++;
        }
    }
?>

<div class="dashboard-wrapper">
    <div class="section-title">
        <i class="fas fa-chart-line"></i> Dashboard <span>Admin</span>
    </div>

    <!-- Summary Tiles -->
    <div class="dashboard-summary-grid">
        <div class="summary-tile primary animate-fade-in">
            <div class="summary-tile-data">
                <h4>Total Transaksi</h4>
                <p><?= $totalBookings ?></p>
            </div>
            <i class="fas fa-shopping-cart summary-tile-icon"></i>
        </div>

        <div class="summary-tile success animate-fade-in">
            <div class="summary-tile-data">
                <h4>Total Pendapatan</h4>
                <p>Rp <?= number_format($totalRevenue, 0, ',', '.') ?></p>
            </div>
            <i class="fas fa-wallet summary-tile-icon"></i>
        </div>

        <div class="summary-tile accent animate-fade-in">
            <div class="summary-tile-data">
                <h4>Tiket Lunas</h4>
                <p><?= $paidCount ?></p>
            </div>
            <i class="fas fa-ticket-alt summary-tile-icon"></i>
        </div>

        <div class="summary-tile danger animate-fade-in">
            <div class="summary-tile-data">
                <h4>Belum Bayar</h4>
                <p><?= $unpaidCount ?></p>
            </div>
            <i class="fas fa-clock summary-tile-icon"></i>
        </div>
    </div>

    <!-- Bookings Listing Table -->
    <div class="glass-panel">
        <h3 style="margin-bottom: 1rem; font-weight: 700; font-size: 1.3rem;"><i class="fas fa-list"></i> Daftar Pemesanan Tiket</h3>
        
        <?php if (empty($bookings)) : ?>
            <p style="color: var(--text-muted); text-align: center; padding: 2rem;">Belum ada riwayat pemesanan dari pelanggan.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Kode Booking</th>
                            <th>Pelanggan</th>
                            <th>Film</th>
                            <th>Jadwal Tayang</th>
                            <th>Kursi</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $b) : ?>
                            <?php 
                                $isPaid = $b['status_bayar'] == 'Lunas';
                                $badgeClass = $isPaid ? 'payment-badge lunas' : 'payment-badge belum-lunas';
                            ?>
                            <tr>
                                <td><strong style="color: var(--primary);"><?= $b['id_pemesanan'] ?></strong></td>
                                <td><?= htmlspecialchars($b['nama_user']) ?></td>
                                <td><strong><?= htmlspecialchars($b['judul']) ?></strong></td>
                                <td>
                                    <?= date('d M Y', strtotime($b['tanggal_tayang'])) ?><br>
                                    <small style="color: var(--text-muted);"><?= date('H:i', strtotime($b['jam_tayang'])) ?> WIB</small>
                                </td>
                                <td>
                                    <div class="selected-seats-badge-list" style="max-width: 150px;">
                                        <?php foreach ($b['seats'] as $seat) : ?>
                                            <span class="seat-badge" style="font-size: 0.75rem; padding: 0.1rem 0.3rem;"><?= $seat ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td>Rp <?= number_format($b['total_harga'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="<?= $badgeClass ?>">
                                        <?= $b['status_bayar'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!$isPaid) : ?>
                                        <a href="<?= BASEURL ?>/admin/konfirmasi/<?= $b['id_pemesanan'] ?>" class="btn btn-primary btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran booking ini?')">
                                            <i class="fas fa-check"></i> Konfirmasi Bayar
                                        </a>
                                    <?php else : ?>
                                        <span style="color: var(--success); font-weight: 600; font-size: 0.85rem;"><i class="fas fa-check-double"></i> Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
