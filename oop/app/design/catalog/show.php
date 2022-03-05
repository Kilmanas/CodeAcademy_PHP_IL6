<div class="list-wrapper">
    <ol>

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
        <a href="<?= $this->url('messages/create', $ad->getUserId()) ?>">Siųsti žinutę</a></li>
        <li><?= $ad->getUser($ad->getUserId())->getPhone(); ?></li>
        <li><img class="post_img" src="<?php echo $ad->getPictureUrl() ?>" onerror="this.style.display='none'"></li>
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
