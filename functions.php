<?php
$productPrice = 12;
$discount = 20;

$productPrice2 = 13;
$dicount2 = 30;

$finalPrice = getFinalPrice($productPrice, $discount);
$finalPrice2 = getFinalPrice($productPrice2, $discount2);

echo '<div class="price">'.$finalPrice. '</div>div>';

function getFinalPrice($price, $discount){
    $finalPrice = $price * ((100 - $discount)/100);
    return $finalPrice;
}