<?php
declare(strict_types=1);
namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

Class Model extends AbstractModel implements ModelInterface
{


    private string $model;

    private int $manufacturer_id;

    public function getModel(): string
    {
        return $this->model;
    }

    public function getManufacturerId(): int
    {
        return $this->manufacturer_id;
    }

    public function load(int $id): Model
    {
        $db = new DBHelper();
        $model = $db->select()->from('model_id')->where('id',(string)$id)->getOne();
        $this->id = (int)$model['id'];
        $this->model = $model['model'];
        $this->manufacturer_id = (int)$model['manufacturer_id'];
        return $this;
    }

    public static function getModels(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from("model_id")->get();
        $models = [];
        foreach ($data as $element) {
            $model = new Model();
            $model->load((int)$element['id']);
            $models[] = $model;
        }
        return $models;
    }


    public function assignData(): void
    {
        // Not needed
    }
}