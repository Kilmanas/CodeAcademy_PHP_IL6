<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Ad extends AbstractModel
{

    private $title;
    private $description;
    private $manufacturer_id;
    private $manufacturer;
    private $model_id;
    private $model;
    private $price;
    private $year;
    private $type_id;
    private $type;
    private $user_id;
    private $pictureUrl;
    private $active;
    private $slug;
    private $vin;
    private $count;

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count): void
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * @param mixed $vin
     */
    public function setVin($vin): void
    {
        $this->vin = $vin;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl($pictureUrl): void
    {
        $this->pictureUrl = $pictureUrl;
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
     * @param mixed $manufacturer_id
     */
    public function setManufacturerId($manufacturer_id): void
    {
        $this->manufacturer_id = $manufacturer_id;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @return mixed
     */
    public function getModelId()
    {
        return $this->model_id;
    }

    /**
     * @param mixed $model_id
     */
    public function setModelId($model_id): void
    {
        $this->model_id = $model_id;
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param mixed $type_id
     */
    public function setTypeId($type_id): void
    {
        $this->type_id = $type_id;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
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
    public function __construct($id = null)
    {
        $this->table = 'ad';
        if($id !== null){
            $this->load($id);
        }

    }

    public static function getAllAds($page = null, $limit = null)
    {
        $db = new DBHelper();
        $data = $db->select()->from('ad')->orderBy('id');
        if ($limit != null){
            $db->limit($limit);
        }
        if ($page != null){
            $page = ($page - 1) * 5;
            $db->offset($page);
        }
        $data = $db->get();
        $ads = [];
        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }
    public static function getAllActiveAds($page = null, $limit = null)
    {
        $db = new DBHelper();
        $data = $db->select()->from('ad')->where('active', 1)->orderBy('id');
        if ($limit != null){
            $db->limit($limit);
        }
        if ($page != null){
            $page = ($page - 1) * 5;
            $db->offset($page);
        }
        $data = $db->get();
        $ads = [];
        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $ad = $db->select()->from('ad')->where('id', $id)->getOne();
        if (!empty($ad)) {
            $this->id = $ad['id'];
            $this->title = $ad['title'];
            $this->description = $ad['description'];
            $this->vin = $ad['vin'];
            $this->userId = $ad['user_id'];
            $this->slug = $ad['slug'];
            $this->active = $ad['active'];
            $this->manufacturerId = $ad['manufacturer_id'];
            $manufacturer = new Manufacturer();
            $this->manufacturer = $manufacturer->load($this->manufacturerId);
            $this->modelId = $ad['model_id'];
            $model = new Model();
            $this->model = $model->load($this->modelId);
            $this->price = $ad['price'];
            $this->year = $ad['year'];
            $this->typeId = $ad['type_id'];
            $type = new Type();
            $this->type = $type->load($this->typeId);
            $this->pictureUrl = $ad['picture_url'];
            $this->count = $ad['count'];

        }
        return $this;
    }

    public static function getSortedAds($order, $sort)
    {
        $db = new DBHelper();
        $data = $db->select()
            ->from('ad')
            ->where('active', 1)
            ->orderBy($order, $sort)
            ->limit(5)
            ->get();
        $ads = [];
        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public static function viewCount($id)
    {
        $db = new DBHelper();
        $counts = $db->select()->from('ad')->where('id', $id)->getOne();
        foreach ($counts as $count) {
            $count++;
        }
        $data = [
            'count' => $count
        ];
        $db = new DBHelper();
        $db->update('ad', $data)->where('id', $id)->exec();

    }



    public function loadBySlug($slug)
    {
        $db = new DBHelper();
        $rez = $db->select()->from($this->table)->where('slug', $slug)->getOne();
        if (!empty($rez)) {
            $this->load($rez['id']);
            return $this;
        } else {
            return false;
        }
    }

    protected function assignData()
    {
        $this->data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturer_id,
            'model_id' => $this->model_id,
            'vin' => $this->vin,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->type_id,
            'picture_url' => $this->pictureUrl,
            'user_id' => $this->user_id,
            'active' => $this->active,
            'count' => $this->count
        ];

    }

}