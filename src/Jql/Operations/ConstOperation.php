<?php

namespace Jql\Operations;

use Jql\AbstractValueOperation;
use Jql\Environment;
use Jql\Operation;

class ConstOperation extends AbstractValueOperation
{
    public function __construct(Operation $value)
    {
        parent::__construct('const', $value);
    }

    public function run(Environment $environment)
    {
        return $this->value();
    }
}