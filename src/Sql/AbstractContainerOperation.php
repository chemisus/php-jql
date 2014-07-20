<?php

namespace Sql;

use stdClass;

abstract class AbstractContainerOperation extends AbstractOperation
{
    /**
     * @var \Sql\Operation
     */
    private $values;

    /**
     * @param string $op
     * @param OperationContainer $values
     */
    public function __construct($op, OperationContainer $values)
    {
        parent::__construct($op);

        $this->values = $values;
    }

    public function fillJsonObject(stdClass $object)
    {
        $object->values = $this->values->toJson();
    }

    /**
     * @return Operation[]
     */
    public function values()
    {
        return $this->values;
    }
}