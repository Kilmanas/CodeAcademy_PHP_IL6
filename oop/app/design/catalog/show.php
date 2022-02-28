<div class="list-wrapper">
    <ol>

        <li> <?php $ad = $this->data['ad'];
            $ad->getId() . '<br>';
            echo $ad->getTitle() . '<br>';
            echo $ad->getDescription() . '<br>';
            echo $this->manufacturer->getManufacturer() . '<br>';
            echo $this->model->getModel() . '<br>';
            echo $ad->getVin() . '<br>';
            echo $ad->getPrice() . '&#128' . '<br>';
            echo $ad->getYear() . '<br>';
            echo $this->type->getType() . '<br>';
            echo $ad->getUserId() . '<br>';?>
            <img class="post_img" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'"><br>
            <?php
            $id = $ad->getId();
            \Model\Ad::viewCount($id);
            ?>

        </li>

    </ol>
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
</div>
