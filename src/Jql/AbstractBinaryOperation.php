<?php

namespace Jql;

use stdClass;

abstract class AbstractBinaryOperation extends AbstractOperation
{
    /**
     * @var \Jql\Operation
     */
    private $lhs;

    /**
     * @var \Jql\Operation
     */
    private $rhs;

    /**
     * @param $op
     * @param Operation $lhs
     * @param Operation $rhs
     */
    public function __construct($op, Operation $lhs, Operation $rhs)
    {
        parent::__construct($op);

        $this->lhs = $lhs;
        $this->rhs = $rhs;
    }

    public function fillJsonObject(stdClass $object)
    {
        $object->lhs = $this->lhs->toJson();
        $object->rhs = $this->rhs->toJson();
    }

    /**
     * @return Operation
     */
    public function lhs()
    {
        return $this->lhs;
    }

    /**
     * @return Operation
     */
    public function rhs()
    {
        return $this->rhs;
    }
}