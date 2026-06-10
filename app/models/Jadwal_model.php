<?php

    class Jadwal_model {
        private $table = 'jadwal';
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getAllJadwal(){
            $this->db->query("SELECT j.*, f.judul, f.genre FROM " . $this->table . " j JOIN film f ON j.id_film = f.id_film ORDER BY j.tanggal_tayang ASC, j.jam_tayang ASC");
            return $this->db->resultSet();
        }

        public function getJadwalById($id){
            $this->db->query("SELECT j.*, f.judul, f.genre, f.durasi_menit FROM " . $this->table . " j JOIN film f ON j.id_film = f.id_film WHERE j.id_jadwal = :id_jadwal");
            $this->db->bind('id_jadwal', $id);
            return $this->db->single();
        }

        public function getNewJadwalId(){
            $this->db->query("SELECT id_jadwal FROM " . $this->table . " WHERE id_jadwal LIKE 'JDW%' ORDER BY id_jadwal DESC LIMIT 1");
            $last = $this->db->single();
            if ($last) {
                $num = (int) substr($last['id_jadwal'], 3);
                return 'JDW' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
            }
            return 'JDW001';
        }

        public function tambahJadwal($data){
            $id = $this->getNewJadwalId();
            $this->db->query("INSERT INTO " . $this->table . " (id_jadwal, id_film, tanggal_tayang, jam_tayang, harga_tiket) VALUES (:id_jadwal, :id_film, :tanggal_tayang, :jam_tayang, :harga_tiket)");
            $this->db->bind('id_jadwal', $id);
            $this->db->bind('id_film', $data['id_film']);
            $this->db->bind('tanggal_tayang', $data['tanggal_tayang']);
            $this->db->bind('jam_tayang', $data['jam_tayang']);
            $this->db->bind('harga_tiket', $data['harga_tiket']);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function ubahJadwal($data){
            $this->db->query("UPDATE " . $this->table . " SET id_film = :id_film, tanggal_tayang = :tanggal_tayang, jam_tayang = :jam_tayang, harga_tiket = :harga_tiket WHERE id_jadwal = :id_jadwal");
            $this->db->bind('id_jadwal', $data['id_jadwal']);
            $this->db->bind('id_film', $data['id_film']);
            $this->db->bind('tanggal_tayang', $data['tanggal_tayang']);
            $this->db->bind('jam_tayang', $data['jam_tayang']);
            $this->db->bind('harga_tiket', $data['harga_tiket']);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function hapusJadwal($id){
            $this->db->query("DELETE FROM " . $this->table . " WHERE id_jadwal = :id_jadwal");
            $this->db->bind('id_jadwal', $id);
            $this->db->execute();
            return $this->db->rowCount();
        }
    }
