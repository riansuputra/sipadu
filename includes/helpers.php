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
