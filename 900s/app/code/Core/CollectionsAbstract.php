<?php

namespace Core;

use Aura\SqlQuery\QueryFactory;

class CollectionsAbstract
{
    protected QueryFactory $queryFactory;
    protected DB $db;
    /**
     * @var \Aura\SqlQuery\AbstractQuery|\Aura\SqlQuery\Common\SelectInterface
     */
    protected $select;

    public function __construct()
    {

        $this->queryFactory = new QueryFactory('Mysql');
        $this->db = new DB();
        $this->select = $this->queryFactory->newSelect();
        $this->select->cols(['*'])->from(static::TABLE);

    }

    public function fieldsToSelect(array $fields)
    {
        $this->select->cols($fields);
        return $this;
    }

    public function filter(string $field, string $value, string $operator = '='): CollectionsAbstract
    {
        $statement = "$field $operator :$field";
        $this->select->where($statement);
        $this->select->bindValue($field, $value);
        return $this;
    }
}