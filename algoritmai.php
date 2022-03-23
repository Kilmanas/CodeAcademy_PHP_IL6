<?php

$array = [1, 3, 4, 6, 9 ,2, 3, 4, 5, 5, 7, 8, 9, 10, 1, 4, 5,34, 23, 1, 4, 6, 77, 3, 9];
$sum = 0;
$n = count($array);
for ( $i = 0; $i < $n; $i++){
    $sum += $array[$i];
    $avg = $sum / $n;
}

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
for ( $i = 0; $i < $n; $i++){
    $sum += $lowerArray[$i];
    $lowAvg = $sum / $n;
}
$n = count($higherArray);
for ( $i = 0; $i < $n; $i++) {
    $sum += $higherArray[$i];
    $highAvg = $sum / $n;
}
echo $lowAvg. ' ir '. $highAvg;