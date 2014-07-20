<?php

namespace Sql;

use stdClass;

abstract class AbstractValueOperation extends AbstractOperation
{
    /**
     * @var \Sql\Operation
     */
    private $value;

    /**
     * @param string $op
     * @param Operation $value
     */
    public function __construct($op, Operation $value)
    {
        parent::__construct($op);

        $this->value = $value;
    }

    public function fillJsonObject(stdClass $object)
    {
        $object->value = $this->value->toJson();
    }

    /**
     * @return Operation
     */
    public function value()
    {
        return $this->value;
    }
}