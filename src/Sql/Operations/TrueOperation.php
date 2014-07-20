<?php

namespace Sql\Operations;

use Sql\AbstractOperation;
use Sql\Environment;

class TrueOperation extends AbstractOperation
{
    public function __construct()
    {
        parent::__construct('true');
    }

    public function run(Environment $environment)
    {
        return "true";
    }
}