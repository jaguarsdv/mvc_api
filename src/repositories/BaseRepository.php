<?php

namespace src\repositories;

class BaseRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * @var \Doctrine\DBAL\Query\QueryBuilder
     */
    protected $query_builder;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->query_builder = $this->connection->createQueryBuilder();
    }
}
