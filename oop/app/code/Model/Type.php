<?php
declare(strict_types=1);
namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

Class Type extends AbstractModel
{


    private string $type;


    /**
     * @return mixed
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function load(int $id): Type
    {
        $db = new DBHelper();
        $type = $db->select()->from('type_id')->where ('id', (string)$id)->getOne();
        $this->id = (int)$type['id'];
        $this->type = $type['type'];
        return $this;
    }
    public static function getTypes(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from('type_id')->get();
        $types = [];
        foreach ($data as $element){
            $type = new Type();
            $type->load((int)$element['id']);
            $types[] = $type;
        }
        return $types;
    }
}