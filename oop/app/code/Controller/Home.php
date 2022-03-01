<?php


namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Model\Ad;

class Home extends AbstractController implements ControllerInterface
{
    public function index()
    {
        $this->data['latest'] = Ad::getSortedAds('date', 'DESC');
        $this->data['popular'] = Ad::getSortedAds('count', 'DESC');
        $this->render('parts/home');

    }

}