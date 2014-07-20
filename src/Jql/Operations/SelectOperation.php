<?php

namespace Jql\Operations;

use Jql\AbstractValueOperation;
use Jql\Environment;
use Jql\Operation;

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