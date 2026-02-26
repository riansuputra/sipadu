<?php
// ======================================================
// MODEL ARSIP SESUAI TABEL
// ======================================================

class ArsipModel
{
    protected $db;

    public function __construct()
    {
        // ambil dari singleton
        $this->db = Database::getInstance();
    }

    // ----------------------------------------------------
    // Ambil semua arsip + join dasar
    // ----------------------------------------------------
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT a.*,
                   GROUP_CONCAT(
                        CONCAT(af.id, '|', af.nama_file, '|', af.path_file, '|', af.tipe_file)
                        SEPARATOR '##'
                    ) AS files
            FROM arsip a
            LEFT JOIN arsip_file af 
            ON a.id = af.arsip_id
            GROUP BY a.id
            ORDER BY a.created_at DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM arsip WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ----------------------------------------------------
    // Insert arsip
    // ----------------------------------------------------
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO arsip (
                no_arsip, 
                kode_klasifikasi, 
                indeks, 
                no_item_arsip,
                uraian_informasi, 
                jenis_arsip, 
                kurun_waktu, 
                tanggal_arsip, 
                tingkat_perkembangan, 
                jumlah, 
                keterangan, 
                status_arsip, 
                klasifikasi_keamanan, 
                hak_akses, 
                akses_publik, 
                no_filling_cabinet, 
                no_laci, 
                no_folder, 
                no_boks, 
                lokasi_simpan, 
                nomor_definitif, 
                pencipta_arsip, 
                jangka_simpan, 
                nasib_akhir, 
                status_usul_musnah, 
                boks_usul_musnah, 
                kota_kabupaten, 
                dibuat_oleh 
            ) VALUES (
                ?,?,?,?,?,?,?,?,?,
                ?,?,?,?,?,?,?,?,?,?,
                ?,?,?,?,?,?,?,?,?
            )
        ");

        $stmt->execute([
            $data['no_arsip'],
            $data['kode_klasifikasi'],
            $data['indeks'],
            $data['no_item_arsip'],
            $data['uraian_informasi'],
            $data['jenis_arsip'],
            $data['kurun_waktu'],
            $data['tanggal_arsip'],
            $data['tingkat_perkembangan'],
            $data['jumlah'],
            $data['keterangan'],
            $data['status_arsip'],
            $data['klasifikasi_keamanan'],
            $data['hak_akses'],
            $data['akses_publik'],
            $data['no_filling_cabinet'],
            $data['no_laci'],
            $data['no_folder'],
            $data['no_boks'],
            $data['lokasi_simpan'],
            $data['nomor_definitif'],
            $data['pencipta_arsip'],
            $data['jangka_simpan'],
            $data['nasib_akhir'],
            $data['status_usul_musnah'],
            $data['boks_usul_musnah'],
            $data['kota_kabupaten'],
            $data['dibuat_oleh']
        ]);

        return $this->db->lastInsertId();
    }

    // ----------------------------------------------------
    // Update arsip
    // ----------------------------------------------------
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE arsip SET
                no_arsip = ?,
                kode_klasifikasi = ?,
                indeks = ?,
                no_item_arsip = ?,
                uraian_informasi = ?,
                jenis_arsip = ?, 
                kurun_waktu = ?, 
                tanggal_arsip = ?, 
                tingkat_perkembangan = ?, 
                jumlah = ?, 
                keterangan = ?, 
                status_arsip = ?, 
                klasifikasi_keamanan = ?, 
                hak_akses = ?, 
                akses_publik = ?, 
                no_filling_cabinet = ?, 
                no_laci = ?, 
                no_folder = ?, 
                no_boks = ?, 
                lokasi_simpan = ?, 
                nomor_definitif = ?, 
                pencipta_arsip = ?, 
                jangka_simpan = ?, 
                nasib_akhir = ?, 
                status_usul_musnah = ?, 
                boks_usul_musnah = ?, 
                kota_kabupaten = ?, 
                dibuat_oleh = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['no_arsip'],
            $data['kode_klasifikasi'],
            $data['indeks'],
            $data['no_item_arsip'],
            $data['uraian_informasi'],
            $data['jenis_arsip'],
            $data['kurun_waktu'],
            $data['tanggal_arsip'],
            $data['tingkat_perkembangan'],
            $data['jumlah'],
            $data['keterangan'],
            $data['status_arsip'],
            $data['klasifikasi_keamanan'],
            $data['hak_akses'],
            $data['akses_publik'],
            $data['no_filling_cabinet'],
            $data['no_laci'],
            $data['no_folder'],
            $data['no_boks'],
            $data['lokasi_simpan'],
            $data['nomor_definitif'],
            $data['pencipta_arsip'],
            $data['jangka_simpan'],
            $data['nasib_akhir'],
            $data['status_usul_musnah'],
            $data['boks_usul_musnah'],
            $data['kota_kabupaten'],
            $data['dibuat_oleh'],
            $id
        ]);
    }

    // ----------------------------------------------------
    // Detail arsip
    // ----------------------------------------------------


    // ----------------------------------------------------
    // Delete arsip
    // ----------------------------------------------------
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE arsip SET is_active = 0 WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    // ----------------------------------------------------
    // Insert file arsip
    // ----------------------------------------------------
    public function insertFile($arsip_id, $file)
    {
        $stmt = $this->db->prepare("
            INSERT INTO arsip_file (
                arsip_id, 
                nama_file, 
                path_file, 
                tipe_file, 
                ukuran_file
            ) VALUES (?,?,?,?,?)
        ");

        return $stmt->execute([
            $arsip_id,
            $file['nama_file'],
            $file['path_file'],
            $file['tipe_file'],
            $file['ukuran_file']
        ]);
    }

    // ----------------------------------------------------
    // Ambil file arsip
    // ----------------------------------------------------
    public function getFiles($arsip_id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM arsip_file
            WHERE arsip_id = ?
        ");

        $stmt->execute([$arsip_id]);
        return $stmt->fetchAll();
    }

    // ----------------------------------------------------
    // Hapus file by arsip
    // ----------------------------------------------------
    public function deleteFiles($arsip_id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM arsip_file WHERE arsip_id = ?
        ");

        return $stmt->execute([$arsip_id]);
    }
}
