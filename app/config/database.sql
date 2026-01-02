CREATE DATABASE sipadu;

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role_id INT(11) NOT NULL,
    pokja_id INT(11) NULL,
    is_aktif TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX (role_id),
    INDEX (pokja_id)
);

CREATE TABLE pokja (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    tipe_grup ENUM('Tim','Unit') NOT NULL,
    nama_grup VARCHAR(100) NOT NULL
);

CREATE TABLE role (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kode_role VARCHAR(20) NOT NULL,
    nama_role VARCHAR(50) NOT NULL
);

CREATE TABLE pegawai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(30) UNIQUE NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L','P'),
    status_pegawai ENUM('ASN','NON_ASN','HONORER'),
    jabatan VARCHAR(100),
    unit_kerja VARCHAR(100),
    pokja_id INT NULL,
    email VARCHAR(100),
    no_hp VARCHAR(20),
    alamat TEXT,
    is_aktif TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (pokja_id) REFERENCES pokja(id)
);

CREATE TABLE modul (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100) NOT NULL,
    deskripsi VARCHAR(255) NULL,
    link VARCHAR(255) NOT NULL,
    gambar VARCHAR(255) NULL,
    urutan INT(11) NULL,
    is_aktif TINYINT(1) DEFAULT 1,
    is_global TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE modul_pokja (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    modul_id INT(11) NOT NULL,
    pokja_id INT(11) NOT NULL,

    INDEX (modul_id),
    INDEX (pokja_id)
);

CREATE TABLE modul_role (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    modul_id INT(11) NOT NULL,
    role_id INT(11) NOT NULL,

    INDEX (modul_id),
    INDEX (role_id)
);

CREATE TABLE arsip (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kode_arsip VARCHAR(50) NOT NULL,
    judul VARCHAR(150) NOT NULL,
    kategori_id INT(11) NOT NULL,
    pokja_id INT(11) NOT NULL,
    created_by INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX (kategori_id),
    INDEX (pokja_id),
    INDEX (created_by)
);

CREATE TABLE file_arsip (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    arsip_id INT(11) NOT NULL,
    nama_file VARCHAR(255) NOT NULL,
    path_file VARCHAR(255) NOT NULL,
    tipe_file VARCHAR(50) NULL,
    ukuran_file INT(11) NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX (arsip_id)
);

CREATE TABLE kategori_arsip (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    is_rahasia TINYINT(1) DEFAULT 0
);
