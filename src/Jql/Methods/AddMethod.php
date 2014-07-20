<?php

namespace Jql\Methods;

use Jql\Environment;
use Jql\Method;
use Jql\Operation;

class AddMethod implements Method
{
    public function call(Environment $environment, $value)
    {
        return $environment->current() + $value;
    }
}