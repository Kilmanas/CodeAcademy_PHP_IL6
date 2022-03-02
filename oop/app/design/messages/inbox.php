<div class="messages">
    <h3>Žinutės</h3>
<?php foreach ($this->data['messages'] as $message) : ?>

            <?php $message->getUser()->getName();
            $message->getUser()->getLastName(); ?>

        </div>
        <div class="message_date">
            <?= $message->getDateSent() ?>
        </div>
        <div class="message_content">
            <p><?= $message->getMessage() ?></p>
        </div>
    </div>
<?php endforeach; ?>

</ol>