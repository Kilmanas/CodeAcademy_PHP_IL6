<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\CsvParser;
use Helper\Url;
use Model\Ad;

class Import extends AbstractController
{

    public function execute()
    {
        $csvPath = PROJECT_ROOT_DIR . '/var/import/data.csv';
        $adsArray = CsvParser::parseCsv($csvPath);
        if ($adsArray !== FALSE) {
            foreach ($adsArray as $adData) {
                $ad = new Ad();
                $slug = Url::slug($adData['title']);
                while (!Ad::valueUniq('slug', $slug)) {
                    $slug = $slug . rand(0, 100);
                }
                $ad->setTitle($adData['title']);
                $ad->setDescription($adData['description']);
                $ad->setYear($adData['years']);
                $ad->setManufacturerId($adData['manufacturer_id']);
                $ad->setModelId($adData['model_id']);
                $ad->setPrice($adData['price']);
                $ad->setPictureUrl($adData['image']);
                $ad->setActive(1);
                $ad->setCount(0);
                $ad->setSlug($slug);
                $ad->setTypeId($adData['type_id']);
                $ad->setUserId($_SESSION['user_id']);
                $ad->save();
            }
            unlink($csvPath);
        } else {
            echo 'Nera tinkamo csv failo.';
        }
    }
}

