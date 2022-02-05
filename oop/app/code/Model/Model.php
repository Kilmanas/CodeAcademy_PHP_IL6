<?php
namespace Model;

use Helper\DBHelper;

Class Model
{
    private $id;

    private $model;

    private $manufacture_id;

    public function getModel()
    {
        return $this->model;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getManufactureId()
    {
        return $this->manufacture_id;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $model = $db->select()->from('model_id')->where('id',$id)->getOne();
        $this->id = $model['id'];
        $this->model = $model['model'];
        return $this;
    }

    public static function getModels($manId)
    {
        $db = new DBHelper();
        $data = $db->select()->from("model_id")->where('id',$manId)->get();
        $models = [];
        foreach ($data as $element) {
            $model = new Model();
            $model->load($element['id']);
            $models[] = $model;
        }
        return $models;
    }





}