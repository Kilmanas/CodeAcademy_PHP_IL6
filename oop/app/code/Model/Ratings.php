<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Ratings extends AbstractModel implements ModelInterface
{
    private int $adId;
    private int $userId;
    public int $rank;
    protected const TABLE = 'ad_ranking';

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
     * @return float
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param float $rank
     */
    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }
    public function load(int $id): Ratings
    {
        $db = new DBHelper();
        $rank = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($rank)){
        $this->id = (int)$rank['id'];
        $this->adId = (int)$rank['ad_id'];
        $this->userId = (int)$rank['user_id'];
        $this->rank = (int)$rank['rank'];
        }
        return $this;
    }
    public function assignData(): void
    {
       $this->data = [
         'user_id' => $this->userId,
         'ad_id' => $this->adId,
         'rank' => $this->rank
       ];
    }
    public function loadByUserAndAd(int $userId, int $adId):? object
    {
        $db=new DBHelper();
        $rez = $db
            ->select()
            ->from(self::TABLE)
            ->where('user_id', $userId)
            ->andWhere('ad_id', $adId)
            ->getOne();
        if (!empty($rez)){
            $this->load($rez['id']);
            return $this;
        }
        return null;
    }

    public static function getAdRating(int $adId): array
    {
        $db = new DBHelper();
        return $db->select()->from(self::TABLE)->where('ad_id', $adId)->get();
    }
    public function getUser()
    {
        $user = new User();
        $user->load($this->userId);
        return $user;
    }
    public function getAd()
    {
        $ad = new Ad();
        $ad->load($this->adId);
        return $ad;
    }
    public static function getRatingsByUser()
    {

    }
}