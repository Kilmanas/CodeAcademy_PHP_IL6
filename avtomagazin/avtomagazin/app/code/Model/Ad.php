<?php
namespace Model;

use Helper\DBHelper;

Class Ad
{
    private $id;
    private $title;
    private $description;
    private $manufacturer_id;
    private $model_id;
    private $price;
    private $year;
    private $type_id;
    private $user_id;

    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
    return $this->title;
    }


    public function setTitle($title): void
    {
    $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }
    public function getManufacturerId()
    {
        return $this->manufacturer_id;
    }

    /**
     * @return mixed
     */
    public function getModelId()
    {
        return $this->model_id;
    }

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }

    /**
     * @param mixed $manufacturer_id
     */
    public function setManufacturerId($manufacturer_id): void
    {
        $this->manufacturer_id = $manufacturer_id;
    }

    /**
     * @param mixed $model_id
     */
    public function setModelId($model_id): void
    {
        $this->model_id = $model_id;
    }

    /**
     * @param mixed $type_id
     */
    public function setTypeId($type_id): void
    {
        $this->type_id = $type_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function save()
    {
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }
    private function create()
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturer_id,
            'model_id' => $this->model_id,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id
        ];

        $db = new DBHelper();
        $db->insert('ad', $data)->exec();
    }
    public function load($id)
    {
        $db = new DBHelper();
        $ad = $db->select()->from('ad')->where('id', $id)->getOne();
        if(!empty($ad)){
            $this->id = $ad['id'];
            $this->title = $ad['title'];
            $this->manufacturerId = $ad['manufacturer_id'];
            $this->modelId = $ad['model_id'];
            $this->price = $ad['price'];
            $this->year = $ad['year'];
            $this->typeId = $ad['type_id'];
            $this->userId = $ad['user_id'];
        }
        return $this;
    }
    public static function getAllAds()
    {
        $db = new DBHelper();
        $data = $db->select('id')->from('ad')->get();
        $ads = [];
        foreach ($data as $element){
            $ad = new Ad();
            $ad->load($element['id']);
            $ads[]= $ad;
        }
        return $ads;
    }
    public function update()
    {
        $db = new DBHelper();
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturerId,
            'model_id' => $this->modelId,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->typeId,
            ];

        $db->update('ad', $data)->where('id', $this->id)->exec();
    }
}