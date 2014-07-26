<?php

namespace Jql;

use AbstractHardValueTerm;

class JqlFalseTerm extends AbstractHardValueTerm
{
    public function __construct()
    {
        parent::__construct('false', false);
    }
}