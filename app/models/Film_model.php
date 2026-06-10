<?php

    class Film_model {
        private $table = 'film';
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getAllFilm(){
            $this->db->query('SELECT * FROM ' . $this->table);
            return $this->db->resultSet();
        }

        public function getFilmById($id){
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_film = :id_film');
            $this->db->bind('id_film', $id);
            return $this->db->single();
        }

        public function getNewFilmId(){
            $this->db->query("SELECT id_film FROM " . $this->table . " WHERE id_film LIKE 'FLM%' ORDER BY id_film DESC LIMIT 1");
            $last = $this->db->single();
            if ($last) {
                $num = (int) substr($last['id_film'], 3);
                return 'FLM' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
            }
            return 'FLM001';
        }

        public function tambahFilm($data){
            $id = $this->getNewFilmId();
            $this->db->query("INSERT INTO " . $this->table . " (id_film, judul, genre, durasi_menit) VALUES (:id_film, :judul, :genre, :durasi_menit)");
            $this->db->bind('id_film', $id);
            $this->db->bind('judul', $data['judul']);
            $this->db->bind('genre', $data['genre']);
            $this->db->bind('durasi_menit', $data['durasi_menit']);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function ubahFilm($data){
            $this->db->query("UPDATE " . $this->table . " SET judul = :judul, genre = :genre, durasi_menit = :durasi_menit WHERE id_film = :id_film");
            $this->db->bind('id_film', $data['id_film']);
            $this->db->bind('judul', $data['judul']);
            $this->db->bind('genre', $data['genre']);
            $this->db->bind('durasi_menit', $data['durasi_menit']);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function hapusFilm($id){
            $this->db->query("DELETE FROM " . $this->table . " WHERE id_film = :id_film");
            $this->db->bind('id_film', $id);
            $this->db->execute();
            return $this->db->rowCount();
        }
    }
