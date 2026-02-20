ALTER TABLE publikasi
ADD COLUMN is_published TINYINT(1) DEFAULT 0 AFTER is_active,
ADD COLUMN published_at DATETIME NULL,
ADD COLUMN published_by INT NULL,
ADD COLUMN publish_links JSON NULL,
ADD CONSTRAINT fk_publikasi_published_by 
FOREIGN KEY (published_by) REFERENCES users(id) ON DELETE SET NULL;
