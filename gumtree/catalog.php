<?php
include 'parts/header.php';
// taip nedaryti, bet mes darom
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
$sql = 'SELECT * FROM ad';
$rez = $conn->query($sql);
$ads = $rez->fetchAll();
// nedaryti pabaiga

echo "<table>";

    foreach ($ads as $ad){

    echo "<tr><td>ID</td><td>Title</td><td>Description</td><td>Manufacturer</td><td>Model</td><td>Body type</td><td>Year</td><td>Price</td></tr>
            <tr><td>" . $ad['id'] . "</td><td>" . $ad['title'] . "</td><td>" . $ad['description'] . "</td><td>" . $ad['manufacturer_id'] . "</td><td>" . $ad['model_id'] . "</td><td>" . $ad['type_id'] . "</td><td>" . $ad['year'] . "</td><td>" . $ad['price'] ."&#8364</td></tr>";
    }

    echo "</table>";




include 'parts/footer.php';
