<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Comments extends AbstractModel implements ModelInterface
{

    private int $adId;
    private int $userId;
    private string $comment;
    private string $createdAt;



    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAdId(): int
    {
        return $this->adId;
    }

    public function setAdId(int $adId): void
    {
        $this->adId = $adId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    protected const TABLE = 'comments';

    public function load(int $id): Comments
    {
        $db = new DBHelper();
        $comment = $db->select()->from(self::TABLE)->where('id',(string)$id)->getOne();
        $this->id = (int)$comment['id'];
        $this->adId = (int)$comment['ad_id'];
        $this->userId = (int)$comment['user_id'];
        $this->comment = (string)$comment['comment'];
        $this->createdAt = (string)$comment['created_at'];
        return $this;
    }
    public function assignData(): void
    {
        $this->data = [
            "comment" => $this->comment,
            "user_id" => $this->userId,
            "ad_id" => $this->adId
        ];
    }
    public static function getAdComments(int $adId): array
    {
        $db = new DBHelper();
        $data = $db->select('id')->from(self::TABLE)->where('ad_id', (string)$adId)->get();
        $comments = [];
        foreach ($data as $element){
            $comment = new Comments();
            $comment->load((int)$element['id']);
            $comments[] = $comment;
        }

        return $comments;
    }
    public function getUser(int $userId): User
    {
        $user = new User();
        return $user->load($userId);
    }

}