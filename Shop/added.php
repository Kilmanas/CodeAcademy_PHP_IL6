<?php
include 'helper.php';
//$id = $_POST['id'];
$name = $_POST['name'];
$sku = $_POST['sku'];
$qty = $_POST['qty'];
$price = $_POST['price'];


$data[] = [$id, $name, $sku, $qty, $price];
writeToCsv($data, 'products.csv');

echo 'Added!';