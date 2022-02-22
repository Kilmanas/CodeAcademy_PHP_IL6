<?php


namespace Controller;

use Core\AbstractController;
use Model\Ad;

class Home extends AbstractController
{
    public function index()
    {
        $this->data['latest'] = Ad::getSortedAds('date', 'DESC');
        $this->data['popular'] = Ad::getSortedAds('count', 'DESC');
        $this->render('parts/home');

    }

}