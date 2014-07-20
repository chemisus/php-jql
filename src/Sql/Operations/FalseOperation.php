<?php

namespace Sql\Operations;

use Sql\AbstractOperation;
use Sql\Environment;

class FalseOperation extends AbstractOperation
{
    public function __construct()
    {
        parent::__construct('false');
    }

    public function run(Environment $environment)
    {
        return "false";
    }
}