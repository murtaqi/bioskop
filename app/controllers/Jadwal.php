<?php

    class Jadwal extends Controller {
        public function __construct() {
            if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }
        }

        public function index() {
            $data['judul'] = 'Kelola Jadwal';
            $data['jadwal'] = $this->model('Jadwal_model')->getAllJadwal();
            $data['film'] = $this->model('Film_model')->getAllFilm();

            $this->view('templates/header', $data);
            $this->view('admin/jadwal', $data);
            $this->view('templates/footer');
        }

        public function tambah() {
            if ($this->model('Jadwal_model')->tambahJadwal($_POST) > 0) {
                Flasher::setFlash('Jadwal berhasil ditambahkan', 'success');
            } else {
                Flasher::setFlash('Jadwal gagal ditambahkan', 'danger');
            }
            header('Location: ' . BASEURL . '/jadwal');
            exit;
        }

        public function ubah() {
            if ($this->model('Jadwal_model')->ubahJadwal($_POST) > 0) {
                Flasher::setFlash('Jadwal berhasil diubah', 'success');
            } else {
                Flasher::setFlash('Jadwal gagal diubah', 'danger');
            }
            header('Location: ' . BASEURL . '/jadwal');
            exit;
        }

        public function hapus($id) {
            if ($this->model('Jadwal_model')->hapusJadwal($id) > 0) {
                Flasher::setFlash('Jadwal berhasil dihapus', 'success');
            } else {
                Flasher::setFlash('Jadwal gagal dihapus', 'danger');
            }
            header('Location: ' . BASEURL . '/jadwal');
            exit;
        }
    }
