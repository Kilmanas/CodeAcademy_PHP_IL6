<?php
namespace Model;

use Helper\DBHelper;

Class Manufacturer
{
    private $id;

    private $manufacturer;

    public function getId()
    {
        return $this->id;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $manufacturer = $db->select()->from('manufacturer_id')->where('id',$id)->getOne();
        $this->id = $manufacturer['id'];
        $this->manufacturer = $manufacturer['manufacturer'];
        return $this;
    }
    public static function getManufacturers()
    {
        $db = new DBHelper();
        $data = $db->select()->from("manufacturer_id")->get();
        $manufacturers = [];
        foreach ($data as $element) {
            $manu = new Manufacturer();
            $manu->load($element['id']);
            $manufacturers[] = $manu;
        }
        return $manufacturers;
    }

}