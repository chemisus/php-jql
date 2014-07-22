<?php

namespace Sql\Operations;

use Sql\Environment;
use Sql\Operation;

class ParamOperation implements Operation
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function run(Environment $environment)
    {
        return ':' . $this->key;
    }
}