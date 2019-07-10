<?php

namespace src\repositories;

class BaseRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }
}
