<?php
declare(strict_types=1);
namespace Core;

class Router
{

    public function getRouteInfo() : array
    {
        $allowedControllers = ['user', 'api'];
        if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '/'){
            $pathInfo = strtolower(trim($_SERVER['PATH_INFO'], '/'));
            $pathInfo = explode('/', $_SERVER['PATH_INFO']);
            $slug =  isset($pathInfo[0]) ? $pathInfo[0] : null;
            if(in_array($slug, $allowedControllers)){
                $controller = $slug;
                $method = isset($pathInfo[1]) ? $pathInfo[1] : 'index';
                $param = isset($pathInfo[2]) ? $pathInfo[2] : null;
            }else{
                $controller = 'news';
                $method = 'show';
                $param = $slug;
            }
            $second = $pathInfo[1];
            $third = $pathInfo[2];
        }else {
            $controller = 'home';
            $method = 'index';
            $param = null;
        } return [$controller, $method, $param];
    }
}