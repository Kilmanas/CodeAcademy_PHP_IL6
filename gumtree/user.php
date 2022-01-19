<?php
include 'functions.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "car_ad";

$name = $_POST['name'];
$surname = $_POST['lastName'];
$email = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$phone = $_POST['phone'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "User registration successful";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
if (isPasswordValid($password1, $password2) &&
    isEmailValid($email)){
    $password = hashPassword($password);
    $email = clearEmail($email);
}

if(isset($_POST['create'])) {


    $sql = 'INSERT INTO users (name, last_name, email, password, phone, city_id)
            VALUES("'.$name.'", "'.$surname.'", "'.$email.'", "'.$password.'", '.$phone.',1)';
    $conn->query($sql);
}
