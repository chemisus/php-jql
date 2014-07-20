<?php

namespace Jql\Operations;

use Jql\AbstractOperation;
use Jql\Environment;

class TrueOperation extends AbstractOperation
{
    public function __construct()
    {
        parent::__construct('true');
    }

    public function run(Environment $environment)
    {
        return true;
    }
}