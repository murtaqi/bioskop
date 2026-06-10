-- 1. Membuat Database
CREATE DATABASE IF NOT EXISTS bioskop_db;
USE bioskop_db;

-- 2. Membuat Tabel User (Pengganti Customer + Akun Admin & Customer)
CREATE TABLE user (
    id_user VARCHAR(10) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Diisi dengan password_hash() pada aplikasi PHP
    no_telp VARCHAR(15) NOT NULL,
    role ENUM('admin', 'customer') NOT NULL,
    PRIMARY KEY (id_user)
);

-- Seed Default Admin Account (Username: admin, Password: admin)
INSERT INTO user (id_user, nama, username, password, no_telp, role) VALUES ('USR000', 'Administrator', 'admin', '$2y$10$HTM.7h9iIg89SQKToiTrZODwDI8YTpMcJt5K0Lq8SkBMjPRg.sZzO', '08123456789', 'admin');

-- 3. Membuat Tabel Film
CREATE TABLE film (
    id_film VARCHAR(10) NOT NULL,
    judul VARCHAR(150) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    durasi_menit INT NOT NULL,
    PRIMARY KEY (id_film)
);

-- 4. Membuat Tabel Jadwal
CREATE TABLE jadwal (
    id_jadwal VARCHAR(15) NOT NULL,
    id_film VARCHAR(10) NOT NULL,
    tanggal_tayang DATE NOT NULL,
    jam_tayang TIME NOT NULL,
    harga_tiket INT NOT NULL,
    PRIMARY KEY (id_jadwal),
    FOREIGN KEY (id_film) REFERENCES film(id_film) ON DELETE CASCADE ON UPDATE CASCADE
);

-- 5. Membuat Tabel Pemesanan (Foreign Key diarahkan ke id_user)
CREATE TABLE pemesanan (
    id_pemesanan VARCHAR(15) NOT NULL,
    id_user VARCHAR(10) NOT NULL,
    id_jadwal VARCHAR(15) NOT NULL,
    total_harga INT NOT NULL,
    status_bayar ENUM('Belum Lunas', 'Lunas') NOT NULL DEFAULT 'Belum Lunas',
    PRIMARY KEY (id_pemesanan),
    FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_jadwal) REFERENCES jadwal(id_jadwal) ON DELETE CASCADE ON UPDATE CASCADE
);

-- 6. Membuat Tabel Kursi
CREATE TABLE kursi (
    id_kursi VARCHAR(15) NOT NULL,
    id_pemesanan VARCHAR(15) NOT NULL,
    nomor_kursi VARCHAR(15) NOT NULL,
    PRIMARY KEY (id_kursi),
    FOREIGN KEY (id_pemesanan) REFERENCES pemesanan(id_pemesanan) ON DELETE CASCADE ON UPDATE CASCADE
);