<?php

$array = [1, 3, 4, 6, 9 ,2, 3, 4, 5, 5, 7, 8, 9, 10, 1, 4, 5,34, 23, 1, 4, 6, 77, 3, 9];
$sum = 0;
$n = count($array);
$avg = array_sum($array) / $n;


$lowerArray = [];
$higherArray = [];
    foreach ($array as $key=>$value){
        if($value < $avg){
            $lowerArray[] = $value;
        } else {
            $higherArray [] = $value;
        }
    }
$n = count($lowerArray);
    $lowAvg = array_sum($lowerArray) / $n;
$n = count($higherArray);
$highSum = 0;
    $highAvg = array_sum($higherArray) / $n;
echo $lowAvg. ' ir '. $highAvg;