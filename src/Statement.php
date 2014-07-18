<?php

class Statement
{
    private $statement;

    public function __construct(PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function execute()
    {
        $this->statement->execute();

        return $this->statement->fetchAll();
    }
}