<?php
declare(strict_types=1);

namespace Core;

class Router
{

    public function getRouteInfo(): array
    {
        $allowedControllers = ['user', 'api', 'news'];

        if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '/') {
            $pathInfo = strtolower(trim($_SERVER['PATH_INFO'], '/'));
            $pathInfo = explode('/', $pathInfo);
            $slug = $pathInfo[0] ?? null;
            if (in_array($slug, $allowedControllers)) {
                $controller = $slug;
                $method = $pathInfo[1] ?? 'index';
                $param = $pathInfo[2] ?? null;
            } else {
                $controller = 'news';
                $method = 'show';
                $param = $slug;
            }
        } else {
            $controller = 'home';
            $method = 'index';
            $param = null;
        }
        return [$controller, $method, $param];
    }
}
