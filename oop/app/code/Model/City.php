<?php
declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\FormHelper;

Class City extends AbstractModel
{

    private string $name;
    protected const TABLE = 'cities';



    public function getName(): string
    {
        return $this->name;
    }

    public function load(int $id): City
    {
        $db = new DBHelper();
        $city = $db->select()->from(self::TABLE)->where('id',(string)$id)->getOne();
        $this->id = (int)$city['id'];
        $this->name = (string)$city['name'];
        return $this;
    }
    public static function getCities(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $cities = [];
        foreach ($data as $element){
            $city = new City();
            $city->load($element['id']);
            $cities[] = $city;
        }
        return $cities;
    }


}


