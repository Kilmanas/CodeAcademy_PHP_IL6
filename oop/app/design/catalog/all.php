


        <?php foreach ($this->data['ads'] as $ad): ?>
            <div class="box">
        <div class="title"><a href="<?php echo $this->url('catalog/show', $ad->getSlug()) ?>"><?php echo $ad->getTitle() . ' '; ?></a></div>
        <div class="price">
            <?php echo $ad->getPrice() . '&#128 '; ?></div>
            <div class="year"> <?php echo $ad->getYear() . ' '; ?></div>
           <img class="thumbnail" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'" alt=""><br>



    </div>

<?php endforeach; ?>
<div class="pagination">
    <?php $pages = ceil($this->data['count'] / 5); ?>
    <?php for($i = 1; $i <= $pages; $i++): ?>

    <a href="<?= $this->url('catalog').'?p='.$i;?>"><?= $i ?> </a>

        <?php endfor; ?>

</div>

