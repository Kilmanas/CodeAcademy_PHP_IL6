<?php


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
$id = $_GET['id'];
$sql = "SELECT * FROM ad WHERE id=$id" ;
$rez = $conn->query($sql);
$ads= $rez->fetchAll();
$sql = "SELECT * FROM manufacturer_id" ;
$rez = $conn->query($sql);
$mans = $rez->fetchAll();
$sql = "SELECT * FROM type_id" ;
$rez = $conn->query($sql);
$types = $rez->fetchAll();




foreach ($ads as $ad) {
    foreach ($types as $type){
        if ($ad['type_id'] === $type['id']){
            $type = $type['type'];
            foreach ($mans as $man) {
                if ($ad['manufacturer_id'] === $man['id']) {
                    $manufacturer = $man['manufacturer'];
                    echo "<table>";
                    echo "<tr><td>Title</td><td>Description</td><td>Manufacturer</td><td>Model</td><td>Body type</td><td>Year</td><td>Price</td></tr>
                    <tr><td>" . $ad['title'] . "</td><td>" . $ad['description'] . "</td><td>" . $manufacturer . "</td><td>" . $ad['model_id'] . "</td><td>" . $type . "</td><td>" . $ad['year'] . "</td><td>" . $ad['price'] . "&#8364</td></tr>";
                 }
            }
        }
    }
}

echo "</table>";