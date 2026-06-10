<?php

    class Film extends Controller {
        public function __construct() {
            if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }
        }

        public function index() {
            $data['judul'] = 'Kelola Film';
            $data['film'] = $this->model('Film_model')->getAllFilm();
            $this->view('templates/header', $data);
            $this->view('admin/film', $data);
            $this->view('templates/footer');
        }

        public function tambah() {
            if ($this->model('Film_model')->tambahFilm($_POST) > 0) {
                Flasher::setFlash('Film berhasil ditambahkan', 'success');
            } else {
                Flasher::setFlash('Film gagal ditambahkan', 'danger');
            }
            header('Location: ' . BASEURL . '/film');
            exit;
        }

        public function ubah() {
            if ($this->model('Film_model')->ubahFilm($_POST) > 0) {
                Flasher::setFlash('Film berhasil diubah', 'success');
            } else {
                Flasher::setFlash('Film gagal diubah', 'danger');
            }
            header('Location: ' . BASEURL . '/film');
            exit;
        }

        public function hapus($id) {
            if ($this->model('Film_model')->hapusFilm($id) > 0) {
                Flasher::setFlash('Film berhasil dihapus', 'success');
            } else {
                Flasher::setFlash('Film gagal dihapus', 'danger');
            }
            header('Location: ' . BASEURL . '/film');
            exit;
        }
    }