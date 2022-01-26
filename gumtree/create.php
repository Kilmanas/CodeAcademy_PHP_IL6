<?php include 'parts/header.php';
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
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$sql = 'SELECT * FROM manufacturer_id';
$rez = $conn->query($sql);
$manufacturers = $rez->fetchAll();
$sql = 'SELECT * FROM model_id';
$rez = $conn->query($sql);
$models = $rez->fetchAll();
$sql = 'SELECT * FROM type_id';
$rez = $conn->query($sql);
$types = $rez->fetchAll();
// nedaryti pabaiga
?>
    <form action="submitad.php" method="post">
        <input type="text" name="title" placeholder="title"><br>
        <textarea name="content">
            </textarea><br>
        <select name="manufacturer">
            <?php foreach ($manufacturers as $manufacturer) {
                echo '<option value="' . $manufacturer['id'] . '">' . $manufacturer['manufacturer'] . '</option>';
            } ?>
        </select><br>
        <select name="model">
            <?php foreach ($models as $model) {

                echo '<option value="' . $model['id'] . '">' . $model['model'] . '</option>';
            } ?>
        </select><br>
        <select name="bodyType">
            <?php foreach ($types as $type) {
                echo '<option value="' . $type['id'] . '">' . $type['type'] . '</option>';
            } ?>
        </select><br>
        <input type="number" name="price" placeholder="price"><br>
        <select name="year">
            <?php for ($i = 1980; $i <= date('Y'); $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            } ?>
        </select>
        <br>
        <input type="submit" value="create" name="create">
    </form>
<?php include 'parts/footer.php'; ?>