<?php
// ======================================================
// MODEL ARSIP SESUAI TABEL
// ======================================================
class ArsipModel
{
    protected $db;

    // constructor
    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // ----------------------------------------------------
    // Ambil semua arsip + join dasar
    // ----------------------------------------------------
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT a.*,
                   k.nama_kategori,
                   p.nama_pokja,
                   u.nama as pembuat
            FROM arsip a
            JOIN arsip_kategori k ON a.kategori_id = k.id
            JOIN pokja p ON a.pokja_id = p.id
            JOIN users u ON a.dibuat_oleh = u.id
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
                tahun, 
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
                ?,?,?,?,?,?,?,?,?,?,
                ?,?,?,?,?,?,?,?,?,?,
                ?,?,?,?,?,?,?,?,?,?
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
            $data['tahun'],
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
                tahun = ?, 
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
            $data['tahun'],
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
