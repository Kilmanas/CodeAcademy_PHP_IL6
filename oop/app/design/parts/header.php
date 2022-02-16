<html>
<head>
    <title>Vagiu.lt</title>
    <link rel="stylesheet" href="<?php echo BASE_URL_WO_INDEX.'css/style.css'; ?>">
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
                <a href="<?php echo $this->url('catalog/all') ?>">Skelbimai</a>
            </li>
            <?php if($this->isUserLoged()): ?>
                <li>
                    <a href="<?php echo $this->url('catalog/add') ?>">Pridėti</a>
                </li>
                <li>
                    <a href="<?php echo $this->url('user/logout') ?>">Atsijungti</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo $this->url('user/login') ?>">Prisijungti</a>
                </li>
                <li>
                    <a href="<?php echo $this->url('user/register') ?>">Registruotis</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>