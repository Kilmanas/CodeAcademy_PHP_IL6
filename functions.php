<?php
//$productPrice = 12;
//$discount = 20;
//
//$productPrice2 = 13;
//$dicount2 = 30;
//
//$finalPrice = getFinalPrice($productPrice, $discount);
//$finalPrice2 = getFinalPrice($productPrice2, $discount2);
//
//echo '<div class="price">'.$finalPrice. '</div>div>';
//
//function getFinalPrice($price, $discount){
//    $finalPriceWithoutTaxes = $price * ((100 - $discount)/100);
//    $finalPriceWTaxes =
//    return $finalPriceWTaxes;
//}
//function getPriceWithTax($price){
//    return $price * 1.21;
//}
$userEmail = 'labas@krabas.lt';
function clearEmail($email){
    $emailLowercases = strtolower($email);
    return trim($emailLowercases);
}
function isEmailValid($email){
    if (strpos($email, '@')){
    return true;
    }
    return false;
}
if(isEmailValid($userEmail)){
    echo clearEmail($userEmail);
}else{
    echo 'Emailas nevalidus';
}