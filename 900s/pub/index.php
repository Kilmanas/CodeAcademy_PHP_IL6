<?php

date_default_timezone_set('Europe/Vilnius');

include '../config.php';
include '../vendor/autoload.php';

if(DEBUG_MODE){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$router = new Core\Router();
$launcher = new Core\Launcher();

$launcher->start($router->getRouteInfo());



