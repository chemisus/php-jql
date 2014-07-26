<?php

namespace Jql;

use AbstractEnvironment;

class JqlEnvironment extends AbstractEnvironment
{
    private $tables;
    private $stack = array();

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
            new JqlFieldOperation(),
        ));

        $this->tables = $tables;
    }

    public function entity($entity)
    {
        return $this->tables[$entity];
    }

    public function push($value)
    {
        array_push($this->stack, $value);
    }

    public function current()
    {
        return end($this->stack);
    }

    public function pop()
    {
        array_pop($this->stack);
    }
}