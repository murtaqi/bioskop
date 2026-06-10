<?php

    class Pemesanan extends Controller {
        public function __construct() {
            if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'customer') {
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }
        }

        public function pesan() {
            if (!isset($_POST['id_jadwal']) || !isset($_POST['nomor_kursi']) || empty($_POST['nomor_kursi'])) {
                Flasher::setFlash('Pilih minimal satu kursi untuk memesan tiket', 'danger');
                header('Location: ' . BASEURL . '/customer');
                exit;
            }

            $id_jadwal = $_POST['id_jadwal'];
            $seats = is_array($_POST['nomor_kursi']) ? $_POST['nomor_kursi'] : explode(',', $_POST['nomor_kursi']);
            $seats = array_filter(array_map('trim', $seats));

            if (empty($seats)) {
                Flasher::setFlash('Silakan pilih setidaknya satu kursi', 'danger');
                header('Location: ' . BASEURL . '/customer/pilih_kursi/' . $id_jadwal);
                exit;
            }

            $jadwal = $this->model('Jadwal_model')->getJadwalById($id_jadwal);
            if (!$jadwal) {
                Flasher::setFlash('Jadwal tayang tidak valid', 'danger');
                header('Location: ' . BASEURL . '/customer');
                exit;
            }

            // Verify availability
            $booked_seats = $this->model('Pemesanan_model')->getKursiDipesan($id_jadwal);
            foreach ($seats as $seat) {
                if (in_array($seat, $booked_seats)) {
                    Flasher::setFlash('Kursi ' . $seat . ' sudah dipesan, silakan pilih kursi lain', 'danger');
                    header('Location: ' . BASEURL . '/customer/pilih_kursi/' . $id_jadwal);
                    exit;
                }
            }

            $total_harga = count($seats) * $jadwal['harga_tiket'];
            $id_user = $_SESSION['id_user'];

            $id_pemesanan = $this->model('Pemesanan_model')->buatPemesanan($id_user, $id_jadwal, $total_harga, $seats);

            if ($id_pemesanan) {
                Flasher::setFlash('Pemesanan berhasil dibuat! Selesaikan pembayaran di kasir.', 'success');
                header('Location: ' . BASEURL . '/customer/riwayat');
                exit;
            } else {
                Flasher::setFlash('Pemesanan tiket gagal diproses', 'danger');
                header('Location: ' . BASEURL . '/customer/pilih_kursi/' . $id_jadwal);
                exit;
            }
        }
    }
