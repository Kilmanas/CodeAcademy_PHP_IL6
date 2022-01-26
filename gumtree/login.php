<?php
include 'functions.php';
$email = $_POST['email'];
$userPassword = $_POST['password'];
$userHashPass = hashPassword($userPassword);
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "car_ad";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$sql = 'SELECT * FROM users WHERE email ="'.$email.'" AND password = "'.$userHashPass.'"';
$rez = $conn->query($sql);
$user = $rez->fetchAll();

if (!empty($user)){
    echo 'Succsex';
}else{
    echo 'Wrong email and/or password';
}