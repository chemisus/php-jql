<?php

namespace Sql;

use AbstractHardValueTerm;

class SqlTrueTerm extends AbstractHardValueTerm
{
    public function __construct()
    {
        parent::__construct('true', 'true');
    }
}