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
    role_target VARCHAR(50), -- admin / user / dll
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);