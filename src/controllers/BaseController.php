<?php

namespace src\controllers;

use Doctrine\DBAL\DriverManager;

class BaseController
{
    protected $request;
    protected $db;

    public function __construct($request)
    {
        $this->request = $request;
        $this->db = DriverManager::getConnection(
            require __DIR__ . '/../../config/db.php'
        );
    }
}
