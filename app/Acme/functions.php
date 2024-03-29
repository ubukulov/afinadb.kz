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

function blockAllEducation($request_uri){
    $arr = [
        'education', 'internship-training', 'manager-training', 'leadership-training', 'private', 'training-from-to', 'testing', 'literature-for-self-development'
    ];
    if (in_array($request_uri, $arr)) {
        return true;
    }
    return false;
}

function recursive($number) {
    if (strlen($number) == 1) {
        return $number;
    } else {
        $number = $number."";
        $n = $number[0] + $number[1]."";
        while (strlen($n) > 1) {
            $n = $n[0] + $n[1];
        }
        return $n;
    }
}
