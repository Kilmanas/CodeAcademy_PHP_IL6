<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "car_ad";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Add submitted";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if(isset($_POST['create'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $price = $_POST['price'];
    $manufacturer_id = $_POST['manufacturer'];
    $year = $_POST['year'];

    $sql = 'INSERT INTO ad (title, description, manufacturer_id, model_id, price, year, type_id, user_id)
            VALUES("'.$title.'", "'.$content.'", "'.$manufacturer_id.'", 1, '.$price.', '.$year.', 1, 1)';
    $conn->query($sql);
}