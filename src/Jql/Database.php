<?php

namespace Jql;

class Database
{
    private $tables;

    public function __construct($tables)
    {
        $this->tables = $tables;
    }

    public function table($name)
    {
        return $this->tables[$name];
    }
}