<?php

namespace Controller;

use Core\AbstractController;
use Helper\CsvParser;
use Model\Ad;

class Export extends AbstractController
{
    public function exec()
    {
        $ads = Ad::getAllActiveAds();
        $adsArray = [];
        foreach ($ads as $key => $ad) {
            $adsArray[$key]['title'] = $ad->getTitle();
            $adsArray[$key]['description'] = $ad->getDescription();
            $adsArray[$key]['year'] = $ad->getYear();
            $adsArray[$key]['price'] = $ad->getPrice();
            $adsArray[$key]['vin'] = $ad->getVin();
            $adsArray[$key]['image'] = $ad->getPictureUrl();
        }
        $csvPath = PROJECT_ROOT_DIR . '/var/export/ads.csv';
        CsvParser::createCsv($csvPath, $adsArray);
    }

}