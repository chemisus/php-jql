<?php

namespace Jql;

use AbstractEnvironment;
use TermReader;

class JqlEnvironment extends AbstractEnvironment
{
    private $tables;
    private $stack = array();

    public function __construct(TermReader $term_reader, $tables)
    {
        parent::__construct($term_reader, array(
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
            new JqlAliasOperation(),
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

    public function execute($query)
    {
        return $this->run($query);
    }
}