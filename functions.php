<?php
//error_reporting(0); 

$DBHost = "localhost";
$DBUser = "id1101836_ikramul";
$DBPass = "aA1!qpzm";
$DBName = "id1101836_projectdb";

$hall = json_decode(file_get_contents('data/hall.json'), 1);
$du = json_decode(file_get_contents('data/du.json'), 1);
$bd = json_decode(file_get_contents('data/bd.json'), 1);

function position($x){
    $suf = array('', 'st', 'nd', 'rd', 'th', 'th');
    if ($x == 0) return 'N/A';
    $a = $x[0] . $suf[$x[0]] . ' Year';
    if ($x[1] == 0) return $a;
    $b = $x[1] . $suf[$x[1]] . ' Semester';
    if ($x[0] == 0) return $b;
    return $a . ', ' . $b;
}
?>