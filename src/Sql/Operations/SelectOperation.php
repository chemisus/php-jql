<?php

namespace Sql\Operations;

use Sql\AbstractValueOperation;
use Sql\Environment;
use Sql\Operation;

class SelectOperation extends AbstractValueOperation
{
    public function __construct(Operation $value)
    {
        parent::__construct('select', $value);
    }

    public function run(Environment $environment)
    {
        return $environment->get($environment->current(), $this->value()->run($environment));
    }
}