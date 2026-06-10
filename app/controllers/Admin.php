<?php

    class Admin extends Controller {
        public function __construct() {
            if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }
        }

        public function index() {
            $data['judul'] = 'Dashboard Admin';
            $data['pemesanan'] = $this->model('Pemesanan_model')->getAllPemesanan();

            $this->view('templates/header', $data);
            $this->view('admin/index', $data);
            $this->view('templates/footer');
        }

        public function konfirmasi($id_pemesanan) {
            if ($this->model('Pemesanan_model')->updateStatusBayar($id_pemesanan, 'Lunas') > 0) {
                Flasher::setFlash('Pembayaran berhasil dikonfirmasi!', 'success');
            } else {
                Flasher::setFlash('Gagal mengkonfirmasi pembayaran.', 'danger');
            }
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }
