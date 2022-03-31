<?php

namespace Core;

class ControllerAbstract
{
    protected $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT.'/app/templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
    }


}