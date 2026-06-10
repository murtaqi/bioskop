<?php

    class Customer extends Controller {
        public function __construct() {
            if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'customer') {
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }
        }

        public function index() {
            $data['judul'] = 'Bioskop - Dashboard';
            $data['film'] = $this->model('Film_model')->getAllFilm();
            $data['jadwal'] = $this->model('Jadwal_model')->getAllJadwal();

            $this->view('templates/header', $data);
            $this->view('customer/index', $data);
            $this->view('templates/footer');
        }

        public function pilih_kursi($id_jadwal) {
            $data['judul'] = 'Pilih Kursi Bioskop';
            $data['jadwal'] = $this->model('Jadwal_model')->getJadwalById($id_jadwal);

            if (!$data['jadwal']) {
                Flasher::setFlash('Jadwal tayang tidak ditemukan', 'danger');
                header('Location: ' . BASEURL . '/customer');
                exit;
            }

            $data['kursi_dipesan'] = $this->model('Pemesanan_model')->getKursiDipesan($id_jadwal);

            $this->view('templates/header', $data);
            $this->view('customer/pilih_kursi', $data);
            $this->view('templates/footer');
        }

        public function riwayat() {
            $data['judul'] = 'Riwayat Pemesanan Tiket';
            $data['pemesanan'] = $this->model('Pemesanan_model')->getPemesananByUser($_SESSION['id_user']);

            $this->view('templates/header', $data);
            $this->view('customer/riwayat', $data);
            $this->view('templates/footer');
        }
    }
