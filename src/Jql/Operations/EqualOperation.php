<?php

namespace Jql\Operations;

use Jql\AbstractBinaryOperation;
use Jql\Environment;
use Jql\Operation;

class EqualOperation extends AbstractBinaryOperation
{
    /**
     * @param Operation $value
     * @param Operation $rhs
     */
    public function __construct(Operation $value, Operation $rhs)
    {
        parent::__construct('equal', $value, $rhs);
    }

    public function run(Environment $environment)
    {
        return $this->lhs()->run($environment) === $this->rhs()->run($environment);
    }
}