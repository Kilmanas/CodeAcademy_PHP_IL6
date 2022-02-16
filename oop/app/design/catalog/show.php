<div class="list-wrapper">
    <ol>

        <li> <?php $ad = $this->data['ad'];
            $ad->getId() . '<br>';
            echo $ad->getTitle() . '<br>';
            echo $ad->getDescription() . '<br>';
            echo $this->manufacturer->getManufacturer() . '<br>';
            echo $this->model->getModel() . '<br>';
            echo $ad->getVin(). '<br>';
            echo $ad->getPrice() . '&#128' . '<br>';
            echo $ad->getYear() . '<br>';
            echo $this->type->getType() . '<br>'; ?>
            <img class="post_img" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'" ><br>
            <?php echo $ad->getUserId() . '<br>';
            $id = $ad->getId();
            \Model\Ad::viewCount($id);
            ?>

        </li>

    </ol>
</div>