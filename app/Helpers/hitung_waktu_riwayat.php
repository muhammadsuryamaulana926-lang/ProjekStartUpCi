<?php

if (!function_exists('time_ago')) {
    function time_ago($timestamp)
    {
        $time_ago = strtotime($timestamp);
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);

        if ($seconds <= 60) {
            return "Baru saja";
        } else if ($minutes <= 60) {
            return $minutes == 1 ? "1 menit yang lalu" : "$minutes menit yang lalu";
        } else if ($hours <= 24) {
            return $hours == 1 ? "1 jam yang lalu" : "$hours jam yang lalu";
        } else if ($days <= 7) {
            return $days == 1 ? "Kemarin" : "$days hari yang lalu";
        } else if ($weeks <= 4.3) {
            return $weeks == 1 ? "1 minggu yang lalu" : "$weeks minggu yang lalu";
        } else if ($months <= 12) {
            return $months == 1 ? "1 bulan yang lalu" : "$months bulan yang lalu";
        } else {
            return $years == 1 ? "1 tahun yang lalu" : "$years tahun yang lalu";
        }
    }
}
