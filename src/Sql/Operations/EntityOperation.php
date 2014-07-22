<?php

namespace Sql;

class EntityOperation implements Operation
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function run(Environment $environment)
    {
        return "{$this->value}";
    }
}