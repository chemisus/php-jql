<?php

namespace Sql\Operations;

use Sql\AbstractBinaryOperation;
use Sql\Environment;
use Sql\Operation;

class EqualOperation extends AbstractBinaryOperation
{
    /**
     * @param Operation $lhs
     * @param Operation $rhs
     */
    public function __construct(Operation $lhs, Operation $rhs)
    {
        parent::__construct('equal', $lhs, $rhs, 'lhs', 'rhs');
    }

    public function run(Environment $environment)
    {
        return $this->a()->run($environment) . "=" . $this->b()->run($environment);
    }
}