<?php
include 'helper.php';

$id = $_GET['id'];
$product = getProductById($id);

?>
<div class="title">
    <?php echo $product['name']; ?>
</div>
