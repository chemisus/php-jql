<?php

namespace Jql\Operations;

use Jql\AbstractOperation;
use Jql\Environment;

class FalseOperation extends AbstractOperation
{
    public function __construct()
    {
        parent::__construct('false');
    }

    public function run(Environment $environment)
    {
        return false;
    }
}