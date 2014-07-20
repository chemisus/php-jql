<?php

namespace Sql;

class Connection
{
    private $pdo;

    public function __construct()
    {
        $database = 'homestead';
        $username = 'homestead';
        $password = 'secret';
        $host = 'localhost';

        $this->pdo = new PDO("pgsql:dbname=$database;host=$host", $username, $password);
    }

    public function prepare($statement)
    {
        return new Statement($this->pdo->prepare($statement));
    }
}