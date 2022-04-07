<?php

namespace Controller;

use Core\ControllerAbstract;
use Service\GetNewsFromApi\WebitNews;
class Api extends ControllerAbstract
{
    public function getNews()
    {
        $obj = new WebitNews();
        $obj->exec();
    }
}