<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Comments extends AbstractModel
{
    private $adId;
    private $userId;
    private $comment;
    private $createdAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAdId()
    {
        return $this->adId;
    }

    public function setAdId($adId): void
    {
        $this->adId = $adId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    protected const TABLE = 'comments';

    public function load($id)
    {
        $db = new DBHelper();
        $comment = $db->select()->from(self::TABLE)->where('id',$id)->getOne();
        $this->id = $comment['id'];
        $this->adId = $comment['ad_id'];
        $this->userId = $comment['user_id'];
        $this->comment = $comment['comment'];
        $this->createdAt = $comment['created_at'];
        return $this;
    }
    protected function assignData()
    {
        $this->data = [
            "comment" => $this->comment,
            "user_id" => $this->userId,
            "ad_id" => $this->adId
        ];
    }
    public static function getAdComments($adId)
    {
        $db = new DBHelper();
        $data = $db->select('id')->from(self::TABLE)->where('ad_id', $adId)->get();
        $comments = [];
        foreach ($data as $element){
            $comment = new Comments();
            $comment->load($element['id']);
            $comments[] = $comment;
        }

        return $comments;
    }
    public function getUser($userId)
    {
        $user = new User();
        return $user->load($userId);
    }

}