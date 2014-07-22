<?php

namespace Sql;

use PDOStatement;

class Statement
{
    private $statement;

    public function __construct(PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function execute(array $parameters = array())
    {
        $this->statement->execute($parameters);

        return $this->statement->fetchAll();
    }
}