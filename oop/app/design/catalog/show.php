<div class="list-wrapper">
    <div>

        <li> <?php $ad = $this->data['ad'];
            $ad->getId() . '<br>'; ?>
        <li><?= $ad->getTitle(); ?></li>
        <li><?= $ad->getDescription(); ?></li>
        <li><?= $this->manufacturer->getManufacturer(); ?></li>
        <li><?= $this->model->getModel(); ?></li>
        <li><?= $ad->getVin(); ?></li>
        <li><?= $ad->getPrice() . '&#128'; ?></li>
        <li><?= $ad->getYear(); ?></li>
        <li><?= $this->type->getType(); ?></li>
        <li><?= $this->data['author']->getName().' '. $this->data['author']->getLastName(); ?>
        <a href="<?= $this->url('messages/chat', $this->data['author']->getId()) ?>">Siųsti žinutę</a></li>
        <li><?= $this->data['author']->getPhone(); ?></li>
        <li><img class="post_img" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'"></li>
            <?php
            $id = $ad->getId();
            \Model\Ad::viewCount($id);
            ?>
        </li>
    </div>
</div>


    </ol>
    <span>Skelbimo įvertinimas(<?= $this->data['rating_count'] ?>)</span>
    <?= $this->data['ad_rating'] ?>
    <div class="rating">
        <form action="<?= $this->url('catalog/rate') ?>" method="post">
        <input type="hidden" name="ad_id" value="<?= $ad->getId(); ?>">
            <p>Įvertinkite skelbimą</p>
            <?php for($i = 1; $i <= 5; $i++ ): ?>
        <input type="radio"
               <?php if($this->data['rated'] && $this->data['user_rate'] == $i): ?>
               checked
                <?php endif;; ?>
               id="rank<?= $i ?>" value="<?= $i ?>" name="rank">
            <?php endfor; ?>
            <br>
    </div>
        <input type="submit" value="Pateikti"><br>
        </form>
<div class="favourites=wrapper">
    <?php if($this->data['favorites']): ?>
    <form action="<?= $this->url('catalog/removeFavorite') ?>" method="post">
        <input type="hidden" name="ad_id" value="<?= $ad->getId(); ?>">
        <input type="submit" value="pašalinti iš įsimintų">
    </form>
        <?php else: ?>
        <form action="<?= $this->url('catalog/addToFavorites') ?>" method="post">
            <input type="hidden" name="ad_id" value="<?= $ad->getId(); ?>">
            <input type="submit" value="Įsiminti skelbimą">
        </form>
        <?php endif; ?>


</div>



</div>
<div class="comments-wrapper">
    <h2>Komentarai</h2>
    <?php
    /**
     * @var \Model\Comment $comment
     */
    ?>
    <ul>
        <?php foreach ($this->data['comments'] as $comment): ?>
            <li>
                <div class="comment">
                    <div class="comment-user"><?= $comment->getUser($comment->getUserId())->getName().
                        ' '.$comment->getUser($comment->getUserId())->getLastName(); ?></div>
                    <div class="comment-date"><?= $comment->getCreatedAt(); ?></div>
                    <div class="comment-comment"><?= $comment->getComment(); ?></div>
                </div>
            </li>
        <br>
        <?php endforeach; ?>
    </ul>
    <?php if ($this->isUserLoged()): ?>
        <div class="comment-form-wrapper">
            <?= $this->data["comment_form"]; ?>
        </div>
    <?php endif; ?>
