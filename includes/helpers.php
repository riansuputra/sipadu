<?php
function tgl_sekarang()
{
    $formatter = new IntlDateFormatter(
        'id_ID',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE
    );

    return $formatter->format(new DateTime());
}

function shortName($text, $limit = 20)
{
    return strlen($text) > $limit
        ? substr($text, 0, $limit) . '...'
        : $text;
}

function umurTahun($tanggalLahir)
{
    if (empty($tanggalLahir)) return '-';

    return (new DateTime($tanggalLahir))
        ->diff(new DateTime())
        ->y;
}


function statusPensiunSingkat($tanggalLahir, $usiaPensiun = 58)
{
    if (empty($tanggalLahir)) return '-';

    $lahir = new DateTime($tanggalLahir);
    $tglPensiun = (clone $lahir)->modify("+{$usiaPensiun} years");
    $now = new DateTime();

    $tahunPensiun = $tglPensiun->format('Y');

    if ($now >= $tglPensiun) {
        return "Sudah pensiun ({$tahunPensiun})";
    }

    $diff = $now->diff($tglPensiun);

    if ($diff->y >= 5) {
        return "> 5 tahun ({$tahunPensiun})";
    }

    if ($diff->y >= 1) {
        return "{$diff->y} th ({$tahunPensiun})";
    }

    return "{$diff->m} bln ({$tahunPensiun})";
}
