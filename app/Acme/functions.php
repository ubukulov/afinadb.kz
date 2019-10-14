<?php

function timeCount($a) {
    $b = time();
    $c = strtotime($a);
    $d = $b - $c;
    $e = (int)round($d / (60 * 60 * 24));
    $time = date("H:i", $c);
    if ($e === 0) {
        return "Сег <br>".$time;
    } elseif ($e === 1) {
        return "Вчера <br>".$time;
    } elseif ($e >= 2 && $e <=4) {
        return $e.' дня';
    } else return $e.' дней';
}