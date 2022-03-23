<div class="wrapper">
    <?php foreach ($this->data['messages'] as $message): ?>
        <?php  $class = $message->getUserFrom() == $_SESSION['user_id'] ? 'my' :   'him'; ?>
        <div class="message-box <?= $class ?>" >
            <div class="message-content">
                <?= $message->getMessage() ?>
            </div>
            <div class="date">
                <?= $message->getDate() ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="chat-box">
        <form action="<?= $this->url('messages/send') ?>" method="POST">
            <div>
                <textarea name="message"></textarea>
                <input type="hidden" name="user_to" value="<?= $this->data['user_to'] ?>">
            </div>
            <input type="submit" value="Send" class="btn submit">
        </form>
    </div>
</div>
