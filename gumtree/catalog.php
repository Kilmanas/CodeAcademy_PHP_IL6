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
    echo '<div class="wrapper">';

    foreach ($ads as $ad) {
        echo '<div class="content-box">';
        echo '<div class="title">Title: '.$ad['title'].'</div>';
        echo '<div class="price">Price: '.$ad['price'].'</div>';
        echo '<div class="year">Year: '.$ad['year'].'</div>';
        echo '<a href="http://localhost/pamokos/gumtree/ad.php?id='.$ad['id'].'">More</a>';
        echo '</div>';

    }
echo '</div>';




include 'parts/footer.php';
