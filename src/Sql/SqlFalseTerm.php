<?php

namespace Sql;

use AbstractHardValueTerm;

class SqlFalseTerm extends AbstractHardValueTerm
{
    public function __construct()
    {
        parent::__construct('false', 'false');
    }
}