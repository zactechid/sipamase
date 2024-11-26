<?php
if (!function_exists('durasi_posisi')) {
    function durasi_posisi(string $time, int $durasi = 5) {
        $awal = date_create($time);
        $akhir = date_create();
        $diff = date_diff($awal, $akhir);
        if ($diff->y == 0) {
            if ($diff->m == 0) {
                if($diff->d == 0) {
                    if ($diff->h < $durasi) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}