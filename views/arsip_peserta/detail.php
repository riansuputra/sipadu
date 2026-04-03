<?php
// ================================
// DASHBOARD STAFF
// ================================

// Judul
$title = "Detail Arsip";
$bannerTitle = "Detail Arsip";
$bannerSubtitle = "SIPADU BPMP Provinsi Bali";

// echo '<pre>';
// dd($data, $peserta, $files, $pegawai, $jenis, $this->user, $this->role);
// dd($peserta);
// dd($data['files']);
// dd($pegawai);
// dd($jenis);
// dd($this->user);
// dd($this->role);
// print_r($files);
// echo '</pre>';

// Mulai buffer konten

ob_start();
?>

<div class="page-body mt-3" id="page-content" style="display:none;">
    <div class="container-xl">



        <div class="row row-cards">

            <div class="col-12 mb-0">
                <div class="row">
                    <div class="col">
                        <ol class="breadcrumb text-center" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=dashboard') ?>" class="h3 mb-0">
                                    🏠︎&nbsp;&nbsp;Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= url('?page=arsip-saya') ?>" class="h3 mb-0">
                                    Arsip
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="tests" class="h3 mb-0">
                                    Detail Arsip
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Arsip</h3>
                    </div>
                    <?php if (($data['status_otomatis'] ?? '') === 'bukti_diunggah'): ?>
                        <div class="ribbon bg-success">Sudah Upload</div>
                    <?php else: ?>
                        <div class="ribbon bg-danger">Belum Upload</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="mb-3">"<?= htmlspecialchars($data['judul'] ?? '-') ?>"</h2>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="text-muted small">Jenis Kegiatan :</div>
                                <div class="fw-semibold"><?= htmlspecialchars($data['jenis_nama'] ?? '-') ?></div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Lokasi :</div>
                                <div class="fw-semibold"><?= htmlspecialchars($data['lokasi'] ?? '-') ?></div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">Tanggal Mulai & Selesai :</div>
                                <div class="fw-semibold">
                                    <?= formatTanggalRange($data['tanggal_mulai'] ?? null, $data['tanggal_selesai'] ?? null) ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small">File :</div>
                                <?php
                                $listFile = [];

                                if (!empty($data["files"])) {
                                    $arsipFiles = explode("##", $data["files"],);

                                    foreach ($arsipFiles as $f) {
                                        $part = explode("|", $f,);

                                        if (count($part) === 4) {
                                            [
                                                $id,
                                                $nama,
                                                $path,
                                                $tipe,
                                            ] = $part;

                                            $listFile[] = [
                                                'id' => $id,
                                                'nama_raw' => $nama,
                                                'path_raw' => $path,
                                                'tipe_raw' => $tipe
                                            ];
                                        }
                                    }
                                }

                                // tampilkan
                                foreach ($listFile as $f):
                                    $nama = htmlspecialchars($f['nama_raw'], ENT_QUOTES, 'UTF-8');
                                    $path = htmlspecialchars($f['path_raw'], ENT_QUOTES, 'UTF-8');
                                    $ext  = strtolower(pathinfo($f['nama_raw'], PATHINFO_EXTENSION));
                                    // SVG inline
                                    $fid = $f["id"];
                                    if ($ext === 'pdf') {
                                        $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M17 18h2" />
                                                                <path d="M20 15h-3v6" />
                                                                <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1" />
                                                            </svg>';
                                    } else if ($ext === 'jpg' || $ext === 'jpeg') {
                                        $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow icon icon-tabler icons-tabler-outline icon-tabler-file-type-jpg">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 15h3v4.5a1.5 1.5 0 0 1 -3 0" />
                                                            </svg>';
                                    } else if ($ext === 'png') {
                                        $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple icon icon-tabler icons-tabler-outline icon-tabler-file-type-png">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M20 15h-1a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h1v-3" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M11 21v-6l3 6v-6" />
                                                            </svg>
                                                                ';
                                    } else if ($ext === 'doc' || $ext === 'docx') {
                                        $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-doc">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M5 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1" />
                                                                <path d="M20 16.5a1.5 1.5 0 0 0 -3 0v3a1.5 1.5 0 0 0 3 0" />
                                                                <path d="M12.5 15a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1 -3 0v-3a1.5 1.5 0 0 1 1.5 -1.5" />
                                                            </svg>
                                                                ';
                                    } else if ($ext === 'ppt' || $ext === 'pptx') {
                                        $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange icon icon-tabler icons-tabler-outline icon-tabler-file-type-ppt">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M11 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                <path d="M16.5 15h3" />
                                                                <path d="M18 15v6" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                            </svg>
                                                                ';
                                    } else if ($ext === 'xls' || $ext === 'xlsx') {
                                        $icon = '
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green icon icon-tabler icons-tabler-outline icon-tabler-file-type-xls">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                <path d="M4 15l4 6" />
                                                                <path d="M4 21l4 -6" />
                                                                <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                                                                <path d="M11 15v6h3" />
                                                            </svg>
                                                                ';
                                    } else {
                                        $icon = '
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary icon icon-tabler icons-tabler-outline icon-tabler-file-type-png">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                                            </svg>';
                                    }
                                ?>
                                    <div class="col-12 mb-0">
                                        <a href='<?= url($path) ?>' target='_blank' class="mb-1">
                                            <?= $icon ?>&nbsp;<?= shortname($nama, 20) ?>
                                        </a>
                                    </div>
                                <?php
                                endforeach;
                                ?>

                            </div>

                            <div class="col-12">
                                <div class="text-muted small">Deskripsi :</div>
                                <div class="fw-semibold"><?= !empty($data['deskripsi']) ? nl2br(htmlspecialchars($data['deskripsi'])) : '-' ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-blur fade" id="modalTambahPeserta" tabindex="-1" aria-labelledby="modalTambahPesertaLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <form action="<?= url('?page=upload-bukti-arsip-saya') ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahPesertaLabel">Tambah Peserta</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="arsip_peserta_id" value="<?= $data['arsip_peserta_id'] ?>">
                                <input type="hidden" name="arsip_id" value="<?= $data['arsip_id'] ?>">

                                <div class="mb-3">
                                    <label class="form-label">Pilih File Bukti</label>
                                    <input type="file" name="file[]" class="form-control" multiple required>
                                    <small class="text-muted">
                                        Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, JPEG, PNG, GIF, WEBP. Maksimal 5MB per file.
                                    </small>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">

                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">

                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">File Bukti Saya</h3>
                        <div class="card-actions">
                            <a href="#" class="btn btn-primary btn-3" data-bs-toggle="modal" data-bs-target="#modalTambahPeserta">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-upload">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 9l5 -5l5 5" />
                                    <path d="M12 4l0 12" />
                                </svg>
                                Upload Bukti
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="jenisArsipTable" class="table table-vcenter table-selectable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center w-1">No</th>
                                        <th>Nama File</th>
                                        <th class="text-center" style="width: 0px;">Tanggal Upload</th>
                                        <th class="text-center w-1">Tipe</th>
                                        <th class="text-center w-1">Ukuran</th>
                                        <th class="text-center w-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($files)): ?>
                                        <?php foreach ($files as $i => $d): ?>
                                            <tr>
                                                <td class="text-center"><?= $i + 1 ?></td>

                                                <td>
                                                    <div class="fw-semibold">
                                                        <?= htmlspecialchars($d['nama_file'] ?? '-') ?>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <?= !empty($d['uploaded_at']) ? date('d M Y H:i', strtotime($d['uploaded_at'])) : '-' ?>
                                                </td>

                                                <td class="text-center">
                                                    <span class="badge bg-secondary-lt text-uppercase">
                                                        <?= htmlspecialchars($d['tipe_file'] ?? '-') ?>
                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                    <?= formatFileSize($d['ukuran_file'] ?? 0) ?>
                                                </td>



                                                <td class="text-center">
                                                    <div class="btn-group w-100">

                                                        <a href="<?= url($d['path_file']) ?>" target="_blank" class="text-primary me-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                            </svg>
                                                        </a>
                                                        <a href="javascript:void(0)" class="text-red"
                                                            onclick="confirmDeleteBukti(
                                                        '<?= url('?page=hapus-bukti-arsip-saya') ?>',
                                                        '<?= $d['id'] ?>',
                                                        '<?= $data['arsip_id'] ?>',
                                                        '<?= htmlspecialchars(addslashes($d['nama_file'] ?? 'File ini')) ?>'
                                                    )">

                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<div class="modal fade" id="modalEditPeserta<?= $d['id'] ?>" tabindex="-1" aria-labelledby="modalEditPesertaLabel<?= $d['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="<?= url('?page=update-peserta-arsip') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPesertaLabel<?= $d['id'] ?>">
                        Ganti Peserta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <input type="hidden" name="arsip_id" value="<?= $data['id'] ?>">

                    <div class="mb-3">
                        <input
                            type="text"
                            class="form-control search-edit-pegawai"
                            placeholder="Cari nama / NIP / jabatan pegawai..."
                            data-target="pegawaiListEdit<?= $d['id'] ?>">
                    </div>

                    <div class="list-group" id="pegawaiListEdit<?= $d['id'] ?>" style="max-height: 400px; overflow-y: auto;">

                        <?php
                        // supaya peserta yang sedang dipakai tetap muncul
                        $pegawaiGabungan = $pegawai;

                        $sudahAda = false;
                        foreach ($pegawaiGabungan as $pg) {
                            if ((int)$pg['id'] === (int)$d['pegawai_id']) {
                                $sudahAda = true;
                                break;
                            }
                        }

                        if (!$sudahAda) {
                            $pegawaiGabungan[] = [
                                'id' => $d['pegawai_id'],
                                'nama' => $d['nama'],
                                'nip' => $d['nip'],
                                'jabatan' => $d['jabatan']
                            ];
                        }
                        ?>

                        <?php foreach ($pegawaiGabungan as $p) : ?>
                            <?php $checked = ((int)$p['id'] === (int)$d['pegawai_id']); ?>

                            <label class="list-group-item pegawai-item-edit cursor-pointer">
                                <div class="d-flex align-items-center">
                                    <input
                                        class="form-check-input me-3"
                                        type="radio"
                                        name="pegawai_id"
                                        value="<?= $p['id'] ?>"
                                        <?= $checked ? 'checked' : '' ?>
                                        required>

                                    <div class="flex-fill">
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($p['nama'] ?? '-') ?>
                                        </div>

                                        <small class="text-muted d-block">
                                            NIP: <?= htmlspecialchars($p['nip'] ?? '-') ?>
                                        </small>

                                        <small class="text-muted d-block">
                                            Jabatan: <?= htmlspecialchars($p['jabatan'] ?? '-') ?>
                                        </small>
                                    </div>

                                    <?php if ($checked): ?>
                                        <i class="ti ti-check text-success fs-4"></i>
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-device-floppy"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDeleteBukti(url, id, arsipId, label = '') {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            html: label ?
                `File <strong>${label}</strong> akan dihapus` : 'File akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = id;

                const inputArsip = document.createElement('input');
                inputArsip.type = 'hidden';
                inputArsip.name = 'arsip_id';
                inputArsip.value = arsipId;

                form.appendChild(inputId);
                form.appendChild(inputArsip);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchPegawai");
        const items = document.querySelectorAll(".pegawai-item");

        if (searchInput) {
            searchInput.addEventListener("keyup", function() {
                const keyword = this.value.toLowerCase();

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(keyword) ? "" : "none";
                });
            });
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = new DataTable('#jenisArsipTable', {
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            orderCellsTop: true,

            language: {
                search: "Cari:",
                lengthMenu: "_MENU_ &nbsp;data",
                info: "_START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Tidak ada data",
            },
        });

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const spinner = document.getElementById("spinner");
        const pageContent = document.getElementById("page-content");

        window.addEventListener("load", function() {
            spinner.style.display = "none";
            pageContent.style.display = "block";
        });
    });
</script>

<?php if (isset($_SESSION['flash'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            Swal.fire({
                icon: '<?= $_SESSION['flash']['status'] ?>',
                title: <?= $_SESSION['flash']['status'] === 'success'
                            ? "'Berhasil!'"
                            : "'Gagal!'" ?>,
                text: <?= json_encode($_SESSION['flash']['message']) ?>,
                timer: 1000
            });

        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkAllBtn = document.getElementById("checkAllPegawai");
        const uncheckAllBtn = document.getElementById("uncheckAllPegawai");

        if (checkAllBtn) {
            checkAllBtn.addEventListener("click", function() {
                document.querySelectorAll(".pegawai-checkbox").forEach(cb => {
                    if (cb.closest(".pegawai-item").style.display !== "none") {
                        cb.checked = true;
                    }
                });
            });
        }

        if (uncheckAllBtn) {
            uncheckAllBtn.addEventListener("click", function() {
                document.querySelectorAll(".pegawai-checkbox").forEach(cb => {
                    cb.checked = false;
                });
            });
        }
    });
</script>

<?php
// Simpan konten ke variabel
$content = ob_get_clean();

// Load layout utama
require __DIR__ . '/../layouts/main.php';
