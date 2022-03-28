<?php

$array = [1, 3, 4, 6, 9, 2, 3, 4, 5, 5, 7, 8, 9, 10, 1, 4, 5, 34, 23, 1, 4, 6, 77, 3, 9];

$avg = array_sum($array) / count($array);

$lowerArray = [];
$higherArray = [];
foreach ($array as $key => $value) {
    if ($value < $avg) {
        $lowerArray[] = $value;
    } else {
        $higherArray [] = $value;
    }
}
$lowAvg = array_sum($lowerArray) / count($lowerArray);
$highAvg = array_sum($higherArray) / count($higherArray);
if (count ($lowerArray) > count($higherArray)){
    echo 'daugiau mazu';
} else {
    echo 'daugiau dideliu';
}
echo '<pre>';
echo $lowAvg . ' ir ' . $highAvg;