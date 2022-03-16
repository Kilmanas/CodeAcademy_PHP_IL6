<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Messages extends AbstractModel implements ModelInterface
{
    private int $userFrom;
    private int $userTo;
    private string $date;
    private string $message;
    private bool $opened;

    /**
     * @return mixed
     */
    public function getOpened(): bool
    {
        return $this->opened;
    }

    /**
     * @param mixed $opened
     */
    public function setOpened(bool $opened): void
    {
        $this->opened = $opened;
    }


    /**
     * @return mixed
     */
    public function getUserFrom(): int
    {
        return $this->userFrom;
    }

    /**
     * @param mixed $userFrom
     */
    public function setUserFrom(int $userFrom): void
    {
        $this->userFrom = $userFrom;
    }

    /**
     * @return mixed
     */
    public function getUserTo(): int
    {
        return $this->userTo;
    }

    /**
     * @param mixed $userTo
     */
    public function setUserTo(int $userTo): void
    {
        $this->userTo = $userTo;
    }

    /**
     * @return mixed
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate (string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    protected const TABLE = 'messages';

    public function __construct($id = null)
    {
        if ($id !== null) {
            $this->load($id);
        }
    }


    public function load(int $id): Messages
    {
        $db = new DBHelper();
        $message = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$message['id'];
        $this->userFrom = (int)$message['user_from'];
        $this->userTo = (string)$message['user_to'];
        $this->date = (string)$message['date_sent'];
        $this->message = (string)$message['message'];
        $this->opened = (bool)$message['opened'];
        return $this;
    }

    public function assignData(): void
    {
        $this->data = [
            "user_from" => $this->userFrom,
            "user_to" => $this->userTo,
            "message" => $this->message,
            "opened" => $this->opened
        ];
    }

    public static function getNewMessages(int $userId): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('user_to', $userId)->andWhere('opened', 0)->get();
        $messages = [];

        foreach ($data as $element) {
            $message = new Messages($element['id']);
            $messages[] = $message;
        }

        return $messages;
    }

    public static function getAllMessages(int $userId): array
    {
        $db = new DBHelper();
        $data = $db->select()
            ->from(self::TABLE)
            ->where('user_to', $userId)
            ->orderBy('opened', 'ASC')
            ->get();
        $messages = [];
        foreach ($data as $element) {
            $message = new Messages();
            $message->load($element['id']);
            $messages[] = $message;
        }
        return $messages;
    }

    public static function countNewMessages(int $userId): int
    {
        $db = new DBHelper();
        $rez = $db->select('count(*)')
            ->from(self::TABLE)
            ->where('user_to', $userId)
            ->andWhere('opened', 0)
            ->get();
        return (int)$rez[0][0];
    }
    public function getUser(): User
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("users")->where("id", $this->userFrom)->getOne();
        $user = new User();

        return $user->load($data["id"]);
    }
    public static function getChatMessages(int $fromId, int $toId): array
    {
        $db = new DBHelper();
        $data = $db->select()
            ->from(self::TABLE)
            ->where('user_from', $fromId)
            ->andWhere('user_to', $toId)
            ->get();
        $messages = [];
        foreach ($data as $element) {
            $message = new Messages();
            $message->load($element['id']);
            $messages[] = $message;
        }
        return $messages;
    }
    public static function getUserMessages()
    {
        $db = new DBHelper();
        $userId = $_SESSION['user_id'];
        $data = $db->select()->from(self::TABLE)->where('user_from', $userId)->orWhere('user_to', $userId)->get();
        $messages = [];
            foreach ($data as $element) {
               $message = new Messages();
               $message->load($element['id']);
               $messages [] = $message;
            } return $messages;
    }
    public static function getMessagesWithFriend($friendId)
    {
        $db = new DBHelper();
        $userId = $_SESSION['user_id'];
        $data = $db->select()
            ->from(self::TABLE)
            ->where('user_from', $userId)
            ->andWhere('user_to', $friendId)
            ->orWhere('user_from', $friendId)
            ->andWhere('user_to', $userId)
            ->get();
        $messages = [];
        foreach ($data as $element) {
            $message = new Messages();
            $message->load($element['id']);
            $messages [] = $message;
        }
        return $messages;
    }
    public static function setSeen($senderId, $receiverId)
    {
        $db = new DBHelper();
        $db->update(self::TABLE, ['opened' => 1])->where('user_from', $senderId)->andWhere('user_to', $receiverId)->andWhere('opened', 0)->exec();
    }
}