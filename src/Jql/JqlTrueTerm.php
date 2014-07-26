<?php

namespace Jql;

use AbstractHardValueTerm;

class JqlTrueTerm extends AbstractHardValueTerm
{
    public function __construct()
    {
        parent::__construct('true', true);
    }
}