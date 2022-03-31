<?php

namespace Core;

class DB
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        try {
            $conn = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }
    public function get($sql)
    {
        $sth = $this->pdo->prepare($sql->getStatement());
        $sth->execute($sql->getBindValues());
        return $sth->fetch(\PDO::FETCH_ASSOC);

    }
    public function getAll($sql)
    {
        $sth = $this->pdo->prepare($sql->getStatement());
        $sth->execute($sql->getBindValues());
        return $sth->fetchAll(\PDO::FETCH_ASSOC);

    }
}