<?php

namespace Sql\Operations;

use Sql\AbstractValueOperation;
use Sql\Environment;
use Sql\Operation;

class NotOperation extends AbstractValueOperation
{
    /**
     * @param Operation $value
     */
    public function __construct(Operation $value)
    {
        parent::__construct('not', $value);
    }

    public function run(Environment $environment)
    {
        return "not (" . $this->value()->run($environment) . ")";
    }
}