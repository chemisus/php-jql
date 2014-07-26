<?php

namespace Jql;

use AbstractEnvironment;

class JqlEnvironment extends AbstractEnvironment
{
    private $tables;

    public function __construct($tables)
    {
        parent::__construct(array(
            new JqlTrueTerm(),
            new JqlFalseTerm(),
            new JqlEqualOperation(),
            new JqlNotOperation(),
            new JqlAndOperation(),
            new JqlOrOperation(),
            new JqlSelectOperation(),
            new JqlTableOperation(),
            new JqlEntityOperation(),
            new JqlParameterOperation(),
        ));

        $this->tables = $tables;
    }

    public function entity($entity)
    {
        return $this->tables[$entity];
    }
}