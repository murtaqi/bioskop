<?php
    class Controller {
        public function view($view, $data = []){
            require_once '../app/views/'.$view.'.php';
        }

        public function model($model){
            require_once '../app/models/'.$model.'.php';
            return new $model;
        }

        public function auth(){
            if(!isset($_SESSION['user'])){
                header('Location: '. BASEURL . '/auth/login');
                exit;
            }
        }

        public function setSession($key, $value){
            $_SESSION[$key] = $value;
        }

        public function getSession($key){
            if(isset($_SESSION[$key])){
                $message = $_SESSION[$key];
                unset($_SESSION[$key]);
                return $message;
            }
            return null;
        }
    }