<?php

    class Home extends Controller {
        public function index() {
            if (isset($_SESSION['login'])) {
                if ($_SESSION['role'] == 'admin') {
                    header('Location: ' . BASEURL . '/admin');
                    exit;
                } else {
                    header('Location: ' . BASEURL . '/customer');
                    exit;
                }
            }

            $data['judul'] = 'Bioskop';
            $data['film'] = $this->model('Film_model')->getAllFilm();
            $data['jadwal'] = $this->model('Jadwal_model')->getAllJadwal();

            $this->view('templates/header', $data);
            $this->view('customer/index', $data);
            $this->view('templates/footer');
        }
    }
