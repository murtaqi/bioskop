<?php

    class User_model {
        private $table = 'user';
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getUser($data){
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
            $this->db->bind('username', $data['username']);
            return $this->db->single();
        }

        public function getUserById($id){
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_user = :id_user');
            $this->db->bind('id_user', $id);
            return $this->db->single();
        }

        public function getNewUserId(){
            $this->db->query("SELECT id_user FROM " . $this->table . " WHERE id_user LIKE 'USR%' ORDER BY id_user DESC LIMIT 1");
            $last = $this->db->single();
            if ($last) {
                $num = (int) substr($last['id_user'], 3);
                return 'USR' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
            }
            return 'USR001';
        }

        public function register($data){
            $id = $this->getNewUserId();
            $this->db->query("INSERT INTO " . $this->table . " (id_user, nama, username, password, no_telp, role) VALUES (:id_user, :nama, :username, :password, :no_telp, :role)");
            $this->db->bind('id_user', $id);
            $this->db->bind('nama', $data['nama']);
            $this->db->bind('username', $data['username']);
            $this->db->bind('password', $data['password']);
            $this->db->bind('no_telp', $data['no_telp']);
            $this->db->bind('role', isset($data['role']) ? $data['role'] : 'customer');
            $this->db->execute();
            return $this->db->rowCount();
        }
    }