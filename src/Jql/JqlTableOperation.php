<?php

namespace Jql;

use AbstractSoftValueTerm;
use Environment;

class JqlTableOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('table');
    }

    public function operate(Environment $env, $term)
    {
        return array($term => $env->entity($term));
    }
}