<?php
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

    echo $GLOBALS['twig']->render(
        'layout.html.twig',
        $params ?? [],
    );

} else {
    echo $GLOBALS['twig']->render(
        'homepage.html.twig',
        [
            'session' => $_SESSION,
        ]
    );
}
?>
