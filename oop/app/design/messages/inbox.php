<div class="messages">
    <h3>Žinutės</h3>
<?php foreach ($this->data['chat'] as $chat) : ?>
    <div class="message-box">
        <div>
            <?= $chat['chat_friend']->getName().' '.$chat['chat_friend']->getLastName();
            ?>
        </div>
        <div class="message_date">
            <?= $chat['message']->getDate() ?>
        </div>
        <div class="message_content">
           <?= $chat['message']->getMessage() ?>
        </div>
    <div class="read-more">
       <a href="<?= $this->url('messages/chat/'. $chat['chat_friend']->getId()) ?>">Atsakyti</a>
    </div>

    </div>
</div>
<?php endforeach; ?>

