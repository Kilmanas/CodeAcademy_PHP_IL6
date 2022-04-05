<?php
declare(strict_types=1);
namespace Core;
use Aura\SqlQuery\QueryFactory;

class ModelAbstract
{
    protected QueryFactory $queryFactory;
    protected DB $db;

    public function __construct()
    {
        $this->queryFactory = new QueryFactory('Mysql');
        $this->db = new DB();
    }

    protected function select()
    {
        return $this->queryFactory->newSelect();
    }

    protected function insert()
    {
        return $this->queryFactory->newInsert();
    }

    protected function update()
    {
        return $this->queryFactory->newUpdate();
    }

    protected function delete()
    {
        return $this->queryFactory->newDelete();
    }


}