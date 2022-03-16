<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Ad extends AbstractModel implements ModelInterface
{

    private string $title;
    private string $description;
    private int $manufacturerId;
    private Manufacturer $manufacturer;
    private int $modelId;
    private Model $model;
    private float $price;
    private int $year;
    private int $typeId;
    private Type $type;
    private int $userId;
    private string $pictureUrl;
    private bool $active;
    private string $slug;
    private string $vin;
    private int $count;
    protected const TABLE = 'ad';

    /**
     * @return mixed
     */
    public function getCount() :int
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getVin() :string
    {
        return $this->vin;
    }

    /**
     * @param mixed $vin
     */
    public function setVin(string $vin): void
    {
        $this->vin = $vin;
    }

    /**
     * @return mixed
     */
    public function getSlug() :string
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getActive() :bool
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getPictureUrl() :string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(string $pictureUrl): void
    {
        $this->pictureUrl = $pictureUrl;
    }

    public function getTitle() :string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getManufacturerId(): int
    {
        return $this->manufacturerId;
    }

    /**
     * @param mixed $manufacturer_id
     */
    public function setManufacturerId(int $manufacturerId): void
    {
        $this->manufacturerId = $manufacturerId;
    }

    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    /**
     * @return mixed
     */
    public function getModelId(): int
    {
        return $this->modelId;
    }

    /**
     * @param mixed $model_id
     */
    public function setModelId(int $modelId): void
    {
        $this->modelId = $modelId;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * @param mixed $typeId
     */
    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }
    public function __construct($id = null)
    {
        if($id !== null){
            $this->load($id);
        }

    }

    public static function getAllAds(?int $page = null, ?int $limit = null) :array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->orderBy('id');
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
    public static function getAllActiveAds(?int $page = null, ?int $limit = null): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('active', 1)->orderBy('id');
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

    public function load(int $id): Ad
    {
        $db = new DBHelper();
        $ad = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($ad)) {
            $this->id = (int)$ad['id'];
            $this->title = (string)$ad['title'];
            $this->description = (string)$ad['description'];
            $this->vin = (string)$ad['vin'];
            $this->userId = (int)$ad['user_id'];
            $this->slug = (string)$ad['slug'];
            $this->active = (bool)$ad['active'];
            $this->manufacturerId = (int)$ad['manufacturer_id'];
            $manufacturer = new Manufacturer();
            $this->manufacturer = $manufacturer->load($this->manufacturerId);
            $this->modelId = (int)$ad['model_id'];
            $model = new Model();
            $this->model = $model->load($this->modelId);
            $this->price = (float)$ad['price'];
            $this->year = (int)$ad['year'];
            $this->typeId = (int)$ad['type_id'];
            $type = new Type();
            $this->type = $type->load($this->typeId);
            $this->pictureUrl = (string)$ad['picture_url'];
            $this->count = (int)$ad['count'];

        }
        return $this;
    }

    public static function getSortedAds(string $order, string $sort): array
    {
        $db = new DBHelper();
        $data = $db->select()
            ->from(self::TABLE)
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

    public static function viewCount(int $id): void
    {
        $db = new DBHelper();
        $counts = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        foreach ($counts as $count) {
            $count++;
        }
        $data = [
            'count' => $count
        ];
        $db = new DBHelper();
        $db->update(self::TABLE, $data)->where('id', $id)->exec();

    }



    public function loadBySlug(string $slug): ?Ad
    {
        $db = new DBHelper();
        $rez = $db->select()->from(self::TABLE)->where('slug', $slug)->getOne();
        if (!empty($rez)) {
            $this->load($rez['id']);
            } return $this;
    }

    public function assignData(): void
    {
        $this->data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturerId,
            'model_id' => $this->modelId,
            'vin' => $this->vin,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->typeId,
            'picture_url' => $this->pictureUrl,
            'user_id' => $this->userId,
            'active' => $this->active,
            'count' => $this->count
        ];

    }
    public function getComments(): array
    {
        return Comments::getAdComments($this->id);
    }
    public function getUser(): User
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("users")->where("id", $this->userId)->getOne();
        $user = new User();

        return $user->load($data["id"]);
    }


}