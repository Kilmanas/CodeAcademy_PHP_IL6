<?php foreach ($this->data['favorites'] as $ad): ?>
    <div class="box">
        <div class="title"><a href="<?php echo $this->url('catalog/show', $ad->getSlug()) ?>"><?php echo $ad->getTitle() . ' '; ?></a></div>
        <div class="price">
            <?php echo $ad->getPrice() . '&#128 '; ?></div>
        <div class="year"> <?php echo $ad->getYear() . ' '; ?></div>
        <img class="thumbnail" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'" alt=""><br>



    </div>

<?php endforeach; ?>