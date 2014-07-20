<?php

namespace Sql\Operations;

use Sql\AbstractContainerOperation;
use Sql\Environment;
use Sql\OperationContainer;
use stdClass;

class ObjectOperation extends AbstractContainerOperation
{
    public function __construct(OperationContainer $values)
    {
        parent::__construct('object', $values);
    }

    public function run(Environment $environment)
    {
        $object = new stdClass();

        foreach ($this->values() as $key => $value) {
            $object->{$key} = $value->run($environment);
        }

        return $object;
    }
}