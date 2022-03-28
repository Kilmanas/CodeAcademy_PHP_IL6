<?php
namespace Model;

use Helper\DBHelper;

Class Model
{
    private $id;

    private $model;

    private $manufacturer_id;

    public function getModel()
    {
        return $this->model;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getManufacturerId()
    {
        return $this->manufacturer_id;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $model = $db->select()->from('model_id')->where('id',$id)->getOne();
        $this->id = $model['id'];
        $this->model = $model['model'];
        $this->manufacturer_id = $model['manufacturer_id'];
        return $this;
    }

    public static function getModels()
    {
        $db = new DBHelper();
        $data = $db->select()->from("model_id")->get();
        $models = [];
        foreach ($data as $element) {
            $model = new Model();
            $model->load($element['id']);
            $models[] = $model;
        }
        return $models;
    }





}