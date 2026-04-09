ALTER TABLE pokja
ADD COLUMN slug VARCHAR(100) DEFAULT NULL AFTER pokja_nama;

UPDATE pokja SET slug = 'paud' WHERE pokja_nama = 'PAUD';
UPDATE pokja SET slug = 'sd' WHERE pokja_nama = 'SD';
UPDATE pokja SET slug = 'smp' WHERE pokja_nama = 'SMP';
UPDATE pokja SET slug = 'sma' WHERE pokja_nama = 'SMA';
UPDATE pokja SET slug = 'widyaprada' WHERE pokja_nama = 'Widyaprada';
UPDATE pokja SET slug = 'kepegawaian' WHERE pokja_nama = 'Kepegawaian';
UPDATE pokja SET slug = 'perencanaan' WHERE pokja_nama = 'Perencanaan';
UPDATE pokja SET slug = 'publikasi' WHERE pokja_nama = 'Publikasi';

ALTER TABLE pokja
ADD UNIQUE KEY uq_pokja_slug (slug);

CREATE TABLE user_pokja (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    pokja_id INT(11) NOT NULL,
    is_default TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_user_pokja (user_id, pokja_id),
    KEY idx_user_pokja_user (user_id),
    KEY idx_user_pokja_pokja (pokja_id),
    CONSTRAINT fk_user_pokja_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_user_pokja_pokja FOREIGN KEY (pokja_id) REFERENCES pokja(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO user_pokja (user_id, pokja_id, is_default, is_active)
SELECT 
    id AS user_id,
    pokja_id,
    1 AS is_default,
    1 AS is_active
FROM users
WHERE pokja_id IS NOT NULL;