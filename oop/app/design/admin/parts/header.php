<html>
<head>
    <title><?= $this->data['title'] ?></title>
    <meta name="description" content="<?= $this->data['meta_desc'] ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL_WO_INDEX.'css/admin.css'; ?>">
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
                <a href="<?php echo $this->url('admin/users') ?>">vartotojai</a>
            </li>

                <li>
                    <a href="<?php echo $this->url('admin/ads') ?>">skelbimai</a>
                </li>
                <li>
                    <a href="<?php echo $this->url('user/logout') ?>">Atsijungti</a>
                </li>
        </ul>
    </nav>
</header>