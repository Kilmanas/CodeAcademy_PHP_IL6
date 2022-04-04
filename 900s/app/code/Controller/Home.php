<?php

namespace Controller;

use Core\ControllerAbstract;

class Home extends ControllerAbstract
{

    public function index()
    {
        $this->twig->display('index.html.twig');
    }
}