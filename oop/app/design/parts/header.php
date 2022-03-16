<html>
<head>
    <title><?= $this->data['title'] ?></title>
    <meta name="description" content="<?= $this->data['meta_desc'] ?>">
    <link rel="stylesheet" href="<?php echo $this->staticUrl('css/style.css') ?>">
</head>
<body>
<header>
    <div class="header_top">vagiu.lt || Didžiausias vogtų automobilių skelbimų portalas</div>
    <nav>
        <ul>
            <li>
                <a href="<?php echo $this->url('') ?>">Titulinis</a>
            </li>
            <li>
                <a href="<?php echo $this->url('catalog') ?>">Skelbimai</a>
            </li>
            <?php if($this->isUserLoged()): ?>
                <li>
                    <a href="<?php echo $this->url('catalog/add') ?>">Pridėti</a>
                </li>
                <li>
                    <a href="<?php echo $this->url('user/logout') ?>">Atsijungti</a>
                </li>
                <li>
                    <a href='<?= $this->url('messages') ?>'>Žinutės (<?= $this->newMessageCount() ?>)</a>
                </li>
            <li>
                <a href="<?= $this->url('catalog/favorites') ?>">Įsiminti skelbimai</a>
            </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo $this->url('user/login') ?>">Prisijungti</a>
                </li>
                <li>
                    <a href="<?php echo $this->url('user/register') ?>">Registruotis</a>
                </li>
            <?php endif;
            if($this->isUserAdmin()): ?>
            <li>
                <a href="<?php echo $this->url('admin') ?>">admin</a>
            </li>
            <?php endif; ?>

        </ul>
    </nav>
</header>