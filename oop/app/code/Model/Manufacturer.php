<?php
declare(strict_types=1);
namespace Model;

use Core\AbstractController;
use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

Class Manufacturer extends AbstractModel implements ModelInterface
{
    protected int $manufacturerId;

    private  string $manufacturer;

    public function getManufacturerId(): int
    {
        return $this->manufacturerId;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }
    protected const TABLE = 'manufacturer_id';
    public function load(int $id): Manufacturer
    {
        $db = new DBHelper();
        $manufacturer = $db->select()->from(self::TABLE)->where('id',(string)$id)->getOne();
        $this->id = (int)$manufacturer['id'];
        $this->manufacturer = $manufacturer['manufacturer'];
        return $this;
    }
    public static function getManufacturers(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $manufacturers = [];
        foreach ($data as $element) {
            $manu = new Manufacturer();
            $manu->load((int)$element['id']);
            $manufacturers[] = $manu;
        }
        return $manufacturers;
    }

    public function assignData(): void
    {
        // this method will never born
    }
}