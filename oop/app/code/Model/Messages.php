<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Messages extends AbstractModel implements ModelInterface
{
    protected $id;
    private $userFrom;
    private $userTo;
    private $dateSent;
    private $message;
    private $opened;

    /**
     * @return mixed
     */
    public function getOpened()
    {
        return $this->opened;
    }

    /**
     * @param mixed $opened
     */
    public function setOpened($opened): void
    {
        $this->opened = $opened;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * @param mixed $userFrom
     */
    public function setUserFrom($userFrom): void
    {
        $this->userFrom = $userFrom;
    }

    /**
     * @return mixed
     */
    public function getUserTo()
    {
        return $this->userTo;
    }

    /**
     * @param mixed $userTo
     */
    public function setUserTo($userTo): void
    {
        $this->userTo = $userTo;
    }

    /**
     * @return mixed
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * @param mixed $dateSent
     */
    public function setDateSent($dateSent): void
    {
        $this->dateSent = $dateSent;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
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


    public function load($id)
    {
        $db = new DBHelper();
        $message = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $message['id'];
        $this->userFrom = $message['user_from'];
        $this->userTo = $message['user_to'];
        $this->dateSent = $message['date_sent'];
        $this->message = $message['message'];
        $this->opened = $message['opened'];
        return $this;
    }

    public function assignData()
    {
        $this->data = [
            "user_from" => $this->userFrom,
            "user_to" => $this->userTo,
            "message" => $this->message,
            "opened" => $this->opened
        ];
    }

    public static function getNewMessages($userId)
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

    public static function getAllMessages($userId)
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

    public static function countNewMessages($userId)
    {
        $db = new DBHelper();
        $rez = $db->select('count(*)')->from(self::TABLE)->where('user_to', $userId)
            ->andWhere('opened', 0)->get();
        return $rez[0][0];
    }
    public function getUser()
    {
        return new User($this->userFrom);
    }
}