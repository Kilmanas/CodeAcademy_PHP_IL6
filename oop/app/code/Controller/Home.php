<?php


namespace Controller;

use Core\AbstractController;
use Model\Ad;

class Home extends AbstractController
{
    public function index()
    {
        $this->data['ads'] = Ad::getSortedAds('date', 'DESC');
        $this->data['ad'] = Ad::getSortedAds('count', 'DESC');
        $this->render('parts/home');

    }

}