<?php

namespace Jql;

use stdClass;

class AbstractContainerOperation extends AbstractOperation
{
    /**
     * @var \Jql\Operation
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

    public function run(Environment $environment)
    {
        return $this->values->run($environment) === $this->rhs->run($environment);
    }

    /**
     * @return OperationContainer
     */
    public function values()
    {
        return $this->values;
    }
}