<?php

class PegawaiModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }

    public function rollback()
    {
        return $this->db->rollBack();
    }

    public function getAll()
    {
        $this->db->exec("SET SESSION group_concat_max_len = 100000");

        $stmt = $this->db->prepare("
        SELECT 
            p.*,
            j.nama as nama_jabatan,
            u.pokja_id,
            pk.pokja_nama,
            CASE 
                WHEN LOWER(pk.pokja_nama) LIKE '%widyaprada%' THEN 1
                ELSE 0
            END AS is_widyaprada,
            pf.files

        FROM pegawai p

        LEFT JOIN pegawai_jabatan j 
            ON j.id = p.jabatan_id

        LEFT JOIN users u
            ON u.pegawai_id = p.id

        LEFT JOIN pokja pk
            ON pk.id = u.pokja_id

        LEFT JOIN (
            SELECT 
                pegawai_id,
                GROUP_CONCAT(
                    CONCAT(
                        id, '|',
                        jenis_dokumen, '|',
                        nama_file, '|',
                        path_file, '|',
                        tipe_file
                    )
                    SEPARATOR '##'
                ) AS files
            FROM pegawai_file
            GROUP BY pegawai_id
        ) pf ON pf.pegawai_id = p.id

        WHERE p.is_active = 1
        AND p.deleted_at IS NULL

        ORDER BY p.created_at DESC
    ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
        SELECT 
            p.*,
            j.nama as nama_jabatan,
            u.pokja_id,
            pk.pokja_nama AS pokja_nama,

            CASE 
                WHEN LOWER(pk.pokja_nama) LIKE '%widyaprada%' THEN 1
                ELSE 0
            END AS is_widyaprada

        FROM pegawai p

        LEFT JOIN pegawai_jabatan j 
            ON j.id = p.jabatan_id

        LEFT JOIN users u
            ON u.pegawai_id = p.id

        LEFT JOIN pokja pk
            ON pk.id = u.pokja_id

        WHERE p.id = ?
        AND p.deleted_at IS NULL
        LIMIT 1
    ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Simpan DIP baru
    public function insert($data)
    {
        // Normalisasi field optional
        foreach (
            [
                'nik',
                'nip',
                'email',
                'grade',
                'jurusan',
                'nomor_sk_pengangkatan',
                'nomor_sk_spmt',
                'tempat_lahir',
                'alamat_domisili',
                'no_telepon',
                'pangkat_golongan',
                'jabatan_id'
            ] as $field
        ) {
            if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
                $data[$field] = null;
            }
        }

        $stmt = $this->db->prepare("
        INSERT INTO pegawai (
            nama,
            nik,
            nip,
            tempat_lahir,
            tanggal_lahir,
            jenis_kelamin,
            agama,
            alamat_domisili,
            no_telepon,
            email,
            status_asn,
            pangkat_golongan,
            grade,
            jabatan_id,
            pendidikan,
            jurusan,
            tmt_masuk,
            nomor_sk_pengangkatan,
            nomor_sk_spmt,
            created_by
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

        $stmt->execute([
            $data['nama'],
            $data['nik'],
            $data['nip'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['agama'],
            $data['alamat_domisili'],
            $data['no_telepon'],
            $data['email'],
            $data['status_asn'],
            $data['pangkat_golongan'],
            $data['grade'],
            $data['jabatan_id'],
            $data['pendidikan'],
            $data['jurusan'],
            $data['tmt_masuk'],
            $data['nomor_sk_pengangkatan'],
            $data['nomor_sk_spmt'],
            $data['created_by']
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        // Normalisasi field optional
        foreach (
            [
                'nik',
                'nip',
                'email',
                'grade',
                'jurusan',
                'nomor_sk_pengangkatan',
                'nomor_sk_spmt',
                'tempat_lahir',
                'alamat_domisili',
                'no_telepon',
                'pangkat_golongan',
                'jabatan_id'
            ] as $field
        ) {
            if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
                $data[$field] = null;
            }
        }

        $stmt = $this->db->prepare("
        UPDATE pegawai SET
            nama = ?,
            nik = ?,
            nip = ?,
            tempat_lahir = ?,
            tanggal_lahir = ?,
            jenis_kelamin = ?,
            agama = ?,
            alamat_domisili = ?,
            no_telepon = ?,
            email = ?,
            status_asn = ?,
            pangkat_golongan = ?,
            grade = ?,
            jabatan_id = ?,
            pendidikan = ?,
            jurusan = ?,
            tmt_masuk = ?,
            nomor_sk_pengangkatan = ?,
            nomor_sk_spmt = ?
        WHERE id = ?
    ");

        return $stmt->execute([
            $data['nama'],
            $data['nik'],
            $data['nip'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['agama'],
            $data['alamat_domisili'],
            $data['no_telepon'],
            $data['email'],
            $data['status_asn'],
            $data['pangkat_golongan'],
            $data['grade'],
            $data['jabatan_id'],
            $data['pendidikan'],
            $data['jurusan'],
            $data['tmt_masuk'],
            $data['nomor_sk_pengangkatan'],
            $data['nomor_sk_spmt'],
            $id
        ]);
    }

    // Hapus DIP (soft delete)
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE pegawai SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    // Simpan file DIP
    public function insertFile($id, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pegawai_file (
                pegawai_id,
                jenis_dokumen,
                nama_file,
                path_file,
                tipe_file,
                ukuran_file
            ) VALUES (?,?,?,?,?,?)
        ");

        return $stmt->execute([
            $id,
            $file['jenis_dokumen'],
            $file['nama_file'],
            $file['path_file'],
            $file['tipe_file'],
            $file['ukuran_file']
        ]);
    }

    // Ambil file berdasarkan DIP
    public function getFiles($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM pegawai_file 
            WHERE pegawai_id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteFiles($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM pegawai_file WHERE pegawai_id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function deleteFilesByParent($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM pegawai_file WHERE pegawai_id = ?
        ");

        return $stmt->execute([$id]);
    }

    // cek apakah NIK sudah ada (untuk store & update)
    public function existsNik($nik, $excludeId = null)
    {
        $sql = "SELECT id FROM pegawai 
            WHERE nik = ? 
            AND deleted_at IS NULL";

        $params = [$nik];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }


    public function existsNip($nip, $excludeId = null)
    {
        $sql = "SELECT id FROM pegawai 
            WHERE nip = ? 
            AND deleted_at IS NULL";

        $params = [$nip];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    // Ambil statistik jumlah pegawai berdasarkan status ASN
    public function getStatistikStatusAsn()
    {
        $stmt = $this->db->prepare("
        SELECT 
            status_asn,
            COUNT(*) AS total
        FROM pegawai
        WHERE is_active = 1
        AND deleted_at IS NULL
        GROUP BY status_asn
    ");

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Default agar selalu ada semua key
        $result = [
            'PNS' => 0,
            'PPPK' => 0,
            'PPNPN/OUTSOURCING' => 0,
            'total' => 0
        ];

        foreach ($rows as $row) {
            $status = strtoupper(trim($row['status_asn']));
            $total = (int) $row['total'];

            if (isset($result[$status])) {
                $result[$status] = $total;
            }

            $result['total'] += $total;
        }

        return $result;
    }

    // Ambil rata-rata umur seluruh pegawai aktif
    public function getRataRataUmur()
    {
        $stmt = $this->db->prepare("
        SELECT 
            ROUND(AVG(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())), 1) AS rata_rata_umur
        FROM pegawai
        WHERE is_active = 1
        AND deleted_at IS NULL
        AND tanggal_lahir IS NOT NULL
    ");

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['rata_rata_umur'] ?? 0;
    }

    // Ambil daftar pegawai yang pensiun pada tahun tertentu
    public function getPensiunTahunan($tahun = null)
    {
        $tahun = $tahun ?: date('Y');

        $stmt = $this->db->prepare("
        SELECT 
            p.id,
            p.nama,
            p.nip,
            p.tanggal_lahir,
            p.tmt_masuk,
            p.status_asn,
            j.nama,
            pk.pokja_nama,
            CASE 
                WHEN LOWER(pk.pokja_nama) LIKE '%widyaprada%' THEN 1
                ELSE 0
            END AS is_widyaprada
        FROM pegawai p
        LEFT JOIN pegawai_jabatan j 
            ON j.id = p.jabatan_id
        LEFT JOIN users u
            ON u.pegawai_id = p.id
        LEFT JOIN pokja pk
            ON pk.id = u.pokja_id
        WHERE p.is_active = 1
        AND p.deleted_at IS NULL
        ORDER BY p.tanggal_lahir ASC
    ");

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hasil = [];

        foreach ($rows as $row) {
            $usiaPensiun = usiaPensiunPegawai(!empty($row['is_widyaprada']));
            $tanggalPensiun = tanggalPensiunPegawai($row['tanggal_lahir'], $usiaPensiun);

            if (!$tanggalPensiun) {
                continue;
            }

            $tahunPensiun = date('Y', strtotime($tanggalPensiun));

            if ((int)$tahunPensiun === (int)$tahun) {
                $row['usia_pensiun'] = $usiaPensiun;
                $row['tanggal_pensiun'] = $tanggalPensiun;
                $row['status_pegawai'] = statusPegawai($row['tanggal_lahir'], $usiaPensiun);
                $row['umur'] = umurTahun($row['tanggal_lahir']);
                $row['masa_kerja'] = masaKerjaPegawai($row['tmt_masuk']);
                $row['info_pensiun'] = infoPensiunPegawaiDetail($row['tanggal_lahir'], $usiaPensiun);

                $hasil[] = $row;
            }
        }

        return $hasil;
    }

    // Ambil ringkasan jumlah pegawai pensiun per tahun
    public function getRingkasanPensiunPerTahun($mulai = null, $sampai = null)
    {
        $mulai = $mulai ?: date('Y');
        $sampai = $sampai ?: date('Y') + 5;

        $stmt = $this->db->prepare("
        SELECT 
            p.id,
            p.nama,
            p.tanggal_lahir,
            pk.pokja_nama,
            CASE 
                WHEN LOWER(pk.pokja_nama) LIKE '%widyaprada%' THEN 1
                ELSE 0
            END AS is_widyaprada
        FROM pegawai p
        LEFT JOIN users u
            ON u.pegawai_id = p.id
        LEFT JOIN pokja pk
            ON pk.id = u.pokja_id
        WHERE p.is_active = 1
        AND p.deleted_at IS NULL
    ");

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ringkasan = [];

        for ($tahun = $mulai; $tahun <= $sampai; $tahun++) {
            $ringkasan[$tahun] = 0;
        }

        foreach ($rows as $row) {
            $usiaPensiun = usiaPensiunPegawai(!empty($row['is_widyaprada']));
            $tanggalPensiun = tanggalPensiunPegawai($row['tanggal_lahir'], $usiaPensiun);

            if (!$tanggalPensiun) continue;

            $tahunPensiun = (int) date('Y', strtotime($tanggalPensiun));

            if ($tahunPensiun >= $mulai && $tahunPensiun <= $sampai) {
                $ringkasan[$tahunPensiun]++;
            }
        }

        return $ringkasan;
    }

    public function getDaftarPensiun($mulai = null, $sampai = null)
    {
        $mulai = $mulai ?: date('Y');
        $sampai = $sampai ?: $mulai;

        $stmt = $this->db->prepare("
        SELECT 
            p.id,
            p.nama AS nama_pegawai,
            p.nip,
            p.tanggal_lahir,
            p.tmt_masuk,
            p.status_asn,
            j.nama AS nama_jabatan,
            pk.pokja_nama,
            CASE 
                WHEN LOWER(pk.pokja_nama) LIKE '%widyaprada%' THEN 1
                ELSE 0
            END AS is_widyaprada
        FROM pegawai p
        LEFT JOIN pegawai_jabatan j 
            ON j.id = p.jabatan_id
        LEFT JOIN users u
            ON u.pegawai_id = p.id
        LEFT JOIN pokja pk
            ON pk.id = u.pokja_id
        WHERE p.is_active = 1
        AND p.deleted_at IS NULL
        ORDER BY p.tanggal_lahir ASC
    ");

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hasil = [];

        foreach ($rows as $row) {
            $usiaPensiun = usiaPensiunPegawai(!empty($row['is_widyaprada']));
            $tanggalPensiun = tanggalPensiunPegawai($row['tanggal_lahir'], $usiaPensiun);

            if (!$tanggalPensiun) {
                continue;
            }

            $tahunPensiun = (int) date('Y', strtotime($tanggalPensiun));

            if ($tahunPensiun >= (int)$mulai && $tahunPensiun <= (int)$sampai) {
                $row['usia_pensiun'] = $usiaPensiun;
                $row['tanggal_pensiun'] = $tanggalPensiun;
                $row['status_pegawai'] = statusPegawai($row['tanggal_lahir'], $usiaPensiun);
                $row['umur'] = umurTahun($row['tanggal_lahir']);
                $row['masa_kerja'] = masaKerjaPegawai($row['tmt_masuk']);
                $row['info_pensiun'] = infoPensiunPegawaiDetail($row['tanggal_lahir'], $usiaPensiun);

                $hasil[] = $row;
            }
        }

        return $hasil;
    }
}
