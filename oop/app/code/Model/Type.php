<?php
namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

Class Type extends AbstractModel
{
    protected $id;

    private $type;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $type = $db->select()->from('type_id')->where ('id', $id)->getOne();
        $this->id = $type['id'];
        $this->type = $type['type'];
        return $this;
    }
    public static function getTypes()
    {
        $db = new DBHelper();
        $data = $db->select()->from('type_id')->get();
        $types = [];
        foreach ($data as $element){
            $type = new Type();
            $type->load($element['id']);
            $types[] = $type;
        }
        return $types;
    }
}