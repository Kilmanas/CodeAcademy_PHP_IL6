<?php
declare(strict_types=1);

namespace Core;

class Launcher
{

    public function start($routeInfo) : void
    {
        list ($controller, $method, $param) = $routeInfo;

        $controller = ucfirst($controller);
        $controller = '\Controller\\'.$controller;
        $controllerObject = new $controller;
        $controllerObject->$method($param);
    }
}