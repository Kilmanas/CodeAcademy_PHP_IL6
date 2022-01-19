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
$sql = 'SELECT * FROM cities';
$rez = $conn->query($sql);
$cities = $rez->fetchAll();
// nedaryti pabaiga
?>

<form action="submituser.php" method="post">
        <input type="text" name="name" placeholder="Name"><br>
        <input type="text" name="lastName" placeholder="Last name"><br>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="password" name="password1" placeholder="Password"><br>
        <input type="password" name="password2" placeholder="Repeat password"><br>
        <input type="tel" name="phone" placeholder="Phone"><br>
        <select name="city">
        <?php foreach ($cities as $city){
            echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
        }?>
        </select><br>
    <Label for="agree_terms">Agree Terms & Conditions</Label>
        <input type="checkbox" name="agree_terms" id="agree_terms"><br>
        <input type="submit" value="create" name="create">
    </form>
<?php
include 'parts/footer.php'; ?>

