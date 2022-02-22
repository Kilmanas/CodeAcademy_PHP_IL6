<?php $pages = ceil($this->data['count'] / 5); ?>
<table>
    <div class="box">
        <tr>
            <th>Pavadinimas</th>
            <th>Kaina</a></th>
            <th>Metai</th>
        </tr>
        <tr><?php foreach ($this->data['ads'] as $ad): ?>
            <td>
                <a href="<?php echo $this->url('catalog/show', $ad->getSlug()) ?>"><?php echo $ad->getTitle() . ' '; ?></a>
            </td>
            <td><?php echo $ad->getPrice() . '&#128 '; ?></td>
            <td><?php echo $ad->getYear() . ' '; ?> </td>
            <td><img class="thumbnail" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'">
            </td>
        </tr>
    </div>
<?php endforeach; ?>
<div class="pagination">

    <?php for($i = 1; $i <= $pages; $i++): ?>

    <a href="<?= $this->url('catalog').'?p='.$i;?>"><?= $i ?> </a>

        <?php endfor; ?>

</div>

