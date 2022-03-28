<?php

$array = [1000, 2303, 444, 5554, 9993, 45454, 4343, 65656, 65659, 43434, 92, 23456, 758595, 344433];
$rez = 0;
for ($i = 0; $i < count($array); $i++) {
    if ($rez < $array[$i] && $array[$i] % 2 == 0)
        $rez = $array[$i];
}
$key = array_search ($rez, $array);
$rez = $rez * 0.6;
$array[$key] = $rez;
echo '<pre>';
print_r($array);