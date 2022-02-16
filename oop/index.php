<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Vilnius');
include 'vendor/autoload.php';
include 'config.php';
session_start();
if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {
    $path = trim($_SERVER['PATH_INFO'], '/');
    // echo '<pre>';
    $path = explode('/', $path);
//    print_r($path);
    $class = ucfirst($path[0]);
    $method = $path[1];
    $class = '\Controller\\' . $class;
    if (class_exists($class)) {
        $obj = new $class();
        if (method_exists($obj, $method)) {
            if (isset($path[2])) {
                $obj->$method($path[2]);
            } else {
                $obj->$method();
            }

        } else {
           $obj = new \Core\AbstractController();
           $obj->render('parts/404');
        }
    } else {
        $obj = new \Core\AbstractController();
        $obj->render('parts/404');
    }
} else {
    $obj = new \Controller\Home();
    $obj->index();
}