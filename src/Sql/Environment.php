<?php

namespace Sql;

use Sql\Operation;

class Environment
{
    private $database;

    private $keys = array();
    private $values = array();

    private $parameters = array();
    private $counter = 1;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function run($operation)
    {
        return $this->database->prepare($operation)->execute($this->parameters);
    }

    public function addParameter($value)
    {
        $counter = $this->counter++;

        $this->parameters['p' . $counter] = $value;

        return 'p' . $counter;
    }
}
