<?php

    class Pemesanan_model {
        private $table = 'pemesanan';
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getNewPemesananId(){
            $this->db->query("SELECT id_pemesanan FROM " . $this->table . " WHERE id_pemesanan LIKE 'PMS%' ORDER BY id_pemesanan DESC LIMIT 1");
            $last = $this->db->single();
            if ($last) {
                $num = (int) substr($last['id_pemesanan'], 3);
                return 'PMS' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
            }
            return 'PMS0001';
        }

        public function getKursiDipesan($id_jadwal) {
            $this->db->query("SELECT k.nomor_kursi FROM kursi k JOIN " . $this->table . " p ON k.id_pemesanan = p.id_pemesanan WHERE p.id_jadwal = :id_jadwal");
            $this->db->bind('id_jadwal', $id_jadwal);
            $result = $this->db->resultSet();

            $seats = [];
            foreach ($result as $row) {
                $seats[] = $row['nomor_kursi'];
            }
            return $seats;
        }

        public function buatPemesanan($id_user, $id_jadwal, $total_harga, $seats){
            $id_pemesanan = $this->getNewPemesananId();

            // Insert into pemesanan
            $this->db->query("INSERT INTO " . $this->table . " (id_pemesanan, id_user, id_jadwal, total_harga, status_bayar) VALUES (:id_pemesanan, :id_user, :id_jadwal, :total_harga, 'Belum Lunas')");
            $this->db->bind('id_pemesanan', $id_pemesanan);
            $this->db->bind('id_user', $id_user);
            $this->db->bind('id_jadwal', $id_jadwal);
            $this->db->bind('total_harga', $total_harga);
            $this->db->execute();

            // Get starting kursi ID
            $this->db->query("SELECT id_kursi FROM kursi WHERE id_kursi LIKE 'KRS%' ORDER BY id_kursi DESC LIMIT 1");
            $last = $this->db->single();
            $start_num = 1;
            if ($last) {
                $start_num = ((int) substr($last['id_kursi'], 3)) + 1;
            }

            // Insert seats
            foreach ($seats as $seat) {
                $id_kursi = 'KRS' . str_pad($start_num, 5, '0', STR_PAD_LEFT);
                $this->db->query("INSERT INTO kursi (id_kursi, id_pemesanan, nomor_kursi) VALUES (:id_kursi, :id_pemesanan, :nomor_kursi)");
                $this->db->bind('id_kursi', $id_kursi);
                $this->db->bind('id_pemesanan', $id_pemesanan);
                $this->db->bind('nomor_kursi', $seat);
                $this->db->execute();
                $start_num++;
            }
            return $id_pemesanan;
        }

        public function getSeatsByPemesanan($id_pemesanan) {
            $this->db->query("SELECT nomor_kursi FROM kursi WHERE id_pemesanan = :id_pemesanan ORDER BY nomor_kursi ASC");
            $this->db->bind('id_pemesanan', $id_pemesanan);
            $result = $this->db->resultSet();
            $seats = [];
            foreach ($result as $row) {
                $seats[] = $row['nomor_kursi'];
            }
            return $seats;
        }

        public function getPemesananByUser($id_user) {
            $this->db->query("SELECT p.*, j.tanggal_tayang, j.jam_tayang, j.harga_tiket, f.judul, f.genre FROM " . $this->table . " p JOIN jadwal j ON p.id_jadwal = j.id_jadwal JOIN film f ON j.id_film = f.id_film WHERE p.id_user = :id_user ORDER BY p.id_pemesanan DESC");
            $this->db->bind('id_user', $id_user);
            $bookings = $this->db->resultSet();

            for ($i = 0; $i < count($bookings); $i++) {
                $bookings[$i]['seats'] = $this->getSeatsByPemesanan($bookings[$i]['id_pemesanan']);
            }
            return $bookings;
        }

        public function getAllPemesanan() {
            $this->db->query("SELECT p.*, u.nama as nama_user, j.tanggal_tayang, j.jam_tayang, f.judul FROM " . $this->table . " p JOIN user u ON p.id_user = u.id_user JOIN jadwal j ON p.id_jadwal = j.id_jadwal JOIN film f ON j.id_film = f.id_film ORDER BY p.id_pemesanan DESC");
            $bookings = $this->db->resultSet();

            for ($i = 0; $i < count($bookings); $i++) {
                $bookings[$i]['seats'] = $this->getSeatsByPemesanan($bookings[$i]['id_pemesanan']);
            }
            return $bookings;
        }

        public function updateStatusBayar($id_pemesanan, $status) {
            $this->db->query("UPDATE " . $this->table . " SET status_bayar = :status_bayar WHERE id_pemesanan = :id_pemesanan");
            $this->db->bind('status_bayar', $status);
            $this->db->bind('id_pemesanan', $id_pemesanan);
            $this->db->execute();
            return $this->db->rowCount();
        }
    }
