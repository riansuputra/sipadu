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
