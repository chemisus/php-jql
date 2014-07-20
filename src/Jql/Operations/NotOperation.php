<?php

namespace Jql\Operations;

use Jql\AbstractValueOperation;
use Jql\Environment;
use Jql\Operation;

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
        return !$this->value()->run($environment);
    }
}