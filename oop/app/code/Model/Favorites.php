<?php
declare(strict_types=1);
namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Favorites extends AbstractModel implements ModelInterface
{
    private int $adId;
    private int $userId;
    public bool $favorite;
    protected const TABLE = 'favorites';

    /**
     * @return int
     */
    public function getAdId(): int
    {
        return $this->adId;
    }

    /**
     * @param int $adId
     */
    public function setAdId(int $adId): void
    {
        $this->adId = $adId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return bool
     */
    public function isFavorite(): bool
    {
        return $this->favorite;
    }

    /**
     * @param bool $favorite
     */
    public function setFavorite(bool $favorite): void
    {
        $this->favorite = $favorite;
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $rez = $db->select()->from(self::TABLE)->where('id', (string) $id)->getOne();
        if (!empty($rez)){
            $this->id = (int)$rez['id'];
            $this->adId = (int)$rez['ad_id'];
            $this->userId = (int)$rez['user_id'];
            $this->favorite = (bool)$rez['favorite'];
        }
        return $this;
    }
    public function assignData(): void
    {
        $this->data = [
            'user_id' => $this->userId,
            'ad_id' => $this->adId,
            'favorite' => $this->favorite
        ];
    }

    public static function loadUserFavorites(int $userId): array
    {
        $db = new DBHelper();
        $data = $db
            ->select()
            ->from(self::TABLE)
            ->where('user_id', (string) $userId)
            ->andWhere('favorite', (string) 1)
            ->get();
        $favorites = [];
        foreach ($data as $element){
            $favorite = new Ad();
            $favorite->load((int)$element['ad_id']);
            $favorites[] = $favorite;
        } return $favorites;
    }

    public function isAdFavoriteByUser(int $userId, int $adId): bool
    {
        $db=new DBHelper();
        $rez = $db
            ->select()
            ->from(self::TABLE)
            ->where('user_id', (string) $userId)
            ->andWhere('ad_id', (string) $adId)
            ->getOne();
        if (!empty($rez)){

            return true;
        }
        return false;
    }

    public static function removeFromFavorites(int $userId, int $adId): void
    {
        $db = new DBHelper();
        $db->delete()->from(self::TABLE)->where('user_id', (string) $userId)->andWhere('ad_id', (string) $adId)->exec();
    }
    public static function getUsersByAd($adId): array
    {
        $db = new DBHelper();
        $data = $db
            ->select()
            ->from(self::TABLE)
            ->where('ad_id', $adId)
            ->get();
        $usersIds = [];
        foreach ($data as $user){
            $usersIds[] = $user['user_id'];
        } return $usersIds;
    }
}