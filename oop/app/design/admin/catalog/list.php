<?php
/**
 * @var \Model\Ad $ad ;
 */
?>
<form action="<?= $this->url('admin/changeAdStatus')?>" method="POST">
<table>
    <tr>
        <th>#</th>
        <th>Id</th>
        <th>Title</th>
        <th>Desc</th>
        <th>Manufacturer</th>
        <th>Model</th>
        <th>Price</th>
        <th>Year</th>
        <th>Type</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php
    foreach ($this->data['ads'] as $ad): ?>
        <tr>
            <td><input name="<?= $ad->getId() ?>" type="checkbox"></td>
            <td><?= $ad->getId(); ?></td>
            <td><?= $ad->getTitle(); ?></td>
            <td><?= $ad->getDescription(); ?></td>
            <td><?= $ad->getManufacturerId(); ?></td>
            <td><?= $ad->getModelId(); ?></td>
            <td><?= $ad->getPrice(); ?></td>
            <td><?= $ad->getYear(); ?></td>
            <td><?= $ad->getTypeId(); ?></td>
            <td><?= $ad->getActive(); ?></td>
            <td>
                <a href="<?= $this->url('admin/adedit', $ad->getId()) ?>">Edit</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
    <input type="submit" name="action" value="Aktyvuoti">
    <input type="submit" name="action" value="Deaktyvuoti">
</form>
