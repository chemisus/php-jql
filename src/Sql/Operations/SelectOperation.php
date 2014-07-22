<?php

namespace Sql\Operations;

use Sql\AbstractOperation;
use Sql\Environment;
use Sql\Operation;
use Sql\OperationContainer;

class SelectOperation extends AbstractOperation
{
    private $fields;
    private $from;
    private $joins;
    private $where;

    /**
     * @param OperationContainer $fields
     * @param Operation $from
     * @param OperationContainer $joins
     * @param OrOperation $where
     */
    public function __construct(OperationContainer $fields, Operation $from, OperationContainer $joins, OrOperation $where)
    {
        parent::__construct('select');

        $this->fields = $fields;
        $this->from = $from;
        $this->joins = $joins;
        $this->where = $where;
    }

    public function run(Environment $env)
    {
        $string = '';

        $string .= "select ";
        $string .= implode(',', $this->fields->run($env));
        $string .= " from " . $this->from->run($env);
        $string .= implode('', $this->joins->run($env));
        $string .= " where " . $this->where->run($env);

        return $string;
    }
}