<h2>Naujausi skelbimai</h2>


        <?php foreach ($this->data['latest'] as $ad): ?>
            <div class="newest-box">
                <a href="<?php echo $this->url('catalog/show', $ad->getSlug()) ?>"><?php echo $ad->getTitle() . ' '; ?></a>

           <?php echo $ad->getPrice() . '&#128 '; ?>
            <?php echo $ad->getYear() . ' '; ?>
            <img class="thumbnail" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'">


    </div>
    <?php endforeach; ?>


<h2>Populiariausi skelbimai</h2>


       <?php foreach ($this->data['popular'] as $ad): ?>
           <div class="popular-box">
                <a href="<?php echo $this->url('catalog/show', $ad->getSlug()) ?>"><?php echo $ad->getTitle() . ' '; ?></a>

         <?php echo $ad->getPrice() . '&#128 '; ?>
           <?php echo $ad->getYear() . ' '; ?>
            <img class="thumbnail" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'">

    </div>
    <?php endforeach; ?>

