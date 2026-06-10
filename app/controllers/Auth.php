<?php
    class Auth extends Controller {
        public function login(){
            if (isset($_SESSION['login'])) {
                header('Location: ' . BASEURL);
                exit;
            }
            $data['judul'] = 'Login';
            $data['error'] = $this->getSession('error');
            $data['success'] = $this->getSession('success');
            $this->view('templates/header', $data);
            $this->view('auth/login', $data);
            $this->view('templates/footer');
        }

        public function valid(){
            $user = $this->model('User_model')->getUser($_POST);
            if($user){
                if(password_verify($_POST['password'], $user['password'])){
                    $_SESSION['login'] = true;
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['user'] = $user['username'];
                    $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['nama'] = $user['nama'];

                    if($user['role'] == 'admin'){
                        header('Location: '. BASEURL . '/admin');
                    }else{
                        header('Location: '. BASEURL . '/customer');
                    }
                    exit;
                }
            }
            $this->setSession('error', 'Username atau Password Salah');
            header('Location: '. BASEURL . '/auth/login');
        }

        public function register(){
            if (isset($_SESSION['login'])) {
                header('Location: ' . BASEURL);
                exit;
            }
            $data['judul'] = 'Register';
            $data['error'] = $this->getSession('error');
            $this->view('templates/header', $data);
            $this->view('auth/register', $data);
            $this->view('templates/footer');
        }

        public function authenticate(){
            if($_POST['password'] !== $_POST['password2']){
                $this->setSession('error', 'Konfirmasi Password Tidak Cocok');
                header('Location: '.BASEURL.'/auth/register');
                exit;
            }
            $data = [
                'nama' => htmlspecialchars($_POST['nama']),
                'no_telp' => htmlspecialchars($_POST['no_telp']),
                'username' => strtolower(stripslashes($_POST['username'])),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role' => 'customer'
            ];
            
            $user = $this->model('User_model')->getUser($data);
            if($user){
                $this->setSession('error', 'Username Sudah Terdaftar');
                header('Location: '. BASEURL . '/auth/register');
                exit;
            }else{
                if ($this->model('User_model')->register($data) > 0) {
                    $this->setSession('success', 'Register Berhasil, Silahkan Login');
                    header('Location: '. BASEURL . '/auth/login');
                    exit;
                } else {
                    $this->setSession('error', 'Registrasi gagal, silakan coba lagi');
                    header('Location: '. BASEURL . '/auth/register');
                    exit;
                }
            }
        }

        public function logout(){
            $_SESSION = [];
            session_unset();
            session_destroy();
            header('Location: '. BASEURL);
        }
    }