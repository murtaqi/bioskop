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

        private function uploadFoto() {
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $namaFile = $_FILES['foto']['name'];
                $ukuranFile = $_FILES['foto']['size'];
                $tmpName = $_FILES['foto']['tmp_name'];

                // check extension
                $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                $ekstensiFile = explode('.', $namaFile);
                $ekstensiFile = strtolower(end($ekstensiFile));

                if (!in_array($ekstensiFile, $ekstensiValid)) {
                    return false;
                }

                // check size (limit to 5MB)
                if ($ukuranFile > 5000000) {
                    return false;
                }

                // generate new unique filename
                $namaFileBaru = uniqid() . '.' . $ekstensiFile;
                $targetDir = dirname(dirname(__DIR__)) . '/public/img/';

                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                if (move_uploaded_file($tmpName, $targetDir . $namaFileBaru)) {
                    return $namaFileBaru;
                }
            }
            return null;
        }

        public function tambah() {
            $foto = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                $foto = $this->uploadFoto();
                if ($foto === false) {
                    Flasher::setFlash('Gagal mengunggah foto. Pastikan format file gambar (jpg, jpeg, png, webp, gif) dan ukuran tidak lebih dari 5MB.', 'danger');
                    header('Location: ' . BASEURL . '/film');
                    exit;
                }
            }

            if ($this->model('Film_model')->tambahFilm($_POST, $foto) > 0) {
                Flasher::setFlash('Film berhasil ditambahkan', 'success');
            } else {
                Flasher::setFlash('Film gagal ditambahkan', 'danger');
            }
            header('Location: ' . BASEURL . '/film');
            exit;
        }

        public function ubah() {
            $foto = isset($_POST['foto_lama']) ? $_POST['foto_lama'] : null;

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                $new_foto = $this->uploadFoto();
                if ($new_foto === false) {
                    Flasher::setFlash('Gagal mengunggah foto baru. Pastikan format file gambar (jpg, jpeg, png, webp, gif) dan ukuran tidak lebih dari 5MB.', 'danger');
                    header('Location: ' . BASEURL . '/film');
                    exit;
                }

                if ($new_foto !== null) {
                    // Delete old photo if existed
                    if (!empty($_POST['foto_lama'])) {
                        $oldPath = dirname(dirname(__DIR__)) . '/public/img/' . $_POST['foto_lama'];
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    $foto = $new_foto;
                }
            }

            if ($this->model('Film_model')->ubahFilm($_POST, $foto) > 0) {
                Flasher::setFlash('Film berhasil diubah', 'success');
            } else {
                Flasher::setFlash('Film gagal diubah atau tidak ada perubahan data', 'danger');
            }
            header('Location: ' . BASEURL . '/film');
            exit;
        }

        public function hapus($id) {
            $film = $this->model('Film_model')->getFilmById($id);
            if ($film && !empty($film['foto'])) {
                $oldPath = dirname(dirname(__DIR__)) . '/public/img/' . $film['foto'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            if ($this->model('Film_model')->hapusFilm($id) > 0) {
                Flasher::setFlash('Film berhasil dihapus', 'success');
            } else {
                Flasher::setFlash('Film gagal dihapus', 'danger');
            }
            header('Location: ' . BASEURL . '/film');
            exit;
        }
    }