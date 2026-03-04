ALTER TABLE publikasi
ADD COLUMN is_published TINYINT(1) DEFAULT 0 AFTER is_active,
ADD COLUMN published_at DATETIME NULL,
ADD COLUMN published_by INT NULL,
ADD COLUMN publish_links JSON NULL,
ADD CONSTRAINT fk_publikasi_published_by 
FOREIGN KEY (published_by) REFERENCES users(id) ON DELETE SET NULL;

CREATE TABLE notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255),
    pesan TEXT,
    url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE notifikasi_user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    notifikasi_id INT,
    user_id INT,
    is_read TINYINT(1) DEFAULT 0,
    read_at DATETIME NULL,
    FOREIGN KEY (notifikasi_id) REFERENCES notifikasi(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);