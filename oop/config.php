<?php

define ('BASE_URL', 'http://localhost/pamokos/oop/index.php/');
define ('SERVERNAME', 'localhost');
define ('DB_USER', 'root');
define ('DB_PASSWORD', '');
define ('DB_NAME', 'vagiult');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/app/templates');
$GLOBALS['twig'] = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/var/cache',
    'debug' => true,
]);
$GLOBALS['twig']->addExtension(new \Twig\Extension\DebugExtension());
