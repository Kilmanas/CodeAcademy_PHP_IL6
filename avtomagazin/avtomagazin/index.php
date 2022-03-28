<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'vendor/autoload.php';
include 'config.php';
session_start();
if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/'){
    $path = trim($_SERVER['PATH_INFO'],'/');
    $path = explode('/',$path);
    if (count($path) < 2) {
        echo $GLOBALS['twig']->render('404.html.twig', []);
        exit;
    }
    $class = ucfirst($path[0]);
    $method = $path[1];
    $class = '\Controller\\'.$class;
    if (!class_exists($class)){
        echo $GLOBALS['twig']->render('404.html.twig', []);
        exit;
    }

    $obj = new $class();
    if (!method_exists($obj, $method)) {
        echo $GLOBALS['twig']->render('404.html.twig', []);
        exit;
    }

    if (isset($path[2])){
        $params = $obj->$method($path[2]);
    } else {
        $params = $obj->$method();
    }

    $templateDir = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
    $template = strtolower($path[0] . '_' .$method) . '.html.twig';

    if (!file_exists($templateDir . $template)) {
        $template = 'layout.html.twig';
    }

    echo $GLOBALS['twig']->render($template, $params ?? []);

} else {
    echo $GLOBALS['twig']->render('homepage.html.twig', ['session' => $_SESSION]);
}